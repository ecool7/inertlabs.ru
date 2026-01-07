#!/bin/bash

# Скрипт автоматической установки проекта Inertlab
# Использование: bash setup.sh

set -e

echo "🚀 Начало установки проекта Inertlab..."

# Проверка наличия PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP не найден. Установите PHP 8.2 или выше."
    exit 1
fi

echo "✅ PHP найден: $(php -v | head -n 1)"

# Шаг 1: Установка зависимостей Composer
echo ""
echo "📦 Установка зависимостей Composer..."
if [ -f "composer.phar" ]; then
    php composer.phar install --no-dev --optimize-autoloader
else
    composer install --no-dev --optimize-autoloader
fi

# Шаг 2: Копирование .env
echo ""
echo "📝 Настройка окружения..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✅ Файл .env создан из .env.example"
    else
        echo "❌ Файл .env.example не найден!"
        exit 1
    fi
else
    echo "ℹ️  Файл .env уже существует"
fi

# Шаг 3: Генерация APP_KEY
echo ""
echo "🔑 Генерация ключа приложения..."
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    php artisan key:generate --force
    echo "✅ Ключ приложения сгенерирован"
else
    echo "ℹ️  Ключ приложения уже установлен"
fi

# Шаг 4: Создание базы данных SQLite
echo ""
echo "💾 Создание базы данных..."
if [ ! -f "database/database.sqlite" ]; then
    touch database/database.sqlite
    chmod 664 database/database.sqlite
    echo "✅ Файл database.sqlite создан"
else
    echo "ℹ️  Файл database.sqlite уже существует"
fi

# Шаг 5: Установка прав доступа
echo ""
echo "🔐 Установка прав доступа..."
chmod -R 775 storage bootstrap/cache
echo "✅ Права доступа установлены"

# Шаг 6: Выполнение миграций
echo ""
echo "🗄️  Выполнение миграций базы данных..."
php artisan migrate --force

# Шаг 7: Очистка кэша
echo ""
echo "🧹 Очистка кэша..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo "✅ Кэш очищен"

# Шаг 8: Оптимизация для production
echo ""
echo "⚡ Оптимизация для production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Оптимизация завершена"

echo ""
echo "✨ Установка завершена успешно!"
echo ""
echo "📋 Следующие шаги:"
echo "1. Проверьте настройки в файле .env"
echo "2. Убедитесь, что APP_URL указан правильно"
echo "3. Проверьте права доступа к storage и bootstrap/cache"
echo "4. Откройте сайт в браузере"

