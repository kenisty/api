<?php declare(strict_types=1);

return [
    'register' => [
        'success' => [
            'response' => [
                'message' => 'You have been successfully registered! Please proceed to verify your account.',
            ],
        ],
        'failed' => [
            'request' => [
                'firstName' => [
                    'required' => 'Please provide your first name.',
                    'string' => 'Please enter a valid first name.',
                    'min' => 'Your first name cannot be less than :min characters.',
                    'max' => 'Your first name cannot exceed :max characters.',
                ],
                'lastName' => [
                    'required' => 'Please provide your last name.',
                    'string' => 'Please enter a valid last name.',
                    'min' => 'Your last name cannot be less than :min characters.',
                    'max' => 'Your last name cannot exceed :max characters.',
                ],
                'email' => [
                    'required' => 'Please provide your email.',
                    'email' => 'Please enter a valid email address.',
                    'unique' => 'This email address is already in use. Please use a different email.',
                    'min' => 'Email address should be at least :min characters.',
                    'max' => 'Email address should not exceed :max characters.',
                ],
                'password' => [
                    'required' => 'A password is required. Please enter a password.',
                    'string' => 'Please enter a valid password.',
                    'confirmed' => 'Password confirmation does not match.',
                    'min' => 'The password should be at least :min characters long.',
                    'max' => 'The password should not exceed :max characters.',
                ],
            ],
        ],
    ],

    'login' => [
        'success' => [
            'response' => [
                'message' => 'Welcome back!',
            ],
        ],
        'failed' => [
            'request' => [
                'email' => [
                    'required' => 'Please provide your email.',
                    'email' => 'Please enter a valid email address.',
                    'exists' => 'The given credentials don\'t match any of our records.',
                ],
                'password' => [
                    'required' => 'A password is required. Please enter a password.',
                    'string' => 'Please enter a valid password.',
                ],
            ],
        ],
    ],
];
