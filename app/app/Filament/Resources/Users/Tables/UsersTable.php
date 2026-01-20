<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Enums\UserStatusEnum;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;


class UsersTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('uuid')
                    ->label('UUID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable()
                    ->description(fn(User $record): string => $record->lastname ?? '')
                    ->weight('bold'),

                TextColumn::make('roles.name')
                    ->label('Роли')
                    ->badge()
                    ->formatStateUsing(fn($state) => UserRoleEnum::tryFrom($state)?->label() ?? $state)
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'danger' => UserRoleEnum::Superuser->value,
                        'warning' => UserRoleEnum::Developer->value,
                        'success' => UserRoleEnum::Admin->value,
                        'info' => UserRoleEnum::Moderator->value,
                        'primary' => fn($state): bool => in_array($state, [
                            UserRoleEnum::Partner->value,
                            UserRoleEnum::Steward->value,
                            UserRoleEnum::User->value,
                        ]),
                    ])
                    ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserRoleView->value)),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->copyMessage('Email скопирован'),

                IconColumn::make('email_verified_at')
                    ->label('E-mail подтвержден')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn($state): string => $state ? 'Email подтвержден' : 'Email не подтвержден')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->icon('heroicon-m-phone')
                    ->toggleable(),

                IconColumn::make('phone_verified_at')
                    ->label('Телефон подтвержден')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn($state): string => $state ? 'Телефон подтвержден' : 'Телефон не подтвержден')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('organization.name')
                    ->label('Организация')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Не привязан')
                    ->toggleable(),

                TextColumn::make('last_login_at')
                    ->label('Последний вход')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Обновлен')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(UserStatusEnum::class)
                    ->native(false),

                SelectFilter::make('organization')
                    ->label('Организация')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false),

                Filter::make('no_organization')
                    ->label('Без организации')
                    ->query(fn(Builder $query): Builder => $query->whereNull('organization_id')),

                SelectFilter::make('roles')
                    ->label('Роль')
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn(Role $record) => UserRoleEnum::tryFrom($record->name)?->label() ?? $record->name)
                    ->multiple()
                    ->preload()
                    ->native(false)
                    ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserRoleView->value)),

                Filter::make('email_verified')
                    ->label('Email подтвержден')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('email_verified_at')),

                Filter::make('email_not_verified')
                    ->label('Email не подтвержден')
                    ->query(fn(Builder $query): Builder => $query->whereNull('email_verified_at')),

                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('Создан с')
                            ->native(false),
                        DatePicker::make('created_until')
                            ->label('Создан до')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Нет пользователей')
            ->emptyStateIcon('heroicon-o-user');
    }
}
