<?php

return [
    'validation' => [
        'time_required' => 'O horário de agendamento é obrigatório.',
        'invalid_datetime' => 'Formato de data/hora inválido.',
        'must_be_full_hour' => 'O agendamento deve ser feito em hora cheia (9:00, 10:00, etc.).',
        'past_time' => 'Não é possível agendar para um horário passado.',
        'closed_day' => 'Não atendemos neste dia da semana.',
        'outside_hours' => 'Horário fora do expediente. Atendemos das :open às :close neste dia.',
        'service_not_found' => 'Serviço não encontrado.',
        'slot_not_available' => 'Este horário não está disponível. Por favor, escolha outro horário.',
    ],
    
    'messages' => [
        'select_date_service' => 'Selecione uma data e serviço primeiro',
        'select_time' => 'Selecione um horário',
        'no_slots_available' => 'Nenhum horário disponível',
        'loading_slots' => 'Carregando horários disponíveis...',
        'no_slots_message' => 'Não há horários disponíveis para esta data. Por favor, escolha outra data.',
        'error_loading' => 'Erro ao carregar horários disponíveis. Por favor, tente novamente.',
        'select_slot_alert' => 'Por favor, selecione um horário disponível.',
        'suggestion_message' => 'Você já tem um agendamento para esta semana em :datetime. Deseja agendar no mesmo dia?',
        'created_success' => 'Agendamento criado com sucesso!',
        'updated_success' => 'Agendamento atualizado com sucesso!',
        'cancelled_success' => 'Agendamento cancelado com sucesso!',
        'cannot_modify_contact' => 'Não é possível alterar agendamentos com menos de 2 dias de antecedência. Entre em contato por telefone.',
        'cannot_modify' => 'Não é possível alterar agendamentos com menos de 2 dias de antecedência.',
        'cannot_cancel' => 'Não é possível cancelar agendamentos com menos de 2 dias de antecedência.',
    ],
];
