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
        'student_registered' => 'Student registered successfully',
        'logged_in' => 'Logged in successfully',
        'logged_out' => 'Successfully logged out',
        'student_updated' => 'Student updated successfully',
        'student_deleted' => 'Student deleted successfully',
        'profile_fetched' => 'Profile fetched successfully',
    ],

    // Error messages
    'error' => [
        'invalid_credentials' => 'The provided credentials are incorrect.',
        'student_not_found' => 'Student not found',
        'unauthorized' => 'You are not authorized to perform this action',
        'registration_failed' => 'Registration failed',
        'login_failed' => 'Login failed',
        'unauthenticated' => 'Unauthenticated. Please login to continue.',
        'resource_not_found' => 'The requested resource was not found.',
        'endpoint_not_found' => 'The requested endpoint does not exist.',
        'validation_failed' => 'The given data was invalid.',
        'server_error' => 'An unexpected error occurred. Please try again later.',
    ],

    // Email subjects
    'email' => [
        'welcome_subject' => 'Welcome to EduLink - Registration Successful',
    ],
];
