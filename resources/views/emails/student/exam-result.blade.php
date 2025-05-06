@extends('emails.layouts.base')

@section('content')
    <h2>Exam Result Notification</h2>

    <p>Dear {{ $data['student_name'] }},</p>

    <p>Your results for the exam <strong>{{ $data['exam_title'] }}</strong> are now available.</p>

    <div class="info-box" style="margin: 20px 0; padding: 15px; background-color: #f7f7f7; border-radius: 5px;">
        <p style="margin: 5px 0;"><strong>Total Marks Obtained:</strong> {{ $data['total_marks_obtained'] }}</p>
        <p style="margin: 5px 0;"><strong>Total Questions:</strong> {{ $data['total_questions'] }}</p>
        <p style="margin: 5px 0;"><strong>Correct Answers:</strong> {{ $data['correct_answers'] }}</p>
        <p style="margin: 5px 0;"><strong>Wrong Answers:</strong> {{ $data['wrong_answers'] }}</p>
        <p style="margin: 5px 0;"><strong>Status:</strong> <span style="color: {{ $data['status'] === 'pass' ? '#10B981' : '#EF4444' }}">{{ ucfirst($data['status']) }}</span></p>
    </div>

    <p>
        Please log in to your student portal to view your detailed exam results.
    </p>

    <p>If you have any questions about your results, please contact your instructor.</p>
@endsection
