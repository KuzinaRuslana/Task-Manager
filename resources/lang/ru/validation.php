<?php

return [
    'required' => 'Поле :attribute обязательно',
    'email' => 'Введите корректный email',
    'unique' => 'Этот адрес уже использован',
    'min' => [
        'string' => 'Пароль должен иметь длину не менее 8 символов',
    ],
    'confirmed' => 'Пароль и подтверждение не совпадают',

    'attributes' => [
        'email' => 'Email',
        'password' => 'Пароль',
        'name' => 'Имя',
        'password_confirmation' => 'Подтверждение пароля',
    ],
];
