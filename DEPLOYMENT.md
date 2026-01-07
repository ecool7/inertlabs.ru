# Инструкция по развертыванию проекта Inertlab

## Проблемы при развертывании и их решение

### Проблема 1: Отсутствует APP_KEY в .env

**Решение:**
После копирования `.env.example` в `.env` необходимо сгенерировать ключ приложения:

```bash
php artisan key:generate
```

Или для PHP 8.2:
```bash
php8.2 artisan key:generate
```

Эта команда автоматически добавит строку `APP_KEY=base64:...` в файл `.env`.

### Проблема 2: Отсутствует файл database.sqlite

**Решение:**
Создайте пустой файл базы данных SQLite:

```bash
touch database/database.sqlite
```

Или через PHP:
```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Затем выполните миграции:
```bash
php artisan migrate
```

## Полная инструкция по развертыванию

### Шаг 1: Распаковка архива

Распакуйте архив в директорию проекта (например, `~/inertlabs.ru`).

### Шаг 2: Установка зависимостей

```bash
composer install --no-dev --optimize-autoloader
```

### Шаг 3: Настройка окружения

```bash
# Копируем файл окружения
cp .env.example .env

# Генерируем ключ приложения
php artisan key:generate

# Создаем файл базы данных SQLite
touch database/database.sqlite

# Устанавливаем права доступа
chmod 664 database/database.sqlite
chmod 775 storage
chmod 775 bootstrap/cache
```

### Шаг 4: Настройка .env файла

Откройте файл `.env` и проверьте/настройте следующие параметры:

```env
APP_NAME="Inertlab"
APP_ENV=production
APP_KEY=base64:...  # Должен быть сгенерирован командой key:generate
APP_DEBUG=false
APP_URL=https://inertlabs.ru

DB_CONNECTION=sqlite
DB_DATABASE=/home/z/zeniia8p/inertlabs.ru/database/database.sqlite
```

**Важно:** Убедитесь, что путь к базе данных указан абсолютным путем.

### Шаг 5: Выполнение миграций

```bash
php artisan migrate --force
```

### Шаг 6: Очистка кэша

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Шаг 7: Оптимизация (опционально, для production)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Автоматическая установка (одной командой)

Если у вас есть доступ к composer, можно использовать встроенный скрипт:

```bash
composer run setup
```

Этот скрипт выполнит:
1. `composer install`
2. Копирование `.env.example` в `.env` (если не существует)
3. Генерацию `APP_KEY`
4. Выполнение миграций
5. Установку npm зависимостей и сборку

## Проверка установки

После выполнения всех шагов проверьте:

1. **Проверка ключа:**
   ```bash
   php artisan tinker
   >>> config('app.key')
   ```
   Должен вернуть непустое значение.

2. **Проверка базы данных:**
   ```bash
   ls -la database/database.sqlite
   ```
   Файл должен существовать и иметь права на чтение/запись.

3. **Проверка подключения к БД:**
   ```bash
   php artisan migrate:status
   ```

## Частые ошибки

### Ошибка: "Database file at path [...] does not exist"

**Причина:** Файл `database.sqlite` не создан или путь указан неверно.

**Решение:**
```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

И проверьте путь в `.env` - он должен быть абсолютным.

### Ошибка: "No application encryption key has been specified"

**Причина:** В `.env` отсутствует или пустой `APP_KEY`.

**Решение:**
```bash
php artisan key:generate
```

### Ошибка прав доступа к storage или cache

**Решение:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Контакты

При возникновении проблем обращайтесь к разработчику проекта.

