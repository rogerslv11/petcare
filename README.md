# PetCare — Gestão para Petshop

Sistema interno de loja única (não-SaaS). Laravel 12 + Livewire 4 + Tailwind.
Tema claro profissional (branco + azul), sem seleção de empresa, sem planos SaaS.

## Stack

- **PHP** 8.2+
- **Laravel** 12.x
- **Livewire** 4.x
- **Tailwind CSS** 3.x
- **Vite** 7.x
- **SQLite** (dev) — ajustável para MySQL/PostgreSQL

## Módulos

Dashboard · Agenda · Quadro de atendimento · Agendamentos · Check-in/out ·
Banho & Tosa · Creche · Hospedagem · Clientes · Pets (timeline, vacinas, alergias) ·
Serviços · Equipe + Comissões · Pacotes e planos de clientes · Fidelidade ·
PDV · Produtos/Estoque/Fornecedores/Compras · Pagamentos · Caixa · Financeiro ·
CRM/Leads · Relatórios · Agendamento público `/agendar` · Configurações.

## Diferenças em relação à versão SaaS original

- Troca de empresa (`business/select`, `business/switch`) → redireciona p/ dashboard
- Portal do cliente multi-empresa → dashboard
- Auditoria separada → Relatórios
- `booking/{business}` → `/agendar` (loja única)
- Permissões por papel multi-tenant → acesso liberado (`User::canAccess = true`)
- `TenantContext`/`BelongsToBusiness` com fallback p/ empresa única

## Setup local

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Acesse `http://localhost:8000/login-demo` para login rápido (cria `demo@petcareos.test` / `password`).

### Login manual

```bash
# cria usuário
php artisan tinker
>>> User::create(['name'=>'Admin','email'=>'admin@petcare.test','password'=>'password','email_verified_at'=>now()])
```

## Testes & qualidade

```bash
php artisan test             # PHPUnit (Feature + Unit)
vendor/bin/pint --test       # Laravel Pint (Laravel code style)
vendor/bin/pint              # aplicar correções automaticamente
```

## Estrutura

```
app/
├── Actions/         # CreateAppointment, CompleteCheckout
├── Concerns/        # BelongsToBusiness
├── Enums/           # AppointmentStatus, PaymentMethod, ...
├── Events/          # AppointmentCreated, AppointmentStatusChanged
├── Http/            # Controllers, Middleware, Requests
├── Jobs/            # SendAppointmentReminder, CheckVaccinesDue
├── Listeners/       # LogStatusChange, SendAppointmentNotification
├── Livewire/        # Componentes de UI (Kanban, PDV, Calendário, ...)
├── Models/          # Eloquent models
├── Notifications/   # VaccineDueNotification, PetReadyNotification
├── Observers/       # AppointmentObserver
├── Policies/        # AppointmentPolicy, PetPolicy, CustomerPolicy
├── Providers/       # AppServiceProvider
├── Services/        # AppointmentService, SaleService, ReportService, ...
└── Support/         # TenantContext

database/
├── migrations/      # Schema (split em core/customers/ops/commerce/growth/notifications)
├── seeders/         # PetCareSeeder (dados demo)
└── factories/

resources/views/     # Blade templates
routes/
├── web.php          # Rotas principais
└── auth.php         # Login/registro/recuperação
tests/
├── Feature/         # Testes de integração
└── Unit/            # Testes unitários
```

## Deploy

Este é um sistema de loja única — recomendado hospedar em VPS ou PaaS com suporte a PHP 8.2:

- **VPS** (recomendado): Nginx + PHP-FPM + SQLite/MySQL
- **PaaS**: Laravel Forge, Ploi, RunCloud
- **Compartilhado**: Hostinger, Locaweb (com fila desabilitada)

## Licença

MIT