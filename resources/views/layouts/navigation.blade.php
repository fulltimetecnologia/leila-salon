<x-menu activate-by-route>
    <x-menu-item title="Home" icon="o-home" link="{{ route('dashboard') }}" />
    
    @if(!Auth::user()->isAdmin())
        <x-menu-separator title="ÁREA DO CLIENTE" />
        <x-menu-item title="Dashboard" icon="o-home" link="{{ route('dashboard') }}" />
        <x-menu-item title="Serviços" icon="o-sparkles" link="{{ route('services.index') }}" />
        <x-menu-item title="Meus Agendamentos" icon="o-calendar-days" link="{{ route('bookings.index') }}" />
        <x-menu-item title="Histórico" icon="o-clock" link="{{ route('bookings.history') }}" />
    @endif

    @if(Auth::user()->isAdmin())
        <x-menu-separator title="ADMINISTRAÇÃO" />
        <x-menu-item title="Dashboard Admin" icon="o-chart-bar" link="{{ route('admin.dashboard') }}" />
        <x-menu-item title="Gerenciar Agendamentos" icon="o-calendar" link="{{ route('admin.bookings.index') }}" />
        <x-menu-item title="Gerenciar Serviços" icon="o-scissors" link="{{ route('admin.services.index') }}" />
    @endif

    <div class="flex-1"></div>
    
    <div class="hidden lg:block">
        <x-menu-separator title="CONTA" class="mt-4" />
        <x-menu-item title="Perfil" icon="o-user" link="{{ route('profile.edit') }}" />
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-menu-item title="Sair" icon="o-arrow-right-on-rectangle" 
                onclick="event.preventDefault(); this.closest('form').submit();" />
        </form>
    </div>
</x-menu>
