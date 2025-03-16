@extends('emails.layouts.base')

@section('content')
    <h2>Registration Approved!</h2>

    <p>Dear {{ $data['name'] }},</p>

    <p>Congratulations! Your registration with {{ config('app.name') }} has been approved.</p>

    <div class="info-box">
        <strong>Your Account Details:</strong><br>
        Student ID: {{ $data['student_id'] }}<br>
        Email: {{ $data['email'] }}
    </div>

    <div style="text-align: center;">
        <a href="{{ $data['login_url'] }}" class="button">
            Login to Your Account
        </a>
    </div>
@endsection
