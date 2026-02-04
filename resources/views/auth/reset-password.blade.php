<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Criar Nova Senha</h2>
        <p class="text-sm text-gray-600 mt-1">Escolha uma senha forte e segura</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email', $request->email) }}" 
                required 
                autofocus 
                readonly
                class="input input-bordered w-full bg-gray-100" 
            />
        </div>

        <div class="form-control w-full mt-4">
            <label class="label">
                <span class="label-text">Nova Senha</span>
                <span class="label-text-alt">Mínimo 8 caracteres</span>
            </label>
            <input 
                type="password" 
                name="password" 
                required 
                placeholder="Digite sua nova senha"
                class="input input-bordered w-full @error('password') input-error @enderror" 
            />
            @error('password')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <div class="form-control w-full mt-4">
            <label class="label">
                <span class="label-text">Confirmar Nova Senha</span>
            </label>
            <input 
                type="password" 
                name="password_confirmation" 
                required 
                placeholder="Digite a senha novamente"
                class="input input-bordered w-full" 
            />
        </div>

        <button type="submit" class="btn btn-primary w-full mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
            </svg>
            Redefinir Senha
        </button>
    </form>
</x-guest-layout>
