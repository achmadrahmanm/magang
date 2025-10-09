# Laravel 12 Docker Setup

## 🧱 What you've built

| Component | Role | Container |
|-----------|------|-----------|
| Laravel 12 (PHP-FPM) | Core application | laravel12-app |
| Nginx | Web server proxy | laravel12-nginx |
| MySQL 8.0 | Database | laravel12-db |
| Redis 7-alpine | Cache & queues | laravel12-redis |

## 🚀 How to run the project locally

### Prerequisites
- Docker
- Docker Compose

### Steps

1. **Clone the repository**
    ```bash
    git clone <your-repo-url>
    cd <project-directory>
    ```

2. **Build and start containers**
    ```bash
    docker-compose up -d --build
    ```

3. **Install dependencies**
    ```bash
    docker-compose exec laravel12-app composer install
    ```

4. **Set up environment**
    ```bash
    docker-compose exec laravel12-app cp .env.example .env
    docker-compose exec laravel12-app php artisan key:generate
    ```

5. **Run migrations**
    ```bash
    docker-compose exec laravel12-app php artisan migrate
    ```

6. **Access the application**
    - Web: http://localhost
    - Database: localhost:3306
    - Redis: localhost:6379

### Useful commands
```bash
# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Access container shell
docker-compose exec laravel12-app bash
```