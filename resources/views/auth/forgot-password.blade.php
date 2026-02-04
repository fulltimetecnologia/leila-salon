<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Esqueceu a senha?</h2>
        <p class="text-sm text-gray-600 mt-2">
            Sem problemas! Informe seu email e enviaremos um link para criar uma nova senha.
        </p>
    </div>

    @if(session('status'))
        <div class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 w-6 h-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                placeholder="seu@email.com"
                class="input input-bordered w-full @error('email') input-error @enderror" 
            />
            @error('email')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-full mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
            </svg>
            Enviar Link de Recuperação
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-salon-600 hover:text-salon-800 font-medium">
                ← Voltar para o login
            </a>
        </div>
    </form>
</x-guest-layout>
