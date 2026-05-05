# Finance CRM

Sistema de CRM para finanças pessoais com Laravel + GraphQL + Vue 3 + TypeScript.

## Funcionalidades

- **Autenticação**: Login/logout com Sanctum (tokens)
- **Roles**: Usuário, Gestor, Admin com permissões diferenciadas
- **Contas**: CRUD completo de contas financeiras
- **Contas Bancárias**: CRUD completo de contas bancárias (1:n com usuário)
- **Tema**: Dark/Light mode que salva preferência do usuário no backend
- **GraphQL**: API via Lighthouse
- **Frontend**: Vue 3 + TypeScript + Apollo Client + Pinia

## Estrutura

```
finance-crm/
├── app/              # Laravel backend
├── frontend/         # Vue 3 + TypeScript
├── docker-compose.yml
└── README.md
```

## Como rodar com Docker

1. **Clone o repositório e entre na pasta:**
   ```bash
   cd finance-crm
   ```

2. **Suba os containers:**
   ```bash
   docker-compose up -d
   ```

3. **Execute as migrations:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

4. **Crie um usuário admin:**
   ```bash
   docker-compose exec app php artisan tinker
   > App\Models\User::create(['name' => 'Admin', 'email' => 'admin@finance.com', 'password' => bcrypt('password'), 'role' => 'admin'])
   ```

5. **Acesse:**
   - Frontend: http://localhost:5173
   - Backend GraphQL: http://localhost:8000/graphql

## Sem Docker (desenvolvimento local)

### Backend:
```bash
cd finance-crm
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve --port=8000
```

### Frontend:
```bash
cd finance-crm/frontend
npm install
npm run dev
```

## Roles e Permissões

- **Usuário**: Gerencia suas próprias contas e contas bancárias
- **Gestor**: Gerencia usuários com role 'usuario' e vê todas as contas
- **Admin**: Acesso total ao sistema

## Tema

O sistema suporta temas Light e Dark. A preferência é salva no banco de dados e restaurada automaticamente ao fazer login.
