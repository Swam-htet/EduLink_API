@extends('emails.layouts.base')

@section('content')
    <h2>Password Reset OTP</h2>

    <p>Dear {{ $data['name'] }},</p>

    <p>You have requested to reset your password. Please use the following OTP to proceed:</p>

    <div class="otp-box">
        {{ $data['otp'] }}
    </div>

    <p>This OTP will expire in {{ $data['expires_in'] }}.</p>
@endsection
