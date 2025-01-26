# Инструкция по запуску проекта

Этот проект представляет собой Laravel-приложение, развернутое с использованием Docker. Ниже приведена пошаговая
инструкция по запуску проекта.

---

## Требования

- Установленный Docker и Docker Compose.
- Git (для клонирования репозитория).

---

## Шаги для запуска

### 1. Клонируйте репозиторий

Склонируйте репозиторий на ваш компьютер:

```bash
git clone https://github.com/Sorn221/AlyansTestTask.git
cd AlyansTestTask
```

### 2. Настройте файл .env

Скопируйте файл .env.example в .env:

```bash
cp .env.example .env
```

Откройте файл .env и убедитесь, что настройки базы данных соответствуют следующим значениям:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel_user
DB_PASSWORD=secret
```

### 3. Запустите Docker-контейнеры

Запустите контейнеры с помощью Docker Compose:

```bash
docker-compose up -d
```

Эта команда создаст и запустит следующие сервисы:

- app: Контейнер с PHP и Laravel.

- webserver: Контейнер с Nginx.

- db: Контейнер с MySQL.

- phpmyadmin: Контейнер с PHPMyAdmin для управления базой данных.

### 4. Установка зависимостей

```bash
docker-compose exec app composer install
```

### 5. Сгенерируйте ключ приложения

```bash
docker-compose exec app php artisan key:generate
```

### 6. Установка зависимостей

```bash
docker-compose exec app composer install
```

### 7. Запустите миграции

```bash
docker-compose exec app php artisan migrate
```

### 7. Заполните бд тестовыми данными

В браузере перейдите: http://localhost:8081

- Логин: root

- Пароль: secret

Откройте бд "laravel" ---> sql ---> выполните скрипт из файла test-data.sql

### 7. Откройте проект в браузере

После успешного запуска откройте проект в браузере:

```
Приложение: http://localhost:8080
```
