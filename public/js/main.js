/**
 * BooksApp - Book Exchange Platform JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
    // ----------------------------------------------------
    // 1. DYNAMIC SEARCH FUNCTIONALITY (Books, Authors, Categories)
    // ----------------------------------------------------
    const searchInputs = document.querySelectorAll('.live-search-input');

    searchInputs.forEach(input => {
        const container = input.closest('.search-container') || input.parentElement;
        let dropdown = container.querySelector('.search-dropdown-results');

        if (!dropdown) {
            dropdown = document.createElement('div');
            dropdown.className = 'search-dropdown-results';
            container.appendChild(dropdown);
        }

        let debounceTimer;

        input.addEventListener('input', function () {
            const query = this.value.trim();
            clearTimeout(debounceTimer);

            if (query.length < 2) {
                dropdown.style.display = 'none';
                dropdown.innerHTML = '';
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/api/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        let hasResults = false;

                        // Books
                        if (data.books && data.books.length > 0) {
                            hasResults = true;
                            html += `<div class="search-dropdown-header"><i class="fa-solid fa-book me-1"></i> Books (${data.books.length})</div>`;
                            data.books.forEach(book => {
                                html += `
                                    <a href="/books/${book.id}" class="search-dropdown-item">
                                        <img src="${book.image || 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=100'}" alt="${book.title}">
                                        <div class="search-dropdown-info">
                                            <div class="search-dropdown-title">${escapeHtml(book.title)}</div>
                                            <div class="search-dropdown-meta">by ${escapeHtml(book.author)} • <span class="badge bg-light text-dark">${escapeHtml(book.condition || 'Good')}</span></div>
                                        </div>
                                        <div class="search-dropdown-price">₹${Math.round(book.price)}</div>
                                    </a>
                                `;
                            });
                        }

                        // Authors
                        if (data.authors && data.authors.length > 0) {
                            hasResults = true;
                            html += `<div class="search-dropdown-header"><i class="fa-solid fa-feather-pointed me-1"></i> Authors (${data.authors.length})</div>`;
                            data.authors.forEach(author => {
                                html += `
                                    <a href="/books?author=${encodeURIComponent(author.slug)}" class="search-dropdown-item">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:34px; height:34px; font-size:14px;">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <div class="search-dropdown-info">
                                            <div class="search-dropdown-title">${escapeHtml(author.name)}</div>
                                            <div class="search-dropdown-meta">${escapeHtml(author.genre || 'Author')}</div>
                                        </div>
                                        <div class="text-primary small"><i class="fa-solid fa-arrow-right"></i></div>
                                    </a>
                                `;
                            });
                        }

                        // Categories
                        if (data.categories && data.categories.length > 0) {
                            hasResults = true;
                            html += `<div class="search-dropdown-header"><i class="fa-solid fa-tags me-1"></i> Categories (${data.categories.length})</div>`;
                            data.categories.forEach(cat => {
                                html += `
                                    <a href="/books?category=${encodeURIComponent(cat.slug)}" class="search-dropdown-item">
                                        <div class="rounded-circle bg-light text-primary d-flex align-items-center justify-content-center" style="width:34px; height:34px; font-size:14px;">
                                            <i class="fa-solid ${cat.icon || 'fa-book'}"></i>
                                        </div>
                                        <div class="search-dropdown-info">
                                            <div class="search-dropdown-title">${escapeHtml(cat.name)}</div>
                                            <div class="search-dropdown-meta">Explore category</div>
                                        </div>
                                        <div class="text-primary small"><i class="fa-solid fa-arrow-right"></i></div>
                                    </a>
                                `;
                            });
                        }

                        if (hasResults) {
                            html += `
                                <a href="/books?search=${encodeURIComponent(query)}" class="search-dropdown-item justify-content-center text-primary fw-bold small py-2 bg-light">
                                    View all results for "${escapeHtml(query)}" →
                                </a>
                            `;
                            dropdown.innerHTML = html;
                            dropdown.style.display = 'block';
                        } else {
                            dropdown.innerHTML = `
                                <div class="p-3 text-center text-muted small">
                                    <i class="fa-solid fa-magnifying-glass mb-2 d-block text-secondary" style="font-size:20px;"></i>
                                    No books or authors found for "<strong>${escapeHtml(query)}</strong>"
                                </div>
                            `;
                            dropdown.style.display = 'block';
                        }
                    })
                    .catch(() => {
                        dropdown.style.display = 'none';
                    });
            }, 250);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!container.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    });

    // ----------------------------------------------------
    // 2. PAYMENT METHODS TABS & SELECTORS
    // ----------------------------------------------------
    const tabButtons = document.querySelectorAll('.payment-tab-btn');
    const tabPanes = document.querySelectorAll('.payment-tab-pane');
    const paymentMethodInput = document.getElementById('selected_payment_method');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            tabButtons.forEach(b => b.classList.remove('active'));
            tabPanes.forEach(p => p.classList.add('d-none'));

            this.classList.add('active');
            const targetId = this.getAttribute('data-target');
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.remove('d-none');
            }

            const defaultMethod = this.getAttribute('data-method');
            if (paymentMethodInput && defaultMethod) {
                paymentMethodInput.value = defaultMethod;
            }
        });
    });

    // App Options in UPI tab
    const upiAppOptions = document.querySelectorAll('.upi-app-option');
    upiAppOptions.forEach(opt => {
        opt.addEventListener('click', function () {
            upiAppOptions.forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            const method = this.getAttribute('data-method');
            if (paymentMethodInput) {
                paymentMethodInput.value = method;
            }
        });
    });

    // ----------------------------------------------------
    // 3. UTILITY HELPER FUNCTIONS
    // ----------------------------------------------------
    function escapeHtml(string) {
        if (!string) return '';
        return String(string)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
