<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <x-icon name="o-pencil" class="w-6 h-6 text-salon-500" />
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Agendamento</h2>
        </div>
    </x-slot>

    <x-card>
        <form action="{{ route('bookings.update', $booking) }}" method="POST" class="space-y-6" id="bookingForm">
            @csrf
            @method('PUT')

            <div>
                <label class="label">
                    <span class="label-text">Serviço *</span>
                </label>
                <select name="service_id" id="service_id"
                    class="select select-bordered w-full border-2 border-gray-300 focus:border-primary @error('service_id') select-error border-error @enderror"
                    required>
                    <option value="" disabled>Selecione um serviço</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}"
                            {{ old('service_id', $booking->service_id) == $service->id ? 'selected' : '' }}>
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
                <input type="date" id="booking_date" 
                    min="{{ now()->format('Y-m-d') }}"
                    value="{{ old('scheduled_at') ? \Carbon\Carbon::parse(old('scheduled_at'))->format('Y-m-d') : $booking->scheduled_at->format('Y-m-d') }}"
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
                <input type="hidden" name="scheduled_at" id="scheduled_at" 
                    value="{{ old('scheduled_at', $booking->scheduled_at->format('Y-m-d H:i:s')) }}">
            </div>

            <div id="loading-slots" style="display: none;" class="text-center py-4">
                <span class="loading loading-spinner loading-md text-primary"></span>
                <p class="text-sm text-gray-600 mt-2">{{ __('booking.messages.loading_slots') }}</p>
            </div>

            <div id="no-slots-message" style="display: none;" class="alert alert-warning">
                <x-icon name="o-exclamation-triangle" class="w-5 h-5" />
                <span>{{ __('booking.messages.no_slots_message') }}</span>
            </div>

            <x-textarea label="Observações" name="notes" :value="old('notes', $booking->notes)" rows="3"
                placeholder="Alguma observação sobre o agendamento?"
                class="textarea-bordered border-2 border-gray-300 focus:border-primary" />

            <div class="flex gap-3 pt-4 justify-end">
                <x-button link="{{ route('bookings.index') }}" class="btn-ghost" icon="o-x-mark">
                    Cancelar
                </x-button>
                <x-button type="submit" class="btn-primary" icon="o-check" id="submit-btn">
                    Salvar Alterações
                </x-button>
            </div>
        </form>
    </x-card>

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
    
    const bookingId = {{ $booking->id }};
    const initialTime = '{{ $booking->scheduled_at->format('H:i') }}';
    
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

        function loadAvailableSlots(selectInitialTime = false) {
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
                        timeSelect.innerHTML = `<option value="" disabled ${!selectInitialTime ? 'selected' : ''}>${translations.selectTime}</option>`;
                        
                        let hasInitialTime = false;
                        data.slots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot;
                            option.textContent = slot;
                            if (selectInitialTime && slot === initialTime) {
                                option.selected = true;
                                hasInitialTime = true;
                            }
                            timeSelect.appendChild(option);
                        });
                        
                        if (selectInitialTime && hasInitialTime) {
                            scheduledAtInput.value = `${date} ${initialTime}:00`;
                        }
                        
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

        serviceSelect.addEventListener('change', () => loadAvailableSlots(false));
        dateInput.addEventListener('change', () => loadAvailableSlots(false));

        if (serviceSelect.value && dateInput.value) {
            loadAvailableSlots(true);
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
