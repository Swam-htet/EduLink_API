@extends('emails.layouts.base')

@section('content')
    <h2>Password Changed Successfully</h2>

    <p>Dear {{ $data['name'] }},</p>

    <p>Your password has been successfully changed.</p>

    <div class="info-box">
        <strong>Security Notice:</strong><br>
        If you did not make this change, please contact our support team immediately.
    </div>
@endsection
