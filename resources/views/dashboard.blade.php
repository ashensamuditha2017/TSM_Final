@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Welcome Card --}}
            <div class="card shadow-lg mb-4 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3 rounded-top-3">
                    <h4 class="mb-0">Welcome, {{ auth()->user()->name }}!</h4>
                </div>
                <div class="card-body bg-light text-center py-4 rounded-bottom-3">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="lead mb-4">
                        You are successfully connected to your Google account. Use the links below to access your data.
                    </p>
                </div>
            </div>

            {{-- Dashboard Links --}}
            <div class="card shadow-lg rounded-3">
                <div class="card-header bg-secondary text-white text-center py-3 rounded-top-3">
                    <h4 class="mb-0">Your Google Services</h4>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-center gap-3 py-4 rounded-bottom-3">
                    <a href="{{ route('calendar') }}" class="btn btn-outline-primary btn-lg flex-grow-1 p-4 shadow-sm rounded-3">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Google Calendar
                    </a>
                    <a href="{{ route('email') }}" class="btn btn-outline-primary btn-lg flex-grow-1 p-4 shadow-sm rounded-3">
                        <i class="fas fa-envelope me-2"></i>
                        Gmail Emails
                    </a>
                    <a href="{{ route('todos') }}" class="btn btn-outline-primary btn-lg flex-grow-1 p-4 shadow-sm rounded-3">
                        <i class="fas fa-tasks me-2"></i>
                        Google To-Dos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection