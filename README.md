# storeroom

**storeroom** — веб-платформа для аренды складских ячеек (кладовых). Проект позволяет пользователям находить и арендовать помещения для хранения вещей в различных городах.

## Предметная область

Платформа представляет собой маркетплейс складских помещений, где:

- **Города** — привязаны к географическим координатам, отображаются на карте
- **Складские объекты (WarehouseObject)** — здания/склады, принадлежащие организациям, с привязкой к адресу и городу
- **Складские ячейки (WarehouseCell)** — индивидуальные помещения для хранения с характеристиками: этаж, ряд, секция, уровень, номер, габариты (Д×Ш×В), объём, цена. Имеют статус (доступна/арендована и т.д.)
- **Организации** — юридические лица или ИП, владеющие складскими объектами
- **Тарифы** — гибкая система скидок при аренде на 1, 3, 6 или 12 месяцев (до 18% скидки)
- **Заказы (OrderCell)** — оформление аренды ячейки с оплатой через ЮKassa
- **Пользователи** — регистрация, верификация email, двухфакторная аутентификация

## Технологический стек

- **Backend:** Laravel 12, PHP 8.4, PostgreSQL, Redis
- **Frontend:** React 19, TypeScript, Inertia.js, Redux Toolkit, Leaflet (карты)
- **Админ-панель:** Filament 4
- **Файлы:** MinIO / S3 (AWS SDK)
- **Авторизация:** Laravel Fortify, Sanctum, Spatie Permissions
- **Инфраструктура:** Docker, Nginx

## Разработка

```bash
# Запуск локального окружения
docker compose -f docker-compose.local.yml up -d

# Установка зависимостей
docker compose -f docker-compose.local.yml exec php composer install

# Генерация Wayfinder
docker compose -f docker-compose.local.yml exec php /var/www/html/artisan wayfinder:generate --with-form

# Миграции
docker compose -f docker-compose.local.yml exec php /var/www/html/artisan migrate

# Настройка прав доступа
docker compose -f docker-compose.local.yml exec php /var/www/html/artisan permissions:setup

# Сидеры
docker compose -f docker-compose.local.yml exec php /var/www/html/artisan db:seed
```
