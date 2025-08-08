@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Google Calendar Events') }}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr>
                                    <td>{{ $event->getSummary() }}</td>
                                    <td>
                                        {{-- Check if the event is all-day --}}
                                        @if ($event->getStart()->getDate())
                                            {{ \Carbon\Carbon::parse($event->getStart()->getDate())->format('M d, Y') }} (All day)
                                        @else
                                            {{ \Carbon\Carbon::parse($event->getStart()->getDateTime())->format('M d, Y H:i A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($event->getEnd()->getDate())
                                            {{ \Carbon\Carbon::parse($event->getEnd()->getDate())->format('M d, Y') }} (All day)
                                        @else
                                            {{ \Carbon\Carbon::parse($event->getEnd()->getDateTime())->format('M d, Y H:i A') }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No upcoming events found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection