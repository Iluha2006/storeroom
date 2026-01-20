<?php

namespace App\Filament\Resources\Organizations\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;
use App\Enums\UserStatusEnum;


class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Пользователи организации';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can(UserPermissionEnum::UserView->value);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
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

                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->icon('heroicon-m-phone')
                    ->placeholder('—'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->copyMessage('Email скопирован'),

                TextColumn::make('roles.name')
                    ->label('Роли')
                    ->badge()
                    ->formatStateUsing(fn($state) => UserRoleEnum::tryFrom($state)?->label() ?? $state),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(UserStatusEnum::class)
                    ->native(false),

                Filter::make('email_verified')
                    ->label('Email подтвержден')
                    ->query(fn($query) => $query->whereNotNull('email_verified_at')),

                Filter::make('phone_verified')
                    ->label('Телефон подтвержден')
                    ->query(fn($query) => $query->whereNotNull('phone_verified_at')),

                TrashedFilter::make(),
            ])
            ->headerActions([
                Action::make('attachExisting')
                    ->label('Прикрепить существующего')
                    ->icon('heroicon-o-link')
                    ->schema([
                        Select::make('user_id')
                            ->label('Пользователь')
                            ->options(User::whereNull('organization_id')
                                ->orWhere('organization_id', $this->getOwnerRecord()->id)
                                ->get()
                                ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->helperText('Доступны только пользователи без организации'),
                    ])
                    ->action(function (array $data) {
                        User::find($data['user_id'])->update([
                            'organization_id' => $this->getOwnerRecord()->id,
                        ]);
                    })
                    ->successNotificationTitle('Пользователь прикреплен к организации')
                    ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserEdit->value)),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->url(fn(User $record): string => route('filament.admin.resources.users.view', $record))
                        ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserView->value)),
                    EditAction::make()
                        ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserEdit->value)),
                    Action::make('detach')
                        ->label('Открепить')
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Открепить пользователя')
                        ->modalDescription('Вы уверены, что хотите открепить пользователя от организации?')
                        ->action(fn(User $record) => $record->update(['organization_id' => null]))
                        ->successNotificationTitle('Пользователь откреплен')
                        ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserEdit->value)),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('detach')
                        ->label('Открепить выбранных')
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(fn($record) => $record->update(['organization_id' => null]));
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('Пользователи откреплены')
                        ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserEdit->value)),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]))
            ->emptyStateHeading('Нет пользователей')
            ->emptyStateDescription('Создайте нового пользователя или прикрепите существующего')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
