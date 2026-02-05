<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Bem-vinda de volta!</h2>
        <p class="text-sm text-gray-600 mt-1">Entre para agendar seus serviços</p>
    </div>

    @if (session('status'))
        <div class="alert alert-info mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="stroke-current shrink-0 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                placeholder="seu@email.com" class="input input-bordered w-full @error('email') input-error @enderror" />
            @error('email')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="form-control w-full mt-4">
            <label class="label">
                <span class="label-text">Senha</span>
            </label>
            <input type="password" name="password" required placeholder="••••••••"
                class="input input-bordered w-full @error('password') input-error @enderror" />
            @error('password')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="checkbox checkbox-primary" />
                <span class="text-sm text-gray-700">Lembrar de mim</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm text-salon-600 hover:text-salon-800 font-medium">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-full mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            Entrar
        </button>

        <div class="text-center mt-4">
            <span class="text-sm text-gray-600">Não tem conta? </span>
            <a href="{{ route('register') }}" class="text-sm text-salon-600 hover:text-salon-800 font-medium">
                Cadastre-se
            </a>
        </div>
    </form>
</x-guest-layout>
