# Настройка почты для формы обратной связи

## Настройка в .env файле для Beget

Добавьте или обновите следующие параметры в файле `.env` на хостинге:

```env
# Адрес получателя писем с формы
MAIL_TO=info@inertlabs.ru

# Настройки отправки почты через SMTP Beget
MAIL_MAILER=smtp
MAIL_HOST=smtp.beget.com
MAIL_PORT=465
MAIL_USERNAME=info@inertlabs.ru
MAIL_PASSWORD=ваш_пароль_от_почты
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@inertlabs.ru
MAIL_FROM_NAME="Inertlab"
```

## Альтернативный вариант: sendmail (если SMTP не работает)

Если SMTP не работает, можно использовать sendmail:

```env
MAIL_MAILER=sendmail
MAIL_FROM_ADDRESS=info@inertlabs.ru
MAIL_FROM_NAME="Inertlab"
MAIL_TO=info@inertlabs.ru
```

## Информация о почтовых серверах Beget

**MX записи для домена:**
- mx1.beget.com
- mx2.beget.com

**Сервера входящей почты:**
- pop3.beget.com
- imap.beget.com

**Сервер исходящей почты:**
- smtp.beget.com (порт 465 с SSL или 587 с TLS)

## Настройка в .env файле (полный пример)

```env
# Адрес получателя писем с формы
MAIL_TO=info@inertlabs.ru

# SMTP настройки Beget
MAIL_MAILER=smtp
MAIL_HOST=smtp.beget.com
MAIL_PORT=465
MAIL_USERNAME=info@inertlabs.ru
MAIL_PASSWORD=ваш_пароль_от_почтового_ящика
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@inertlabs.ru
MAIL_FROM_NAME="Inertlab"
```

**Важно:** 
- Пароль - это пароль от почтового ящика `info@inertlabs.ru`, который вы создали в панели Beget
- Порт 465 использует SSL шифрование
- Альтернативно можно использовать порт 587 с TLS (MAIL_ENCRYPTION=tls)

## После настройки

```bash
# Очистите кэш конфигурации
php8.2 artisan config:clear
php8.2 artisan config:cache

# Проверьте настройки
php8.2 artisan tinker
>>> config('mail.from.address')
>>> config('mail.default')
>>> config('mail.mailers.smtp.host')
```

## Тестирование отправки

```bash
php8.2 artisan tinker
>>> Mail::raw('Тестовое сообщение', function($msg) { $msg->to('info@inertlabs.ru')->subject('Тест'); });
```

## Информация о почтовых серверах Beget

**MX записи для домена:**
- mx1.beget.com
- mx2.beget.com

**Сервера входящей почты:**
- pop3.beget.com
- imap.beget.com

**Сервер исходящей почты:**
- smtp.beget.com (порт 465 с SSL или 587 с TLS)

## Важно

- Убедитесь, что почтовый ящик info@inertlabs.ru создан в панели Beget
- Используйте пароль от почтового ящика в MAIL_PASSWORD
- Проверьте, что почта не попадает в спам
- SMTP более надежен, чем sendmail, для production окружения

