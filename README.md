
# Финальный проект. SF-AdTech

## Используемые технологии
* HTML
* Java Script
* PHP
* Docker
* SQL
* Composer

### Для запуска необходимо:
1. Установить Docker
2. Установить Docker Compose
3. У веб сервера должен быть включен mod_rewrite `RewriteEngine on`
6. Переименовать .env.example в .env
4. Звпустить установщик контейнеров из терминала `docker-compose up -d`
5. Зайти в контейнер `php` и ввести комманду `composer install`
7. Чтобы приложение было доступно по адрессу final.project, его нужно внести в hosts `127.0.0.1 final.project`


### Конфигурация

За конфигурацию приложения отвечают файлы, которые находятся в папке `config`.

- `app.php` - конфигурация приложения, в том числе хост
- `database.php` - конфигурация базы данных
- `auth.php` - конфигурация аутентификации пользователя

### База данных

Для работы приложения необходимо импортировать дамп базы данных, который находится в папке `database`.
У тестового пользователя с правами администратора пароль 123123123

### Info
Все логи по переходам по ссылкам пишуться в файл mylog.log который находится в папке public
Все подписки и офферы отображаются в админке.
Статистика у вебмастеров и рекламодателей по доходам, расходам и т.д. отображается в оффере (вебмастер так же смотрим там, перейти можно из подписки).
У администратора отдельно можно посмотреть общую статистику в разделе "Статистика".
P.S. Какоето время сайт недоступен, пока composer устанавливает зависимости.

### Возможности приложения
https://skrinshoter.ru/vMY6VmsKUKz?a

https://skrinshoter.ru/vMYI81o9GYC?a

https://skrinshoter.ru/vMYUqGLpMGe?a

https://skrinshoter.ru/vMYz7crOaet?a

https://skrinshoter.ru/vMYCp8KEGyh?a

https://skrinshoter.ru/vMYy1HdrB5V?a

https://skrinshoter.ru/vMY4cjHqqvh?a

https://skrinshoter.ru/vMYYXkddRsn?a

https://skrinshoter.ru/vMYLaUD3ErJ?a