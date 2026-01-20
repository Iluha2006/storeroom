Как развернуть проект локально:
1. Создать файл .env в корне проекта и заполнить, образец файла .env.example
2. Выполнить команду docker compose -f docker-compose.local.yml
3. Выполнить установку vendor docker compose -f docker-compose.local.yml exec php composer install
4. Выполнить миграции docker compose -f docker-compose.local.yml exec php /var/www/html/artisan migrate
5. Установить роли и разрешения docker compose -f docker-compose.local.yml exec php /var/www/html/artisan permissions:setup
6. Создать суперпользователя docker compose -f docker-compose.local.yml exec php /var/www/html/artisan db:seed