@extends('emails.layouts.base')

@section('content')
    <h2>Registration Pending Approval</h2>

    <p>Dear {{ $data['name'] }},</p>

    <p>Thank you for registering with {{ config('app.name') }}. Your registration is currently pending approval from our administrators.</p>

    <div class="info-box">
        <strong>Registration Details:</strong><br>
        Student ID: {{ $data['student_id'] }}<br>
        Email: {{ $data['email'] }}
    </div>

    <p>We will notify you once your registration has been reviewed.</p>
@endsection
