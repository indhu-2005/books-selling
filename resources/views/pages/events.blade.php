@extends('layouts.app')

@section('title', 'Community Book Exchange Events & Meets')

@section('content')

<!-- Page Header Banner -->
<section class="page-header-banner">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Events</li>
            </ol>
        </nav>
        <h1 class="page-header-title">Book Exchange Meets & Literary Circles</h1>
        <p class="page-header-desc">
            Participate in offline community book swaps, campus textbook drives, and author interactions across major Indian cities and online webinars.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Event Type Pills -->
        <div class="d-flex align-items-center gap-2 overflow-auto pb-3 mb-4 border-bottom">
            <a href="{{ route('events') }}" class="category-pill {{ !$type ? 'active' : '' }}">
                <i class="fa-solid fa-calendar"></i> All Events
            </a>
            @foreach($eventTypes as $eType)
                <a href="{{ route('events', ['type' => $eType]) }}" class="category-pill {{ $type === $eType ? 'active' : '' }}">
                    <i class="fa-solid fa-tag"></i> {{ $eType }}
                </a>
            @endforeach
        </div>

        <!-- Events Grid -->
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-lg-6">
                    <div class="event-card">
                        <img src="{{ $event->image }}" alt="{{ $event->title }}" class="event-card-img">
                        <div class="event-card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="event-type-badge">{{ $event->event_type }}</span>
                                <span class="badge bg-success bg-opacity-10 text-success fw-semibold">{{ $event->entry_fee }}</span>
                            </div>

                            <h4 class="fw-bold fs-5 text-dark mb-2">{{ $event->title }}</h4>

                            <div class="event-date-row">
                                <i class="fa-regular fa-calendar-check"></i>
                                <span>{{ \Carbon\Carbon::parse($event->event_date)->format('l, F j, Y') }} • {{ $event->event_time }}</span>
                            </div>

                            <div class="event-location-row">
                                <i class="fa-solid fa-location-dot text-danger flex-shrink-0"></i>
                                <span>{{ $event->location }}</span>
                            </div>

                            @if($event->speaker)
                                <div class="small text-muted mb-3">
                                    <i class="fa-solid fa-microphone-lines text-primary me-1"></i> Hosted by: <strong>{{ $event->speaker }}</strong>
                                </div>
                            @endif

                            <p class="small text-muted lh-base mb-3">
                                {{ $event->description }}
                            </p>

                            <!-- Attendee Progress -->
                            <div class="mt-auto pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center small text-muted mb-1">
                                    <span>RSVPs: <strong>{{ $event->attendees_count }}</strong> registered</span>
                                    <span>Max: {{ $event->max_attendees }} seats</span>
                                </div>
                                <div class="progress mb-3" style="height: 6px;">
                                    @php
                                        $percent = min(100, round(($event->attendees_count / max(1, $event->max_attendees)) * 100));
                                    @endphp
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percent }}%"></div>
                                </div>

                                <button type="button" class="btn btn-primary w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#eventModal{{ $event->id }}">
                                    <i class="fa-solid fa-ticket me-2"></i> RSVP / Register (Free)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event RSVP Modal -->
                <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1" aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold" id="eventModalLabel{{ $event->id }}">
                                    <i class="fa-solid fa-calendar-check text-primary me-2"></i> Register for Event
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="mb-3 p-3 rounded-3 bg-light border">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $event->title }}</h6>
                                    <div class="small text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }} • {{ $event->event_time }}</div>
                                    <div class="small text-muted"><i class="fa-solid fa-location-dot me-1"></i> {{ $event->location }}</div>
                                </div>

                                <form action="{{ route('events.register', $event->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                        <input type="text" name="name" class="form-control" required placeholder="e.g. Indhumathi K" value="{{ auth()->user()->name ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                                        <input type="email" name="email" class="form-control" required placeholder="e.g. reader@example.com" value="{{ auth()->user()->email ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Mobile / WhatsApp Number</label>
                                        <input type="tel" name="phone" class="form-control" placeholder="+91 9876543210">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Books You Plan to Bring for Exchange (Optional)</label>
                                        <input type="text" name="books_to_exchange" class="form-control" placeholder="e.g. 3 Class 12 NCERT books, 2 Fiction novels">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                        Confirm Free Registration
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No events currently scheduled in this category.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $events->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

@endsection
