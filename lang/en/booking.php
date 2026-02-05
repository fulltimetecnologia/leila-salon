<?php

return [
    'validation' => [
        'time_required' => 'Booking time is required.',
        'invalid_datetime' => 'Invalid date/time format.',
        'must_be_full_hour' => 'Bookings must be scheduled on the hour (9:00, 10:00, etc.).',
        'past_time' => 'Cannot book for a past time.',
        'closed_day' => 'We are closed on this day of the week.',
        'outside_hours' => 'Time outside business hours. We are open from :open to :close on this day.',
        'service_not_found' => 'Service not found.',
        'slot_not_available' => 'This time slot is not available. Please choose another time.',
    ],
    
    'messages' => [
        'select_date_service' => 'Select a date and service first',
        'select_time' => 'Select a time',
        'no_slots_available' => 'No slots available',
        'loading_slots' => 'Loading available times...',
        'no_slots_message' => 'No time slots available for this date. Please choose another date.',
        'error_loading' => 'Error loading available times. Please try again.',
        'select_slot_alert' => 'Please select an available time slot.',
        'suggestion_message' => 'You already have a booking this week on :datetime. Would you like to book on the same day?',
        'created_success' => 'Booking created successfully!',
        'updated_success' => 'Booking updated successfully!',
        'cancelled_success' => 'Booking cancelled successfully!',
        'cannot_modify_contact' => 'Cannot modify bookings less than 2 days in advance. Please contact us by phone.',
        'cannot_modify' => 'Cannot modify bookings less than 2 days in advance.',
        'cannot_cancel' => 'Cannot cancel bookings less than 2 days in advance.',
    ],
];
