# 🚀 Deploy no Render - Clickweb Backend

Guia completo para fazer deploy da aplicação no Render.com usando Docker.

## 📋 Pré-requisitos

1. Conta no [Render](https://render.com/) (gratuita ou paga)
2. Repositório Git com o código (GitHub, GitLab ou Bitbucket)
3. Chave da RapidAPI configurada

## 🔧 Configuração Inicial

### 1. Prepare o Repositório

Certifique-se de que os seguintes arquivos estão no repositório:

```bash
✅ Dockerfile
✅ .dockerignore
✅ docker/nginx.conf
✅ docker/default.conf
✅ docker/supervisord.conf
✅ docker/start.sh
✅ docker-compose.yml (opcional, para testes locais)
```

**IMPORTANTE:** O arquivo `.env` **NÃO** deve estar no repositório!

### 2. Teste Localmente (Opcional)

Antes de fazer deploy, teste a imagem Docker localmente:

```bash
# Build da imagem
docker build -t clickweb-backend .

# Executar container
docker run -d \
  -p 8080:8080 \
  -e APP_KEY=base64:your_key_here \
  -e RAPIDAPI_MOVIES_KEY=your_api_key \
  --name clickweb_test \
  clickweb-backend

# Verificar logs
docker logs -f clickweb_test

# Testar
curl http://localhost:8080/health

# Parar e remover
docker stop clickweb_test && docker rm clickweb_test
```

Ou use o Docker Compose:

```bash
# Criar arquivo .env com as variáveis necessárias
cp .env.example .env
# Editar .env com suas configurações

# Iniciar
docker-compose up -d

# Ver logs
docker-compose logs -f

# Parar
docker-compose down
```

## 🌐 Deploy no Render

### Passo 1: Criar Novo Web Service

1. Acesse o [Dashboard do Render](https://dashboard.render.com/)
2. Clique em **"New +"** → **"Web Service"**
3. Conecte seu repositório Git

### Passo 2: Configurar o Service

#### Configurações Básicas:

- **Name:** `clickweb-backend` (ou outro nome de sua escolha)
- **Region:** Escolha a região mais próxima (ex: `Oregon (US West)`)
- **Branch:** `main` ou `master`
- **Runtime:** **Docker**
- **Instance Type:** 
  - **Free:** Para testes (limites de recursos)
  - **Starter ($7/mês):** Para produção leve
  - **Standard:** Para produção com mais recursos

### Passo 3: Variáveis de Ambiente

Adicione as seguintes variáveis de ambiente no Render:

#### Obrigatórias:

```env
APP_NAME=Clickweb Backend
APP_ENV=production
APP_DEBUG=false
APP_KEY=                    # Gerar: php artisan key:generate --show
APP_URL=https://seu-app.onrender.com

# RapidAPI (OBRIGATÓRIO)
RAPIDAPI_MOVIES_HOST=moviesdatabase.p.rapidapi.com
RAPIDAPI_MOVIES_KEY=sua_chave_aqui
RAPIDAPI_MOVIES_URL=https://moviesdatabase.p.rapidapi.com/titles

# Banco de Dados (SQLite por padrão)
DB_CONNECTION=sqlite

# Cache
CACHE_STORE=file
SESSION_DRIVER=file
```

#### Como Gerar APP_KEY:

```bash
# Localmente
php artisan key:generate --show

# Ou use este comando
echo "base64:$(openssl rand -base64 32)"
```

### Passo 4: Configurações Avançadas

#### Health Check Path:
```
/health
```

#### Build Command (opcional):
Deixe em branco, o Dockerfile já faz tudo.

#### Start Command (opcional):
Deixe em branco, o Dockerfile define o CMD.

### Passo 5: Deploy

1. Clique em **"Create Web Service"**
2. Aguarde o build e deploy (pode levar 5-10 minutos)
3. Render fará automaticamente:
   - Build da imagem Docker
   - Push para registro interno
   - Deploy do container
   - Configuração de HTTPS

## ✅ Verificação Pós-Deploy

### 1. Verificar Health Check

```bash
curl https://seu-app.onrender.com/health
# Deve retornar: healthy
```

### 2. Acessar a Aplicação

```
https://seu-app.onrender.com
```

### 3. Verificar Logs

No painel do Render, vá em **"Logs"** para ver os logs em tempo real.

### 4. Testar Funcionalidades

- ✅ Homepage carrega
- ✅ Listagem de notícias
- ✅ CRUD de notícias
- ✅ Listagem de filmes (requer API key configurada)
- ✅ Paginação

## 🔄 Atualizações

O Render faz deploy automático quando você faz push para o branch configurado:

```bash
git add .
git commit -m "Update application"
git push origin main
```

O Render detectará o push e fará rebuild/redeploy automaticamente.

## 📊 Banco de Dados

### SQLite (Padrão)

Por padrão, a aplicação usa SQLite. No Render Free, os dados **não persistem** entre deploys.

### Opção 1: Usar Render PostgreSQL (Recomendado para Produção)

1. Crie um PostgreSQL Database no Render
2. Adicione as variáveis de ambiente:

```env
DB_CONNECTION=pgsql
DB_HOST=dpg-xxxxxxxxx.oregon-postgres.render.com
DB_PORT=5432
DB_DATABASE=seu_database
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

3. Instale a extensão PostgreSQL no Dockerfile (já incluída):
```dockerfile
RUN docker-php-ext-install pdo_pgsql
```

### Opção 2: Usar Render Disks (Para SQLite Persistente)

1. No painel do Render, vá em **"Disks"**
2. Adicione um disco montado em `/var/www/html/database`
3. Isso persistirá o arquivo SQLite entre deploys

## 🔒 Segurança

### Headers de Segurança

Já configurados no Nginx:
- ✅ X-Frame-Options
- ✅ X-Content-Type-Options
- ✅ X-XSS-Protection

### HTTPS

O Render fornece HTTPS automático com certificado gratuito.

### Variáveis Sensíveis

- ✅ Nunca commite `.env`
- ✅ Use variáveis de ambiente do Render
- ✅ APP_DEBUG=false em produção

## 💰 Custos

### Free Tier
- ✅ 750 horas/mês grátis
- ⚠️ Spin down após 15min de inatividade
- ⚠️ Cold start (~30s para acordar)
- ⚠️ Dados não persistem (SQLite)

### Starter ($7/mês)
- ✅ Sempre ativo
- ✅ 512MB RAM
- ✅ Pode adicionar discos para persistência

### Standard ($25/mês+)
- ✅ Mais recursos
- ✅ Melhor performance
- ✅ Mais instâncias

## 🐛 Troubleshooting

### Erro: "Application failed to respond"

**Solução:**
1. Verificar logs no painel do Render
2. Confirmar que `APP_KEY` está configurada
3. Verificar se migrations rodaram corretamente

### Erro: "API key not configured"

**Solução:**
Adicionar `RAPIDAPI_MOVIES_KEY` nas variáveis de ambiente.

### Container não inicia

**Solução:**
1. Verificar Dockerfile
2. Testar build local: `docker build -t test .`
3. Verificar logs de build no Render

### Assets não carregam

**Solução:**
1. Verificar se `npm run build` rodou no Dockerfile
2. Verificar permissões dos arquivos
3. Limpar cache: redeploy manual

## 📝 Comandos Úteis

### Acessar Shell do Container (se suportado)

```bash
# Via Render Shell (se disponível)
php artisan --version
php artisan migrate:status
php artisan cache:clear
```

### Forçar Rebuild

No painel do Render:
1. **"Manual Deploy"** → **"Clear build cache & deploy"**

## 🔗 Links Úteis

- [Render Docs - Docker](https://render.com/docs/docker)
- [Render Docs - Environment Variables](https://render.com/docs/environment-variables)
- [Render Community](https://community.render.com/)

## ✨ Checklist Final

Antes do deploy em produção:

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` gerada
- [ ] `RAPIDAPI_MOVIES_KEY` configurada
- [ ] Health check configurado
- [ ] HTTPS ativo
- [ ] Banco de dados configurado
- [ ] Testado localmente com Docker
- [ ] Logs verificados
- [ ] Funcionalidades testadas

---

**Última atualização:** Fevereiro 2026

**Suporte:** Em caso de problemas, consulte os logs do Render ou a documentação oficial.
