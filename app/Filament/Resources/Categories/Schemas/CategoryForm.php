<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Hamcrest\Core\Set;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Data utama kategori materi pembelajaran.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->placeholder('contoh: SKI, Fiqih, Aqidah')
                            ->helperText('Nama kategori yang akan ditampilkan ke siswa.')
                            ->required()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, Set $set) =>
                                $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('contoh: ski, fiqih')
                            ->helperText('Dibuat otomatis dari nama. Hanya huruf kecil, angka, dan tanda hubung.')
                            ->required()
                            ->unique(Category::class, 'slug', ignoreRecord: true)
                            ->maxLength(100)
                            ->rules(['alpha_dash'])
                            ->dehydrateStateUsing(fn($state) => Str::slug($state)),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Tuliskan deskripsi singkat kategori ini...')
                            ->helperText('Opsional. Maksimal 500 karakter.')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Tampilan')
                    ->description('Konfigurasi ikon dan warna untuk tampilan UI.')
                    ->schema([
                        TextInput::make('icon')
                            ->label('Icon')
                            ->placeholder('contoh: heroicon-o-book-open')
                            ->helperText('Nama icon Heroicons atau path gambar.')
                            ->maxLength(100),

                        ColorPicker::make('color')
                            ->label('Warna')
                            ->helperText('Warna tema kategori dalam format HEX. contoh: #4F46E5'),

                        TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->helperText('Angka lebih kecil tampil lebih dulu.')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(9999),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->helperText('Nonaktifkan untuk menyembunyikan kategori dari siswa.')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }
}
