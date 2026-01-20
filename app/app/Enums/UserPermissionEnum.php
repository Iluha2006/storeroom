<?php

declare(strict_types=1);

namespace App\Enums;

enum UserPermissionEnum: string
{
    case AdminPanel = 'admin.panel';

    case UserView = 'user.view';
    case UserViewAny = 'user.view.any';
    case UserViewTrash = 'user.view.trash';
    case UserCreate = 'user.create';
    case UserEdit = 'user.edit';
    case UserDelete = 'user.delete';
    case UserDeleteForce = 'user.delete.force';
    case UserRestore = 'user.restore';

    case UserRoleView = 'user.role.view';
    case UserRoleEdit = 'user.role.edit';
    case UserRoleDelete = 'user.role.delete';

    case UserPermissionView = 'user.permission.view';
    case UserPermissionEdit = 'user.permission.edit';
    case UserPermissionDelete = 'user.permission.delete';

    case RoleView = 'role.view';
    case RoleViewAny = 'role.view.any';

    case PermissionView = 'permission.view';
    case PermissionViewAny = 'permission.view.any';

    case FileView = 'file.view';
    case FileViewAny = 'file.view.any';
    case FileViewTrash = 'file.view.trash';
    case FileCreate = 'file.create';
    case FileEdit = 'file.edit';
    case FileDelete = 'file.delete';
    case FileDeleteForce = 'file.delete.force';
    case FileRestore = 'file.restore';

    case CityView = 'city.view';
    case CityViewAny = 'city.view.any';
    case CityViewTrash = 'city.view.trash';
    case CityCreate = 'city.create';
    case CityEdit = 'city.edit';
    case CityDelete = 'city.delete';
    case CityDeleteForce = 'city.delete.force';
    case CityRestore = 'city.restore';

    case AddressView = 'address.view';
    case AddressViewAny = 'address.view.any';
    case AddressViewTrash = 'address.view.trash';
    case AddressCreate = 'address.create';
    case AddressEdit = 'address.edit';
    case AddressDelete = 'address.delete';
    case AddressDeleteForce = 'address.delete.force';
    case AddressRestore = 'address.restore';

    case WarehouseObjectView = 'warehouse_object.view';
    case WarehouseObjectViewAny = 'warehouse_object.view.any';
    case WarehouseObjectViewTrash = 'warehouse_object.view.trash';
    case WarehouseObjectCreate = 'warehouse_object.create';
    case WarehouseObjectEdit = 'warehouse_object.edit';
    case WarehouseObjectDelete = 'warehouse_object.delete';
    case WarehouseObjectDeleteForce = 'warehouse_object.delete.force';
    case WarehouseObjectRestore = 'warehouse_object.restore';

    case WarehouseCellView = 'warehouse_cell.view';
    case WarehouseCellViewAny = 'warehouse_cell.view.any';
    case WarehouseCellViewTrash = 'warehouse_cell.view.trash';
    case WarehouseCellCreate = 'warehouse_cell.create';
    case WarehouseCellEdit = 'warehouse_cell.edit';
    case WarehouseCellDelete = 'warehouse_cell.delete';
    case WarehouseCellDeleteForce = 'warehouse_cell.delete.force';
    case WarehouseCellRestore = 'warehouse_cell.restore';

    case OrganizationView = 'organization.view';
    case OrganizationViewAny = 'organization.view.any';
    case OrganizationViewTrash = 'organization.view.trash';
    case OrganizationCreate = 'organization.create';
    case OrganizationEdit = 'organization.edit';
    case OrganizationDelete = 'organization.delete';
    case OrganizationDeleteForce = 'organization.delete.force';
    case OrganizationRestore = 'organization.restore';

    case ReportView = 'report.view';
    case ReportViewAny = 'report.view.any';
    case ReportViewTrash = 'report.view.trash';
    case ReportCreate = 'report.create';
    case ReportEdit = 'report.edit';
    case ReportDelete = 'report.delete';
    case ReportDeleteForce = 'report.delete.force';
    case ReportRestore = 'report.restore';

    case OrderView = 'order.view';
    case OrderViewAny = 'order.view.any';
    case OrderViewTrash = 'order.view.trash';
    case OrderCreate = 'order.create';
    case OrderEdit = 'order.edit';
    case OrderDelete = 'order.delete';
    case OrderDeleteForce = 'order.delete.force';
    case OrderRestore = 'order.restore';

    case PaymentView = 'payment.view';
    case PaymentViewAny = 'payment.view.any';
    case PaymentViewTrash = 'payment.view.trash';
    case PaymentCreate = 'payment.create';
    case PaymentEdit = 'payment.edit';
    case PaymentDelete = 'payment.delete';
    case PaymentDeleteForce = 'payment.delete.force';
    case PaymentRestore = 'payment.restore';

    public static function list(): array
    {
        return array_map(fn(self $item) => $item->value, self::cases());
    }

    public static function forForm(): array
    {
        return [
            self::AdminPanel->value => 'Доступ в административную панель',

            self::UserView->value => 'Просмотр пользователя',
            self::UserViewAny->value => 'Просмотр всех пользователей',
            self::UserViewTrash->value => 'Просмотр удалённых пользователей',
            self::UserCreate->value => 'Создание пользователя',
            self::UserEdit->value => 'Редактирование пользователя',
            self::UserDelete->value => 'Удаление пользователя',
            self::UserDeleteForce->value => 'Полное удаление пользователя',
            self::UserRestore->value => 'Восстановление пользователя',

            self::UserRoleView->value => 'Просмотр роли пользователя',
            self::UserRoleEdit->value => 'Редактирование роли пользователя',
            self::UserRoleDelete->value => 'Удаление роли пользователя',

            self::UserPermissionView->value => 'Просмотр разрешения пользователя',
            self::UserPermissionEdit->value => 'Редактирование разрешения пользователя',
            self::UserPermissionDelete->value => 'Удаление разрешения пользователя',

            self::RoleView->value => 'Просмотр роли',
            self::RoleViewAny->value => 'Просмотр всех ролей',

            self::PermissionView->value => 'Просмотр разрешения',
            self::PermissionViewAny->value => 'Просмотр всех разрешений',

            self::FileView->value => 'Просмотр файла',
            self::FileViewAny->value => 'Просмотр всех файлов',
            self::FileViewTrash->value => 'Просмотр удалённых файлов',
            self::FileEdit->value => 'Загрузка файла',
            self::FileDelete->value => 'Удаление файла',
            self::FileDeleteForce->value => 'Полное удаление ',
            self::FileRestore->value => 'Восстановление ',

            self::CityView->value => 'Просмотр города',
            self::CityViewAny->value => 'Просмотр всех городов',
            self::CityViewTrash->value => 'Просмотр удалённых городов',
            self::CityCreate->value => 'Создание города',
            self::CityEdit->value => 'Изменение города',
            self::CityDelete->value => 'Удаление города',
            self::CityDeleteForce->value => 'Полное удаление города',
            self::CityRestore->value => 'Восстановление города',

            self::AddressView->value => 'Просмотр адреса',
            self::AddressViewAny->value => 'Просмотр всех адресов',
            self::AddressViewTrash->value => 'Просмотр удалённых адресов',
            self::AddressCreate->value => 'Создание адреса',
            self::AddressEdit->value => 'Изменение адреса',
            self::AddressDelete->value => 'Удаление адреса',
            self::AddressDeleteForce->value => 'Полное удаление адреса',
            self::AddressRestore->value => 'Восстановление адреса',

            self::WarehouseObjectView->value => 'Просмотр объекта',
            self::WarehouseObjectViewAny->value => 'Просмотр всех объектов',
            self::WarehouseObjectViewTrash->value => 'Просмотр удалённых объектов',
            self::WarehouseObjectCreate->value => 'Создание объекта',
            self::WarehouseObjectEdit->value => 'Изменение объекта',
            self::WarehouseObjectDelete->value => 'Удаление объекта',
            self::WarehouseObjectDeleteForce->value => 'Полное удаление объекта',
            self::WarehouseObjectRestore->value => 'Восстановление объекта',

            self::WarehouseCellView->value => 'Просмотр ячейки',
            self::WarehouseCellViewAny->value => 'Просмотр всех ячеек',
            self::WarehouseCellViewTrash->value => 'Просмотр удалённых ячеек',
            self::WarehouseCellCreate->value => 'Создание ячейки',
            self::WarehouseCellEdit->value => 'Изменение ячейки',
            self::WarehouseCellDelete->value => 'Удаление ячейки',
            self::WarehouseCellDeleteForce->value => 'Полное удаление ячейки',
            self::WarehouseCellRestore->value => 'Восстановление ячейки',

            self::OrganizationView->value => 'Просмотр организации',
            self::OrganizationViewAny->value => 'Просмотр всех организаций',
            self::OrganizationViewTrash->value => 'Просмотр удалённых организаций',
            self::OrganizationCreate->value => 'Создание организации',
            self::OrganizationEdit->value => 'Изменение организации',
            self::OrganizationDelete->value => 'Удаление организации',
            self::OrganizationDeleteForce->value => 'Полное удаление организации',
            self::OrganizationRestore->value => 'Восстановление организации',

            self::ReportView->value => 'Просмотр отчёта',
            self::ReportViewAny->value => 'Просмотр всех отчётов',
            self::ReportViewTrash->value => 'Просмотр удалённых отчётов',
            self::ReportCreate->value => 'Создание отчёта',
            self::ReportEdit->value => 'Изменение отчёта',
            self::ReportDelete->value => 'Удаление отчёта',
            self::ReportDeleteForce->value => 'Полное удаление отчёта',
            self::ReportRestore->value => 'Восстановление отчёта',

            self::OrderView->value => 'Просмотр заказа',
            self::OrderViewAny->value => 'Просмотр всех заказов',
            self::OrderViewTrash->value => 'Просмотр удалённых заказов',
            self::OrderCreate->value => 'Создание заказа',
            self::OrderEdit->value => 'Изменение заказа',
            self::OrderDelete->value => 'Удаление заказа',
            self::OrderDeleteForce->value => 'Полное удаление заказа',
            self::OrderRestore->value => 'Восстановление заказа',

            self::PaymentView->value => 'Просмотр платежа',
            self::PaymentViewAny->value => 'Просмотр всех платежей',
            self::PaymentViewTrash->value => 'Просмотр удалённых платежей',
            self::PaymentCreate->value => 'Создание платежа',
            self::PaymentEdit->value => 'Изменение платежа',
            self::PaymentDelete->value => 'Удаление платежа',
            self::PaymentDeleteForce->value => 'Полное удаление платежа',
            self::PaymentRestore->value => 'Восстановление платежа',
        ];
    }

    public function label(): string
    {
        return self::forForm()[$this->value];
    }
}
