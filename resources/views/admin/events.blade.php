@extends('admin.layout')

@section('title', 'Event RSVPs & Attendees')
@section('page_title', 'Community Book Swap Meet Registrations')

@section('content')

<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
    <div class="p-3 bg-light border-bottom">
        <span class="small text-muted fw-bold text-uppercase">
            <i class="fa-solid fa-ticket text-primary me-1"></i> Registered Attendees ({{ $registrations->total() }})
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="bg-light text-muted text-uppercase">
                <tr>
                    <th>Attendee Name</th>
                    <th>Contact Info</th>
                    <th>Registered Event</th>
                    <th>Books Brought for Exchange</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                    <tr>
                        <td>
                            <strong class="text-dark">{{ $reg->name }}</strong>
                        </td>
                        <td>
                            <div><i class="fa-solid fa-envelope text-muted me-1"></i> {{ $reg->email }}</div>
                            @if($reg->phone)
                                <div class="text-muted"><i class="fa-solid fa-phone text-muted me-1"></i> +91 {{ $reg->phone }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $reg->event->title ?? 'N/A' }}</span>
                            @if($reg->event)
                                <div class="text-muted small"><i class="fa-regular fa-calendar me-1"></i> {{ $reg->event->event_date->format('M d, Y') }}</div>
                            @endif
                        </td>
                        <td>
                            @if($reg->books_to_exchange)
                                <span class="badge bg-light text-dark border">{{ $reg->books_to_exchange }}</span>
                            @else
                                <span class="text-muted">General Attendee</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted">{{ $reg->created_at->format('M d, Y h:i A') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No event registrations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $registrations->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
