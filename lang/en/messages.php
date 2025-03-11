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
        'config_created' => 'Configuration created successfully',
        'config_updated' => 'Configuration updated successfully',
        'config_deleted' => 'Configuration deleted successfully',
        'configs_updated' => 'Configurations updated successfully',
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
        'tenant_not_found' => 'Tenant not found',

    ],
    'errors' => [
        '404' => 'The requested resource was not found.',
        '401' => 'Unauthorized access.',
        '403' => 'You do not have permission to access this resource.',
        '500' => 'An error occurred.',
    ],

    // Email subjects
    'email' => [
        'welcome_subject' => 'Welcome to EduLink - Registration Successful',
    ],
];
