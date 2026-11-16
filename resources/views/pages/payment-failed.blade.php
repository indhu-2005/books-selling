@extends('layouts.app')

@section('title', 'Payment Failed - BooksApp')

@section('content')

<section class="py-5 min-vh-100 d-flex align-items-center">
    <div class="container max-w-600">
        <div class="card border-0 shadow-lg rounded-4 p-5 text-center bg-white">
            <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; font-size: 36px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <h2 class="fw-bold text-dark mb-2">Payment Incomplete</h2>
            <p class="text-muted mb-4">
                {{ $reason ?? 'The bank transaction was declined or canceled. No funds have been deducted from your account.' }}
            </p>

            <div class="p-3 bg-light rounded-3 border text-start small text-muted mb-4">
                <strong class="text-dark d-block mb-1"><i class="fa-solid fa-circle-info text-primary me-1"></i> Common causes:</strong>
                <ul class="mb-0 ps-3">
                    <li>Incorrect UPI PIN or timeout in the payment application</li>
                    <li>Insufficient funds or daily transaction limit exceeded</li>
                    <li>Bank server downtime or temporary network interruption</li>
                </ul>
            </div>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ url()->previous() }}" class="btn btn-primary px-4 py-2">
                    <i class="fa-solid fa-rotate-left me-2"></i> Try Payment Again
                </a>
                <a href="{{ route('books') }}" class="btn btn-outline-secondary px-4 py-2">
                    Browse Other Books
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
