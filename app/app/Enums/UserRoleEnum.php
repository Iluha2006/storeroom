<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRoleEnum: string
{
    case Superuser = 'superuser';
    case Developer = 'developer';
    case Admin = 'admin';
    case Moderator = 'moderator';
    case Partner = 'partner';
    case Steward = 'steward';
    case User = 'user';

    public static function list(): array
    {
        return array_map(fn(self $item) => $item->value, self::cases());
    }

    public static function forForm(): array
    {
        return [
            self::Superuser->value => 'Суперпользователь',
            self::Developer->value => 'Разработчик',
            self::Admin->value => 'Администратор',
            self::Moderator->value => 'Модератор',
            self::Partner->value => 'Партнер',
            self::Steward->value => 'Завхоз',
            self::User->value => 'Пользователь',
        ];
    }

    public function label(): string
    {
        return self::forForm()[$this->value];
    }
}
