@extends('emails.layouts.base')

@section('content')
    <h2>Hello {{ $data['student_name'] }},</h2>
    <p>
        You have been invited to join the class: <strong>{{ $data['class_name'] }}</strong>.
    </p>
    <p>
        Please click the link below to view your class details and confirm your enrollment:
    </p>
    <p>
        <a href="{{ $data['url'] }}" style="background: #4F46E5; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            View Class Invitation
        </a>
    </p>

    <p>This invitation will expire in {{ $data['expires_in'] }}.</p>


@endsection
