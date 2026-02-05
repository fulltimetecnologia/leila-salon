<?php

return [
    'validation' => [
        'time_required' => 'La hora de la cita es obligatoria.',
        'invalid_datetime' => 'Formato de fecha/hora inválido.',
        'must_be_full_hour' => 'Las citas deben ser en hora en punto (9:00, 10:00, etc.).',
        'past_time' => 'No se puede reservar para un horario pasado.',
        'closed_day' => 'No atendemos este día de la semana.',
        'outside_hours' => 'Horario fuera del horario de atención. Atendemos de :open a :close este día.',
        'service_not_found' => 'Servicio no encontrado.',
        'slot_not_available' => 'Este horario no está disponible. Por favor, elija otro horario.',
    ],
    
    'messages' => [
        'select_date_service' => 'Seleccione una fecha y servicio primero',
        'select_time' => 'Seleccione un horario',
        'no_slots_available' => 'Sin horarios disponibles',
        'loading_slots' => 'Cargando horarios disponibles...',
        'no_slots_message' => 'No hay horarios disponibles para esta fecha. Por favor, elija otra fecha.',
        'error_loading' => 'Error al cargar los horarios disponibles. Por favor, intente nuevamente.',
        'select_slot_alert' => 'Por favor, seleccione un horario disponible.',
        'suggestion_message' => 'Ya tiene una reserva para esta semana en :datetime. ¿Desea reservar en el mismo día?',
        'created_success' => '¡Reserva creada con éxito!',
        'updated_success' => '¡Reserva actualizada con éxito!',
        'cancelled_success' => '¡Reserva cancelada con éxito!',
        'cannot_modify_contact' => 'No se pueden modificar reservas con menos de 2 días de anticipación. Por favor, contáctenos por teléfono.',
        'cannot_modify' => 'No se pueden modificar reservas con menos de 2 días de anticipación.',
        'cannot_cancel' => 'No se pueden cancelar reservas con menos de 2 días de anticipación.',
    ],
];
