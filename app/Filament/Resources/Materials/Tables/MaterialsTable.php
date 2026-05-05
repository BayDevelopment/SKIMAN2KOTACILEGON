<?php

namespace App\Filament\Resources\Materials\Tables;

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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->square()
                    ->defaultImageUrl(asset('images/default-material.png')),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state === 'published' ? 'Publish' : 'Draft')
                    ->color(fn($state) => $state === 'published' ? 'success' : 'gray'),

                TextColumn::make('view_count')
                    ->label('Dilihat')
                    ->sortable(),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),

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
