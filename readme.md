# Todo php-mysql-ajax

Список дел.

- Наличие авторизации и регистрации
- Сохранение в бд (обращение к бд через REST API)
- Бэкенд на php

## Начало

Клонирование репозитория:
> git clone https://github.com/bondarartem/todo-php.git

####Структура БД
<b>user</b>
>___ 
>id - int
>
>username - varchar(255)
>
>password_hash - varchar(255)
>
>email - varchar(255)
>
>checkword - varchar(255)
>
>is_active - tinyint(4)
>
>share_link - varchar(255)
>
>created_at - timestamp

<b>task</b>
>___ 
>id - int
>
>text - varchar(255)
>
>author_id - int
>
>is_active - tinyint(4)
>
>is_done - tinyint(4)
>
>created_at - timestamp

<b>Переменные бд хранятся в файле</b>
>/app/class/CBD.php

## Демо

> https://bondarartem.ru

___
####TODO:
>
>1. тесты с помощью phpunit
>2. Кэширование и инвалидация кэша
>3. Поделиться todo-списком (с учетом ролей)