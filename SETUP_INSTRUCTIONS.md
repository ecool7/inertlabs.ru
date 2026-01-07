# Инструкция по настройке APP_KEY и базы данных

## APP_KEY (Ключ шифрования приложения)

### Формат APP_KEY

`APP_KEY` должен быть в формате:
```
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

Где `XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX` - это 32 байта данных, закодированные в base64.

### Генерация APP_KEY

**Автоматическая генерация (рекомендуется):**
```bash
php artisan key:generate
```

Эта команда автоматически:
1. Создаст случайный ключ
2. Добавит его в файл `.env` в формате `APP_KEY=base64:...`

**Пример сгенерированного ключа:**
```
APP_KEY=base64:uxF6afAyVWm0hi59RPbT/kutkxV0w0W+LgBovJdCfno=
```

### Проверка APP_KEY

После генерации проверьте, что ключ установлен:
```bash
php artisan tinker
>>> config('app.key')
```

Должно вернуться значение в формате `base64:...`

### Важно!

- **НЕ используйте один и тот же ключ на разных серверах**
- **НЕ коммитьте `.env` файл в git** (он уже в `.gitignore`)
- Каждый раз при развертывании на новом сервере генерируйте новый ключ

---

## База данных SQLite

### Создание файла database.sqlite

**Способ 1: Через команду touch (Linux/Mac)**
```bash
touch database/database.sqlite
```

**Способ 2: Через PHP**
```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

**Способ 3: Вручную**
Создайте пустой файл `database/database.sqlite` в папке `database/`

### Настройка прав доступа

```bash
chmod 664 database/database.sqlite
```

### Выполнение миграций

После создания файла выполните миграции:
```bash
php artisan migrate
```

### Проверка базы данных

Проверьте, что файл создан и доступен:
```bash
ls -la database/database.sqlite
```

Или через Artisan:
```bash
php artisan migrate:status
```

---

## Полная последовательность установки

```bash
# 1. Копируем .env.example в .env
cp .env.example .env

# 2. Генерируем APP_KEY
php artisan key:generate

# 3. Создаем базу данных
touch database/database.sqlite

# 4. Устанавливаем права
chmod 664 database/database.sqlite

# 5. Выполняем миграции
php artisan migrate

# 6. Очищаем кэш
php artisan config:clear
php artisan cache:clear
```

---

## Пример содержимого .env (важные параметры)

```env
APP_NAME="Inertlab"
APP_ENV=production
APP_KEY=base64:uxF6afAyVWm0hi59RPbT/kutkxV0w0W+LgBovJdCfno=
APP_DEBUG=false
APP_URL=https://inertlabs.ru

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

**Важно:** Путь к базе данных должен быть абсолютным!

