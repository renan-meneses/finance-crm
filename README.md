# Finance CRM

Sistema de CRM para finanças pessoais com Laravel + GraphQL + Vue 3 + TypeScript.

## Funcionalidades

- **Autenticação**: Login/logout com Sanctum (tokens) e Login Social (Google + Facebook)
- **Roles**: Usuário, Gestor, Admin com permissões diferenciadas
- **Contas**: CRUD completo de contas financeiras
- **Contas Bancárias**: CRUD completo (1:n com usuário)
- **Transações**: Receitas e Despesas com 26 categorias específicas
- **Gráficos**: 2 gráficos de pizza (receitas/despesas) com cores únicas por categoria
- **Cards de Resumo**: Total Recebido, Total Gasto, Saldo
- **Upload de Comprovantes**: Upload de PIX (imagem/PDF) com suporte a OCR
- **Tema**: Dark/Light mode que salva preferência no backend
- **GraphQL**: API via Lighthouse
- **Frontend**: Vue 3 + TypeScript + Apollo Client + Pinia + Chart.js

## Estrutura

```
finance-crm/
├── app/              # Laravel backend
├── frontend/         # Vue 3 + TypeScript
├── docker-compose.yml
└── README.md
```

## Configuração Login Social

1. **Google OAuth**:
   - Acesse [Google Cloud Console](https://console.cloud.google.com/)
   - Crie um projeto e configure OAuth 2.0
   - Adicione URI de redirecionamento: `http://localhost:8000/auth/google/callback`
   - Copie Client ID e Client Secret

2. **Facebook OAuth**:
   - Acesse [Facebook Developers](https://developers.facebook.com/)
   - Crie um app e configure Facebook Login
   - Adicione URI de redirecionamento: `http://localhost:8000/auth/facebook/callback`
   - Copie App ID e App Secret

3. **Configure o `.env`**:
```env
GOOGLE_CLIENT_ID=seu_client_id
GOOGLE_CLIENT_SECRET=seu_client_secret
FACEBOOK_CLIENT_ID=seu_app_id
FACEBOOK_CLIENT_SECRET=seu_app_secret
FRONTEND_URL=http://localhost:5173
```

## Como rodar com Docker

1. **Suba os containers:**
   ```bash
   docker-compose up -d
   ```

2. **Execute as migrations:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

3. **Crie um usuário admin:**
   ```bash
   docker-compose exec app php artisan tinker
   > App\Models\User::create(['name' => 'Admin', 'email' => 'admin@finance.com', 'password' => bcrypt('password'), 'role' => 'admin'])
   ```

4. **Acesse:**
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

- **Usuário**: Gerencia suas próprias contas, contas bancárias e transações
- **Gestor**: Gerencia usuários com role 'usuario' e vê todas as transações
- **Admin**: Acesso total ao sistema

## Categorias de Transações

### Despesas (15):
Habitação, Alimentação, Transporte, Saúde, Educação, Lazer, Contas de Consumo, Assinaturas e Serviços, Compras e Vestuário, Cuidados Pessoais, Pets, Impostos e Taxas, Manutenção Residencial, Investimentos, Reserva de Emergência, Diversos / Outros

### Receitas (11):
Salário, Pró-labore, Renda Extra / Freelance, Investimentos (Dividendos/Juros), Venda de Ativos (Bens/Usados), Reembolsos, Presentes / Doações, Bonificações / Comissões, Restituição de Imposto, Aluguéis Recebidos, Outras Receitas

## Tema

O sistema suporta temas Light e Dark. A preferência é salva no banco de dados e restaurada automaticamente ao fazer login.

## Upload de Comprovantes

- Formatos aceitos: Imagens (JPG, PNG) e PDF
- OCR preparado para integração (Tesseract.js no frontend ou API externa no backend)
- Comprovantes são armazenados em `storage/app/public/comprovantes`
