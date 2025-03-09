<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines contain messages used throughout the application.
    |
    */

    // Success messages
    'success' => [
        'student' => [
            'registered' => 'Student registered successfully',
            'logged_in' => 'Logged in successfully',
            'logged_out' => 'Successfully logged out',
            'profile_fetched' => 'Student profile fetched successfully',
        ],
    ],

    // Error messages
    'error' => [
        'invalid_credentials' => 'The provided credentials are incorrect.',
        'student_not_found' => 'Student not found',
        'unauthorized' => 'You are not authorized to perform this action',
        'registration_failed' => 'Registration failed',
        'login_failed' => 'Login failed',
    ],

    // Email subjects
    'email' => [
        'welcome_subject' => 'Welcome to EduLink - Registration Successful',
    ],
];
