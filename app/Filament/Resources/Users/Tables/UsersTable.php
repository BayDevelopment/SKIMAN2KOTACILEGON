<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->circular()
                    ->defaultImageUrl(asset('images/empty_img.jpg')),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn($state) => $state === 'admin' ? 'danger' : 'info'),

                TextColumn::make('nis')
                    ->label('NIS')
                    ->toggleable()
                    ->placeholder('-'),

                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->toggleable()
                    ->placeholder('-'),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('last_login_at')
                    ->label('Login Terakhir')
                    ->since() // contoh: "2 jam lalu"
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),

                TextColumn::make('deleted_at')
                    ->label('Terhapus')
                    ->formatStateUsing(fn($state) => $state ? 'Terhapus' : null)
                    ->badge()
                    ->color('danger')
                    ->visible(fn($state) => filled($state)),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([

                    EditAction::make(),

                    // ✅ Soft Delete (masuk trash)
                    DeleteAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Pindahkan ke Trash?')
                        ->modalDescription('Data masih bisa dikembalikan nanti.')
                        ->successNotification(
                            Notification::make()
                                ->title('Berhasil')
                                ->body('Data dipindahkan ke trash')
                                ->success()
                        ),
                ])
                    ->label('Aksi')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->button()
                    ->outlined(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
