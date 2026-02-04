<x-mary-menu activate-by-route>
    @if(!Auth::user()->isAdmin())
        <x-mary-menu-separator title="Área do Cliente" />
        <x-mary-menu-item title="Dashboard" icon="o-home" link="{{ route('dashboard') }}" />
        <x-mary-menu-item title="Serviços" icon="o-sparkles" link="{{ route('services.index') }}" />
        <x-mary-menu-item title="Meus Agendamentos" icon="o-calendar-days" link="{{ route('bookings.index') }}" />
        <x-mary-menu-item title="Histórico" icon="o-clock" link="{{ route('bookings.history') }}" />
    @endif

    @if(Auth::user()->isAdmin())
        <x-mary-menu-separator title="Administração" />
        <x-mary-menu-item title="Dashboard Admin" icon="o-chart-bar" link="{{ route('admin.dashboard') }}" />
        <x-mary-menu-item title="Gerenciar Agendamentos" icon="o-calendar" link="{{ route('admin.bookings.index') }}" />
        <x-mary-menu-item title="Gerenciar Serviços" icon="o-scissors" link="{{ route('admin.services.index') }}" />
    @endif

    <x-mary-menu-separator title="Conta" class="mt-auto hidden lg:block" />
    <x-mary-menu-item title="Perfil" icon="o-user" link="{{ route('profile.edit') }}" class="hidden lg:block" />
    <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
        @csrf
        <x-mary-menu-item title="Sair" icon="o-arrow-right-on-rectangle" 
            onclick="event.preventDefault(); this.closest('form').submit();" />
    </form>
</x-mary-menu>
