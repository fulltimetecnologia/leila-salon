# Sistema de Agendamento - Salão de Beleza Leila

Sistema completo de agendamento online para salão de beleza, desenvolvido com Laravel 12, Mary-UI (TailwindCSS + DaisyUI), e Livewire.

## Funcionalidades Implementadas

### Para Clientes
- Cadastro e autenticação de usuários
- Visualização de serviços disponíveis
- Criação de agendamentos online
- Listagem de agendamentos futuros
- Edição de agendamentos (até 2 dias antes)
- Cancelamento de agendamentos (até 2 dias antes)
- Histórico de agendamentos com filtros por período
- Sugestão automática para agendar serviços na mesma data quando já existe agendamento na semana
- Restrição de alteração: menos de 2 dias requer contato telefônico

### Para Administrador (Leila)
- Dashboard com estatísticas semanais
- Visualização de métricas: total de agendamentos, confirmados, concluídos, receita
- Gerenciamento completo de serviços (CRUD)
- Gerenciamento completo de agendamentos
- Alteração de agendamentos de clientes (sem restrição de 2 dias)
- Confirmação de agendamentos
- Marcação de serviços como concluídos
- Cancelamento de agendamentos
- Listagem de próximos agendamentos
- Listagem de agendamentos recentes
- Filtros por status (pendente, confirmado, concluído, cancelado)

## Tecnologias Utilizadas

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Mary-UI (Blade + TailwindCSS 4 + DaisyUI)
- **Autenticação**: Laravel Breeze
- **Banco de Dados**: SQLite (pode ser alterado para MySQL/PostgreSQL)
- **Arquitetura**: MVC com Actions e Services

## Instalação

- Ainda vou instalar docker...

## Usuários de Teste

Após executar os seeders, você terá acesso a:

**Administrador (Leila)**
- Email: leila@salao.com
- Senha: password
- Acesso total ao sistema

**Cliente Teste**
- Email: cliente@test.com
- Senha: password
- Acesso cliente

## Regras de Negócio

1. **Alteração de Agendamentos**: Clientes podem alterar até 2 dias antes. Menos que isso, apenas por telefone.
2. **Sugestão de Data**: Sistema sugere agendar na mesma data quando cliente já tem agendamento na semana.
3. **Admin sem Restrições**: Leila pode alterar qualquer agendamento a qualquer momento.
4. **Serviços Ativos**: Apenas serviços marcados como ativos aparecem para agendamento.

## Estrutura do Projeto

### Models
- `User` - Usuários (clientes e admin)
- `Service` - Serviços do salão
- `Booking` - Agendamentos

### Controllers
- `BookingController` - Agendamentos do cliente
- `ServiceController` - Serviços públicos e admin
- `DashboardController` - Dashboards
- `Admin\BookingController` - Gestão administrativa de agendamentos

### Services
- `BookingService` - Lógica de negócio para agendamentos

### Actions
- `CreateBookingAction` - Criação de agendamentos
- `UpdateBookingAction` - Atualização de agendamentos

### Policies
- `BookingPolicy` - Autorização de acesso aos agendamentos

### Middleware
- `IsAdmin` - Verificação de permissão administrativa

## Rotas Principais

### Públicas
- `/` - Página inicial
- `/services` - Lista de serviços

### Autenticadas (Cliente)
- `/dashboard` - Dashboard do cliente
- `/bookings` - Meus agendamentos
- `/bookings/create` - Novo agendamento
- `/bookings/history` - Histórico

### Admin
- `/admin/dashboard` - Dashboard administrativo
- `/admin/bookings` - Gerenciar agendamentos
- `/admin/services` - Gerenciar serviços

### Arquitetura
- **MVC**: Separação clara entre Models, Views e Controllers
- **Services**: Lógica de negócio complexa
- **Actions**: Operações específicas e reutilizáveis
- **Policies**: Autorização centralizada