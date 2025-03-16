@extends('emails.layouts.base')

@section('content')
    <h2>Registration Status Update</h2>

    <p>Dear {{ $data['name'] }},</p>

    <p>We regret to inform you that your registration with {{ config('app.name') }} has not been approved at this time.</p>

    @if(isset($data['reason']))
    <div class="info-box">
        <strong>Reason:</strong><br>
        {{ $data['reason'] }}
    </div>
    @endif

    <p>If you believe this is an error or would like to submit additional information, please contact our support team.</p>
@endsection
