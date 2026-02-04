# 🐳 Docker - Clickweb Backend

Guia completo para trabalhar com Docker neste projeto.

## 📁 Arquivos Docker

```
clickweb_backend1/
├── Dockerfile                 # Imagem Docker multi-stage
├── .dockerignore             # Arquivos ignorados no build
├── docker-compose.yml        # Orquestração local
├── render.yaml              # Config automática Render
├── docker/
│   ├── nginx.conf           # Configuração Nginx
│   ├── default.conf         # Virtual host Nginx
│   ├── supervisord.conf     # Supervisord config
│   └── start.sh             # Script de inicialização
└── RENDER_DEPLOY.md         # Guia de deploy Render
```

## 🚀 Quick Start

### Desenvolvimento Local

```bash
# 1. Criar arquivo .env
cp .env.example .env
# Editar .env com suas configurações

# 2. Build e iniciar
docker-compose up -d

# 3. Verificar status
docker-compose ps

# 4. Ver logs
docker-compose logs -f app

# 5. Acessar aplicação
open http://localhost:8080
```

### Build Manual

```bash
# Build da imagem
docker build -t clickweb-backend:latest .

# Executar container
docker run -d \
  -p 8080:8080 \
  -e APP_KEY=base64:$(openssl rand -base64 32) \
  -e RAPIDAPI_MOVIES_KEY=your_key_here \
  --name clickweb \
  clickweb-backend:latest

# Verificar logs
docker logs -f clickweb

# Acessar shell
docker exec -it clickweb sh

# Parar e remover
docker stop clickweb && docker rm clickweb
```

## 🏗️ Arquitetura do Dockerfile

### Multi-Stage Build

O Dockerfile usa 4 stages para otimização:

1. **Base:** Instalação de dependências do sistema
2. **Dependencies:** Instalação de dependências PHP e Node
3. **Build:** Compilação dos assets
4. **Production:** Imagem final otimizada

### Componentes

- **PHP 8.2 FPM:** Processamento PHP
- **Nginx:** Servidor web
- **Supervisor:** Gerenciamento de processos
- **Node.js:** Build de assets (removido da imagem final)

### Portas

- **8080:** HTTP (Nginx)

## 📋 Comandos Docker Compose

```bash
# Iniciar serviços
docker-compose up -d

# Parar serviços
docker-compose down

# Ver logs
docker-compose logs -f

# Rebuild
docker-compose up -d --build

# Executar comandos
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear

# Remover volumes
docker-compose down -v
```

## 🔧 Comandos Úteis

### Laravel Artisan

```bash
# Via Docker Compose
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:list

# Via Docker run
docker exec clickweb php artisan migrate
```

### Acessar Shell

```bash
# Via Docker Compose
docker-compose exec app sh

# Via Docker
docker exec -it clickweb sh
```

### Verificar Logs

```bash
# Logs do container
docker-compose logs -f app

# Logs do Nginx
docker-compose exec app tail -f /var/log/nginx/access.log
docker-compose exec app tail -f /var/log/nginx/error.log

# Logs do Laravel
docker-compose exec app tail -f storage/logs/laravel.log
```

## 🔍 Health Check

O container inclui health check automático:

```bash
# Verificar status
docker inspect --format='{{.State.Health.Status}}' clickweb

# Testar endpoint
curl http://localhost:8080/health
```

## 🌍 Variáveis de Ambiente

### Essenciais

```env
APP_KEY=base64:your_key_here
RAPIDAPI_MOVIES_KEY=your_api_key
```

### Completas

Veja `.env.example` para lista completa.

## 📦 Otimizações

### Tamanho da Imagem

- **Base Alpine:** ~50MB
- **Final:** ~200-300MB

### Build Cache

```bash
# Build sem cache
docker build --no-cache -t clickweb-backend .

# Build com BuildKit
DOCKER_BUILDKIT=1 docker build -t clickweb-backend .
```

### Limpeza

```bash
# Remover imagens não utilizadas
docker image prune -a

# Remover volumes não utilizados
docker volume prune

# Limpeza completa
docker system prune -a --volumes
```

## 🔐 Segurança

### Melhores Práticas Implementadas

- ✅ Imagem Alpine (menor superfície de ataque)
- ✅ Multi-stage build (sem dependências de dev)
- ✅ Non-root user (www-data)
- ✅ Health checks
- ✅ Security headers (Nginx)
- ✅ Secrets via env vars (não hardcoded)

### Scan de Vulnerabilidades

```bash
# Com Docker Scout
docker scout cves clickweb-backend:latest

# Com Trivy
trivy image clickweb-backend:latest
```

## 🐛 Troubleshooting

### Container não inicia

```bash
# Ver logs detalhados
docker logs clickweb

# Verificar erros
docker-compose logs app
```

### Permissões

```bash
# Ajustar permissões manualmente
docker exec clickweb chmod -R 775 storage bootstrap/cache
docker exec clickweb chown -R www-data:www-data storage bootstrap/cache
```

### Assets não carregam

```bash
# Rebuild completo
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Migrations não rodaram

```bash
# Executar manualmente
docker-compose exec app php artisan migrate --force
```

## 📊 Monitoramento

### Recursos do Container

```bash
# Uso de CPU e memória
docker stats clickweb

# Processos
docker top clickweb
```

### Logs em Tempo Real

```bash
# Todos os logs
docker-compose logs -f

# Apenas app
docker-compose logs -f app
```

## 🚀 Deploy para Produção

Veja guias específicos:

- **Render:** [RENDER_DEPLOY.md](./RENDER_DEPLOY.md)
- **Outras plataformas:** Adapte o Dockerfile conforme necessário

## 📝 Notas

### SQLite em Docker

Por padrão usa SQLite. Para persistir dados:

```yaml
# docker-compose.yml
volumes:
  - ./database:/var/www/html/database
```

### PostgreSQL/MySQL

Para usar PostgreSQL ou MySQL, configure as variáveis de ambiente:

```env
DB_CONNECTION=mysql
DB_HOST=db_host
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=user
DB_PASSWORD=password
```

## 🔗 Recursos

- [Documentação Docker](https://docs.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Laravel Docker Best Practices](https://laravel.com/docs/deployment)

---

**Dúvidas?** Consulte a documentação ou abra uma issue.
