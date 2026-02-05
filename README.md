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
- **Banco de Dados**: MySQL (via Docker)
- **Docker**: Laravel Sail
- **Arquitetura**: MVC com Actions e Services

## Instalação

### Pré-requisitos
- Docker Desktop instalado

### Passos

1. **Clone o repositório e entre na pasta**
```bash
git clone https://github.com/fulltimetecnologia/leila-salon
cd leila-salon
```

2. **Copiar o arquivo .env**
```bash
cp .env.example .env
```

3. **Instalar dependências**
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

4. **Criar containers com Sail**
```bash
./vendor/bin/sail up -d
```

5. **Criar e popular banco de dados**
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

6. **Instalar dependências front-end**
```bash
./vendor/bin/sail composer start
```

**Acessar:** http://localhost

## Usuários de Teste

Após executar os seeders, você terá acesso a:

**Administrador (Leila)**
- Email: leila@salon.com.br
- Senha: password
- Acesso total ao sistema

**Larissa Castro**
- Email: larissa.castro@gmail.com
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

## Estrutura de Banco de Dados

### Tabela: users
- `id` - Identificador único
- `name` - Nome do usuário
- `email` - Email (único)
- `password` - Senha (hash)
- `role` - Papel do usuário (`client` ou `admin`)
- `timestamps` - created_at, updated_at

### Tabela: services
- `id` - Identificador único
- `name` - Nome do serviço
- `description` - Descrição do serviço (nullable)
- `duration_minutes` - Duração em minutos
- `price` - Preço (decimal)
- `active` - Serviço ativo (boolean)
- `timestamps` - created_at, updated_at

### Tabela: bookings
- `id` - Identificador único
- `user_id` - ID do cliente (foreign key)
- `service_id` - ID do serviço (foreign key)
- `scheduled_at` - Data e hora agendada
- `status` - Status: `pending`, `confirmed`, `completed`, `cancelled`
- `notes` - Observações (nullable)
- `timestamps` - created_at, updated_at

## Desenvolvimento

### Arquitetura
- **MVC**: Separação clara entre Models, Views e Controllers
- **Services**: Lógica de negócio complexa
- **Actions**: Operações específicas e reutilizáveis
- **Policies**: Autorização centralizada

### Padrões de Código
- Código limpo
- Reaproveitamento de código via Services e Actions
- Uso de Policies para autorização
- Validação de dados em todos os formulários

## Helpers Customizados

O projeto possui helpers globais para facilitar o desenvolvimento:

### Autenticação
```php
$user = currentUser(); // Equivalente a auth()->user()
$userId = currentUserId(); // Equivalente a auth()->id()
```

**Localização**: `app/Helpers/helpers.php`

## Internacionalização (i18n)

O sistema suporta múltiplos idiomas (pt_BR, en, es) para todas as mensagens.

### Estrutura de Traduções
```
lang/
├── pt_BR/
│   └── booking.php
├── en/
│   └── booking.php
└── es/
    └── booking.php
```

## Configuração de Horários

As configurações de horário de funcionamento estão fixas (pode evoluir para uma configuração no admin) em `config/booking.php`:

```php
'business_hours' => [
    'monday' => ['09:00', '19:00'],
    'tuesday' => ['09:00', '19:00'],
    'wednesday' => ['09:00', '19:00'],
    'thursday' => ['09:00', '19:00'],
    'friday' => ['09:00', '19:00'],
    'saturday' => ['09:00', '17:00'],
    'sunday' => null,
],
'slot_interval_minutes' => 60,
```

### Limpar cache
```bash
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan view:clear
./vendor/bin/sail artisan route:clear
```

### Recriar banco de dados
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```