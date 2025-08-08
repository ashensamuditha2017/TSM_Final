@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="height: 80vh;">
    <div class="text-center">
        <!-- Main Heading -->
        <h1 class="display-4 fw-bold text-primary mb-3">Welcome to the Social Login</h1>
        
        <!-- Subheading -->
        <p class="lead text-muted mb-4">Your journey to a better user experience starts here.</p>

        <!-- Dynamic Call-to-Action Button -->
        @guest
            <!-- If the user is not logged in -->
            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow-sm">
                    Log In to Get Started
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                    Sign Up Now
                </a>
            </div>
        @else
            <!-- If the user is logged in -->
            <a href="{{ url('/home') }}" class="btn btn-success btn-lg shadow-sm">
                Go to Dashboard
            </a>
        @endguest
    </div>
</div>
@endsection
