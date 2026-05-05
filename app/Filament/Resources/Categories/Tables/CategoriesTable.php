<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->toggleable(),

                ColorColumn::make('color')
                    ->label('Warna'),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),
            ])
            ->filters([
                TrashedFilter::make(),
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

                    // ✅ Restore
                    RestoreAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Pulihkan data?')
                        ->modalDescription('Data akan dikembalikan seperti semula.')
                        ->successNotification(
                            Notification::make()
                                ->title('Berhasil')
                                ->body('Data berhasil dipulihkan')
                                ->success()
                        ),

                    // ✅ Permanent delete
                    ForceDeleteAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus permanen?')
                        ->modalDescription('Data akan dihapus permanen dan tidak bisa dikembalikan!')
                        ->color('danger')
                        ->successNotification(
                            Notification::make()
                                ->title('Berhasil')
                                ->body('Data dihapus permanen')
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
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
