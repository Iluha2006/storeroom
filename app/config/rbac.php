<?php

use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;

return [
    'mapping' => [
        'guards' => [
            'web' => [
                // Суперпользователь - все разрешения
                UserRoleEnum::Superuser->value => UserPermissionEnum::list(),

                // Разработчик - все разрешения
                UserRoleEnum::Developer->value => UserPermissionEnum::list(),

                // Администратор
                UserRoleEnum::Admin->value => [
                    UserPermissionEnum::AdminPanel->value,

                    // Пользователи
                    UserPermissionEnum::UserView->value,
                    UserPermissionEnum::UserViewAny->value,
                    UserPermissionEnum::UserViewTrash->value,
                    UserPermissionEnum::UserCreate->value,
                    UserPermissionEnum::UserEdit->value,
                    UserPermissionEnum::UserDelete->value,
                    UserPermissionEnum::UserRestore->value,

                    UserPermissionEnum::UserRoleView->value,
                    UserPermissionEnum::UserRoleEdit->value,
                    UserPermissionEnum::UserPermissionView->value,
                    UserPermissionEnum::UserPermissionEdit->value,

                    // Роли
                    UserPermissionEnum::RoleView->value,
                    UserPermissionEnum::RoleViewAny->value,

                    // Разрешения
                    UserPermissionEnum::PermissionView->value,
                    UserPermissionEnum::PermissionViewAny->value,

                    // Файлы
                    UserPermissionEnum::FileView->value,
                    UserPermissionEnum::FileViewAny->value,
                    UserPermissionEnum::FileViewTrash->value,
                    UserPermissionEnum::FileViewAny->value,
                    UserPermissionEnum::FileEdit->value,
                    UserPermissionEnum::FileDelete->value,
                    UserPermissionEnum::FileRestore->value,

                    // Города
                    UserPermissionEnum::CityView->value,
                    UserPermissionEnum::CityViewAny->value,
                    UserPermissionEnum::CityViewTrash->value,
                    UserPermissionEnum::CityCreate->value,
                    UserPermissionEnum::CityEdit->value,
                    UserPermissionEnum::CityDelete->value,
                    UserPermissionEnum::CityRestore->value,

                    // Адреса
                    UserPermissionEnum::AddressView->value,
                    UserPermissionEnum::AddressViewAny->value,
                    UserPermissionEnum::AddressViewTrash->value,
                    UserPermissionEnum::AddressCreate->value,
                    UserPermissionEnum::AddressEdit->value,
                    UserPermissionEnum::AddressDelete->value,
                    UserPermissionEnum::AddressRestore->value,

                    // Объекты
                    UserPermissionEnum::WarehouseObjectView->value,
                    UserPermissionEnum::WarehouseObjectViewAny->value,
                    UserPermissionEnum::WarehouseObjectViewTrash->value,
                    UserPermissionEnum::WarehouseObjectCreate->value,
                    UserPermissionEnum::WarehouseObjectEdit->value,
                    UserPermissionEnum::WarehouseObjectDelete->value,
                    UserPermissionEnum::WarehouseObjectRestore->value,

                    // Ячейки
                    UserPermissionEnum::WarehouseCellView->value,
                    UserPermissionEnum::WarehouseCellViewAny->value,
                    UserPermissionEnum::WarehouseCellViewTrash->value,
                    UserPermissionEnum::WarehouseCellCreate->value,
                    UserPermissionEnum::WarehouseCellEdit->value,
                    UserPermissionEnum::WarehouseCellDelete->value,
                    UserPermissionEnum::WarehouseCellRestore->value,

                    // Организации
                    UserPermissionEnum::OrganizationView->value,
                    UserPermissionEnum::OrganizationViewAny->value,
                    UserPermissionEnum::OrganizationViewTrash->value,
                    UserPermissionEnum::OrganizationCreate->value,
                    UserPermissionEnum::OrganizationEdit->value,
                    UserPermissionEnum::OrganizationDelete->value,
                    UserPermissionEnum::OrganizationRestore->value,

                    // Отчеты
                    UserPermissionEnum::ReportView->value,
                    UserPermissionEnum::ReportViewAny->value,
                    UserPermissionEnum::ReportViewTrash->value,
                    UserPermissionEnum::ReportCreate->value,
                    UserPermissionEnum::ReportEdit->value,
                    UserPermissionEnum::ReportDelete->value,
                    UserPermissionEnum::ReportRestore->value,

                    // Заказы
                    UserPermissionEnum::OrderView->value,
                    UserPermissionEnum::OrderViewAny->value,
                    UserPermissionEnum::OrderViewTrash->value,
                    UserPermissionEnum::OrderDelete->value,
                    UserPermissionEnum::OrderRestore->value,

                    // Платежи
                    UserPermissionEnum::PaymentView->value,
                    UserPermissionEnum::PaymentViewAny->value,
                    UserPermissionEnum::PaymentViewTrash->value,
                    UserPermissionEnum::PaymentDelete->value,
                    UserPermissionEnum::PaymentRestore->value,
                ],

                // Модератор
                UserRoleEnum::Moderator->value => [
                    UserPermissionEnum::AdminPanel->value,

                    // Пользователи
                    UserPermissionEnum::UserView->value,
                    UserPermissionEnum::UserViewAny->value,

                    // Файлы
                    UserPermissionEnum::FileView->value,
                    UserPermissionEnum::FileViewAny->value,
                    UserPermissionEnum::FileCreate->value,
                    UserPermissionEnum::FileEdit->value,
                    UserPermissionEnum::FileDelete->value,

                    // Города
                    UserPermissionEnum::CityView->value,
                    UserPermissionEnum::CityCreate->value,
                    UserPermissionEnum::CityEdit->value,
                    UserPermissionEnum::CityDelete->value,
                    UserPermissionEnum::CityRestore->value,

                    // Адреса
                    UserPermissionEnum::AddressView->value,
                    UserPermissionEnum::AddressViewAny->value,
                    UserPermissionEnum::AddressCreate->value,
                    UserPermissionEnum::AddressEdit->value,
                    UserPermissionEnum::AddressDelete->value,
                    UserPermissionEnum::AddressRestore->value,

                    // Объекты
                    UserPermissionEnum::WarehouseObjectView->value,
                    UserPermissionEnum::WarehouseObjectViewAny->value,
                    UserPermissionEnum::WarehouseObjectCreate->value,
                    UserPermissionEnum::WarehouseObjectEdit->value,
                    UserPermissionEnum::WarehouseObjectDelete->value,
                    UserPermissionEnum::WarehouseObjectRestore->value,

                    // Ячейки
                    UserPermissionEnum::WarehouseCellView->value,
                    UserPermissionEnum::WarehouseCellViewAny->value,
                    UserPermissionEnum::WarehouseCellCreate->value,
                    UserPermissionEnum::WarehouseCellEdit->value,
                    UserPermissionEnum::WarehouseCellDelete->value,
                    UserPermissionEnum::WarehouseCellRestore->value,

                    // Организации
                    UserPermissionEnum::OrganizationView->value,
                    UserPermissionEnum::OrganizationViewAny->value,
                    UserPermissionEnum::OrganizationCreate->value,
                    UserPermissionEnum::OrganizationEdit->value,
                    UserPermissionEnum::OrganizationDelete->value,
                    UserPermissionEnum::OrganizationRestore->value,

                    // Отчеты
                    UserPermissionEnum::ReportView->value,
                    UserPermissionEnum::ReportViewAny->value,
                    UserPermissionEnum::ReportCreate->value,
                    UserPermissionEnum::ReportEdit->value,
                    UserPermissionEnum::ReportDelete->value,
                    UserPermissionEnum::ReportRestore->value,

                    // Заказы
                    UserPermissionEnum::OrderView->value,
                    UserPermissionEnum::OrderViewAny->value,

                    // Платежи
                    UserPermissionEnum::PaymentView->value,
                    UserPermissionEnum::PaymentViewAny->value,
                ],

                // Партнер - доступ к организациям, заказам и отчетам
                UserRoleEnum::Partner->value => [
                    UserPermissionEnum::AdminPanel->value,

                    // Города
                    UserPermissionEnum::CityView->value,

                    // Адреса
                    UserPermissionEnum::AddressView->value,

                    // Объекты
                    UserPermissionEnum::WarehouseObjectView->value,

                    // Ячейки
                    UserPermissionEnum::WarehouseCellView->value,

                    // Отчеты
                    UserPermissionEnum::ReportView->value,
                    UserPermissionEnum::ReportCreate->value,
                    UserPermissionEnum::ReportEdit->value,
                    UserPermissionEnum::ReportDelete->value,

                    // Заказы
                    UserPermissionEnum::OrderView->value,

                    // Платежи
                    UserPermissionEnum::PaymentView->value,
                ],

                // Завхоз - управление кладовыми и адресами
                UserRoleEnum::Steward->value => [
                    UserPermissionEnum::AdminPanel->value,

                    // Файлы
                    UserPermissionEnum::FileViewAny->value,

                    // Города
                    UserPermissionEnum::CityView->value,

                    // Адреса
                    UserPermissionEnum::AddressView->value,

                    // Объекты
                    UserPermissionEnum::WarehouseObjectView->value,

                    // Ячейки
                    UserPermissionEnum::WarehouseCellView->value,
                ],

                // Пользователь - минимальные права
                UserRoleEnum::User->value => [
                    // Базовый доступ без админ панели
                    // Файлы
                    UserPermissionEnum::FileViewAny->value,

                    // Города
                    UserPermissionEnum::CityViewAny->value,

                    // Адреса
                    UserPermissionEnum::AddressViewAny->value,

                    // Объекты
                    UserPermissionEnum::WarehouseObjectViewAny->value,

                    // Ячейки
                    UserPermissionEnum::WarehouseCellViewAny->value,

                    // Заказы
                    UserPermissionEnum::OrderCreate->value,

                    // Платежи
                    UserPermissionEnum::PaymentCreate->value,
                ],
            ],
            'api' => [],
        ],
    ],
];
