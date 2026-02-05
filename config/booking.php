<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Business Hours
    |--------------------------------------------------------------------------
    |
    | Define the business hours for each day of the week.
    | Use 24-hour format (HH:MM). Set to null for closed days.
    |
    */
    'business_hours' => [
        'monday' => ['09:00', '19:00'],
        'tuesday' => ['09:00', '19:00'],
        'wednesday' => ['09:00', '19:00'],
        'thursday' => ['09:00', '19:00'],
        'friday' => ['09:00', '19:00'],
        'saturday' => ['09:00', '17:00'],
        'sunday' => null, // Fechado
    ],

    /*
    |--------------------------------------------------------------------------
    | Slot Interval
    |--------------------------------------------------------------------------
    |
    | Time interval in minutes for booking slots.
    | Default: 60 (hourly slots)
    |
    */
    'slot_interval_minutes' => 60,
];
