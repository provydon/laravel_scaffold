<?php

use Illuminate\Validation\Rule;

/**
 * This file contains validation rules, messages and parameters for
 * all requests within the api that need validation
 */
return [
    'rules' => [
        //Auth Validations
         'login' => [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ],
        'register' => [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'string|max:255|unique:users,username',
            'phone' => 'string|max:255|unique:users,phone',
            // 'image' => [new Imageable],
            'password' => 'required|string|min:6',
        ],
    ],
];
