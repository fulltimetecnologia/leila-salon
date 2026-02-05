<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Criar Conta</h2>
        <p class="text-sm text-gray-600 mt-1">Cadastre-se para começar a agendar</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Nome Completo</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                placeholder="Seu nome completo"
                class="input input-bordered w-full @error('name') input-error @enderror" />
            @error('name')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="form-control w-full mt-4">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="seu@email.com"
                class="input input-bordered w-full @error('email') input-error @enderror" />
            @error('email')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="form-control w-full mt-4">
            <label class="label">
                <span class="label-text">Senha</span>
                <span class="label-text-alt">Mínimo 8 caracteres</span>
            </label>
            <input type="password" name="password" required placeholder="Use letras e números"
                class="input input-bordered w-full @error('password') input-error @enderror" />
            @error('password')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="form-control w-full mt-4">
            <label class="label">
                <span class="label-text">Confirmar Senha</span>
            </label>
            <input type="password" name="password_confirmation" required placeholder="Digite a senha novamente"
                class="input input-bordered w-full @error('password_confirmation') input-error @enderror" />
            @error('password_confirmation')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-full mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
            Criar Conta
        </button>

        <div class="text-center mt-4">
            <span class="text-sm text-gray-600">Já tem conta? </span>
            <a href="{{ route('login') }}" class="text-sm text-salon-600 hover:text-salon-800 font-medium">
                Entrar
            </a>
        </div>
    </form>
</x-guest-layout>
