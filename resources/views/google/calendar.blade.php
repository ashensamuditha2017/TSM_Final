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
                                    <td>{{ optional($event->getStart())->getDateTime() ?? 'All day' }}</td>
                                    <td>{{ optional($event->getEnd())->getDateTime() ?? 'All day' }}</td>
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