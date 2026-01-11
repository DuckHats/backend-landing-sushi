<?php

return [
    'admin' => [
        'name' => env('APP_ADMIN_NAME', 'Duckhats'),
        'email' => env('APP_ADMIN_EMAIL', 'dev@duckhats.cat'),
        'password' => env('APP_ADMIN_PASSWORD', 'Password123'),
    ],
    'colors' => [
        'primary' => env('APP_COLOR_PRIMARY', '#722022'),
        'secondary' => env('APP_COLOR_SECONDARY', '#8A9556'),
        'tertiary' => env('APP_COLOR_TERTIARY', '#BEBABF'),
        'black' => env('APP_COLOR_BLACK', '#1B1B1E'),
        'white' => env('APP_COLOR_WHITE', '#FBFFFE'),
        'beige' => env('APP_COLOR_BEIGE', '#EAECDB'),
    ],
    'welcome' => [
        'title' => env('APP_WELCOME_TITLE', 'Sushi Experience'),
        'subtitle' => env('APP_WELCOME_SUBTITLE', 'Backend Service & API'),
    ],
    'email' => env('APP_CONTACT_EMAIL', 'sudokusushibar@gmail.com'),
    'name' => env('APP_BRAND_NAME', 'Sudoku Sushi'),
    'address' => env('APP_BRAND_ADDRESS', 'C/ Oviedo 50, Girona, 17005'),
    'phone' => env('APP_BRAND_PHONE', '640589007'),
    'show_version' => env('SHOW_VERSION', false),
];
