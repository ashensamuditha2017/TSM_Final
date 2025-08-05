@extends('layouts.app')

@section('content')
<h1>Welcome to the Dashboard</h1>
<h2>Go to Dashboard</h2>
<a href="{{ route('login') }}">Click Here to Login</a>
@endsection