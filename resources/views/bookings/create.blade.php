<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <x-icon name="o-plus-circle" class="w-6 h-6 text-salon-500" />
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Agendamento</h2>
        </div>
    </x-slot>

    <x-card>
        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6" id="bookingForm">
            @csrf

            <div>
                <label class="label">
                    <span class="label-text">Serviço *</span>
                </label>
                <select name="service_id" id="service_id"
                    class="select select-bordered w-full border-2 border-gray-300 focus:border-primary @error('service_id') select-error border-error @enderror"
                    required>
                    <option value="" disabled {{ !old('service_id') && !request('service_id') ? 'selected' : '' }}>Selecione um serviço</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" 
                            {{ (old('service_id') == $service->id || request('service_id') == $service->id) ? 'selected' : '' }}>
                            {{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="label">
                    <span class="label-text">Data do Agendamento *</span>
                </label>
                @php
                    $dayOfWeek = strtolower(now()->format('l'));
                    $businessHours = config("booking.business_hours.{$dayOfWeek}");
                    $minDate = now()->format('Y-m-d');
                    
                    // Se hoje ainda está no horário comercial, permitir hoje
                    // Senão, começar de amanhã
                    if ($businessHours) {
                        $closeTime = \Carbon\Carbon::parse($businessHours[1]);
                        if (now()->gte($closeTime)) {
                            $minDate = now()->addDay()->format('Y-m-d');
                        }
                    }
                @endphp
                <input type="date" id="booking_date" 
                    min="{{ $minDate }}"
                    class="input input-bordered w-full border-2 border-gray-300 focus:border-primary cursor-pointer"
                    onclick="this.showPicker()"
                    required />
                @error('scheduled_at')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div id="time-slot-container">
                <label class="label">
                    <span class="label-text">Horário Disponível *</span>
                </label>
                <select name="scheduled_time" id="scheduled_time"
                    class="select select-bordered w-full border-2 border-gray-300 focus:border-primary"
                    disabled
                    required>
                    <option value="" disabled selected>{{ __('booking.messages.select_date_service') }}</option>
                </select>
                <input type="hidden" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}">
            </div>

            <div id="loading-slots" style="display: none;" class="text-center py-4">
                <span class="loading loading-spinner loading-md text-primary"></span>
                <p class="text-sm text-gray-600 mt-2">{{ __('booking.messages.loading_slots') }}</p>
            </div>

            <div id="no-slots-message" style="display: none;" class="alert alert-warning">
                <x-icon name="o-exclamation-triangle" class="w-5 h-5" />
                <span>{{ __('booking.messages.no_slots_message') }}</span>
            </div>

            <x-textarea label="Observações" name="notes" :value="old('notes')" rows="3"
                placeholder="Alguma observação sobre o agendamento?"
                class="textarea-bordered border-2 border-gray-300 focus:border-primary" />

            <div class="flex gap-3 pt-4 justify-end">
                <x-button link="{{ route('bookings.index') }}" class="btn-ghost" icon="o-x-mark">
                    Cancelar
                </x-button>
                <x-button type="submit" class="btn-primary" icon="o-check" id="submit-btn">
                    Confirmar Agendamento
                </x-button>
            </div>
        </form>
    </x-card>

    <x-card class="mt-6">
        <x-slot:title>
            <div class="flex items-center gap-2">
                <x-icon name="o-sparkles" class="w-5 h-5 text-lavender-500" />
                Serviços Disponíveis
            </div>
        </x-slot:title>

        <div class="space-y-4">
            @foreach ($services as $service)
                <div
                    class="flex items-start gap-4 p-4 rounded-lg border border-salon-100 hover:border-salon-300 hover:bg-salon-50/30 transition">
                    <div class="avatar placeholder">
                        <div class="bg-gradient-to-br from-salon-100 to-lavender-100 text-salon-600 rounded-full w-12">
                            <x-icon name="o-scissors" class="w-6 h-6" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-800">{{ $service->name }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $service->description }}</p>
                        <div class="flex gap-4 mt-2">
                            <span class="text-salon-600 font-bold text-lg">
                                R$ {{ number_format($service->price, 2, ',', '.') }}
                            </span>
                            <span class="flex items-center gap-1 text-gray-500">
                                <x-icon name="o-clock" class="w-4 h-4" />
                                {{ $service->duration_minutes }} min
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>

    <!-- Modal de Sugestão de Data -->
    <dialog id="suggestedDateModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <x-icon name="o-calendar" class="w-5 h-5 text-salon-500" />
                Sugestão de Agendamento
            </h3>
            <p class="py-4" id="suggestedDateMessage"></p>
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('suggestedDateModal').close()">Não, obrigado</button>
                <button type="button" class="btn btn-primary" id="acceptSuggestionBtn">
                    <x-icon name="o-check" class="w-4 h-4" />
                    Sim, agendar nesta data
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Modal de Erro -->
    <dialog id="errorModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg flex items-center gap-2 text-error">
                <x-icon name="o-exclamation-triangle" class="w-5 h-5" />
                Erro
            </h3>
            <p class="py-4" id="errorMessage"></p>
            <div class="modal-action">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('errorModal').close()">OK</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Modal de Alerta -->
    <dialog id="alertModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg flex items-center gap-2 text-warning">
                <x-icon name="o-exclamation-circle" class="w-5 h-5" />
                Atenção
            </h3>
            <p class="py-4" id="alertMessage"></p>
            <div class="modal-action">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('alertModal').close()">OK</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</x-app-layout>

<script>
(function() {
    'use strict';
    
    const translations = {
        selectDateService: '{{ __('booking.messages.select_date_service') }}',
        selectTime: '{{ __('booking.messages.select_time') }}',
        noSlotsAvailable: '{{ __('booking.messages.no_slots_available') }}',
        errorLoading: '{{ __('booking.messages.error_loading') }}',
        selectSlotAlert: '{{ __('booking.messages.select_slot_alert') }}'
    };
    
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        const dateInput = document.getElementById('booking_date');
        const timeSelect = document.getElementById('scheduled_time');
        const scheduledAtInput = document.getElementById('scheduled_at');
        const loadingSlots = document.getElementById('loading-slots');
        const noSlotsMessage = document.getElementById('no-slots-message');
        const bookingForm = document.getElementById('bookingForm');
        
        let submitBtn = document.getElementById('submit-btn');
        if (!submitBtn) {
            submitBtn = bookingForm ? bookingForm.querySelector('button[type="submit"]') : null;
        }

        if (!serviceSelect || !dateInput || !timeSelect) return;

        function checkSuggestedDate(date) {
            return fetch(`/bookings/check-suggested-date?date=${date}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.has_suggestion) {
                        const modal = document.getElementById('suggestedDateModal');
                        const messageEl = document.getElementById('suggestedDateMessage');
                        const acceptBtn = document.getElementById('acceptSuggestionBtn');
                        
                        messageEl.textContent = data.message;
                        modal.showModal();
                        
                        acceptBtn.onclick = function() {
                            dateInput.value = data.suggested_date;
                            modal.close();
                            loadAvailableSlots();
                        };
                    }
                })
                .catch(() => {});
        }

        function loadAvailableSlots() {
            const serviceId = serviceSelect.value;
            const date = dateInput.value;

            if (!serviceId || !date) {
                timeSelect.disabled = true;
                timeSelect.innerHTML = `<option value="" disabled selected>${translations.selectDateService}</option>`;
                noSlotsMessage.style.display = 'none';
                return;
            }

            loadingSlots.style.display = 'block';
            timeSelect.disabled = true;
            noSlotsMessage.style.display = 'none';
            if (submitBtn) submitBtn.disabled = true;

            fetch(`/bookings/available-slots?date=${date}&service_id=${serviceId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    loadingSlots.style.display = 'none';
                    
                    if (data.success && data.slots && data.slots.length > 0) {
                        timeSelect.innerHTML = `<option value="" disabled selected>${translations.selectTime}</option>`;
                        
                        data.slots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot;
                            option.textContent = slot;
                            timeSelect.appendChild(option);
                        });
                        
                        timeSelect.disabled = false;
                        if (submitBtn) submitBtn.disabled = false;
                    } else {
                        timeSelect.innerHTML = `<option value="" disabled selected>${translations.noSlotsAvailable}</option>`;
                        timeSelect.disabled = true;
                        noSlotsMessage.style.display = 'block';
                        if (submitBtn) submitBtn.disabled = true;
                    }
                })
                .catch(() => {
                    loadingSlots.style.display = 'none';
                    timeSelect.disabled = true;
                    const errorModal = document.getElementById('errorModal');
                    const errorMessage = document.getElementById('errorMessage');
                    errorMessage.textContent = translations.errorLoading;
                    errorModal.showModal();
                    if (submitBtn) submitBtn.disabled = true;
                });
        }

        timeSelect.addEventListener('change', function() {
            const date = dateInput.value;
            const time = this.value;
            if (date && time) {
                scheduledAtInput.value = `${date} ${time}:00`;
            }
        });

        serviceSelect.addEventListener('change', loadAvailableSlots);
        dateInput.addEventListener('change', loadAvailableSlots);
        dateInput.addEventListener('blur', function() {
            if (this.value) {
                checkSuggestedDate(this.value);
            }
        });

        if (serviceSelect.value && dateInput.value) {
            loadAvailableSlots();
        }

        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                if (!scheduledAtInput.value) {
                    e.preventDefault();
                    const alertModal = document.getElementById('alertModal');
                    const alertMessage = document.getElementById('alertMessage');
                    alertMessage.textContent = translations.selectSlotAlert;
                    alertModal.showModal();
                }
            });
        }
    });
})();
</script>
