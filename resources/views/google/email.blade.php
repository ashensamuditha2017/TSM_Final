@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Latest Google Emails') }}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Snippet</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                                <tr>
                                    <td>{{ $message['from'] }}</td>
                                    <td>{{ $message['subject'] }}</td>
                                    <td>{{ $message['snippet'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No recent emails found.</td>
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