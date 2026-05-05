<?php

namespace App\Filament\Resources\Materials\Schemas;

use App\Models\Category;
use App\Models\Material;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Informasi Materi')
                ->description('Data utama konten pembelajaran.')
                ->schema([

                    Hidden::make('created_by')
                        ->default(Auth::id()),
                    Select::make('category_id')
                        ->label('Kategori')
                        ->helperText('Pilih kategori yang sesuai.')
                        ->options(Category::active()->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('title')
                        ->label('Judul Materi')
                        ->placeholder('contoh: Turunnya Nabi Muhammad SAW')
                        ->helperText('Judul yang ditampilkan ke siswa.')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, Set $set) {
                            $set('slug', Str::slug($state));
                        })
                        ->columnSpanFull(),

                    TextInput::make('slug')
                        ->label('Slug')
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(Material::class, 'slug', ignoreRecord: true)
                        ->maxLength(255)
                        ->dehydrateStateUsing(fn($state, $get) => Str::slug($state ?: $get('title')))
                        ->columnSpanFull(),

                    Select::make('status')                          // ✅ tidak ketinggalan
                        ->label('Status')
                        ->helperText('Draft = tidak terlihat siswa. Published = aktif.')
                        ->options(['draft' => 'Draft', 'published' => 'Published'])
                        ->default('draft')
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('order')
                        ->label('Urutan')
                        ->helperText('Angka kecil tampil lebih dulu dalam kategori.')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->columnSpanFull(),

                    FileUpload::make('thumbnail')
                        ->label('Gambar Cover')
                        ->helperText('Format JPG/PNG, maks 2MB. Rasio ideal 16:9.')
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->maxSize(2048)
                        ->disk('public')
                        ->directory('storage/thumbnails') // 🔥 WAJIB untuk shared hosting
                        ->visibility('public')
                        ->nullable()
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),

            Section::make('Konten Materi')
                ->schema([
                    RichEditor::make('content')
                        ->label('Isi Materi')
                        ->helperText('Tulis isi materi lengkap. Mendukung format teks kaya.')
                        ->required()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'bulletList',
                            'orderedList',
                            'blockquote',
                            'h2',
                            'h3',
                            'link',
                            'undo',
                            'redo',
                        ])
                        ->columnSpanFull(),

                    Repeater::make('videos')
                        ->label('Video Pembelajaran')
                        ->helperText('Opsional. Bisa ditambahkan sekarang atau diedit nanti.')
                        ->relationship('videos')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Video')
                                ->placeholder('contoh: Pengantar Materi SKI')
                                ->helperText('Judul singkat video.')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),

                            TextInput::make('youtube_url')
                                ->label('Link YouTube')
                                ->placeholder('https://youtu.be/dQw4w9WgXcQ')
                                ->helperText('Link YouTube — ID video diekstrak otomatis oleh sistem.')
                                ->required()
                                ->url()
                                ->maxLength(255)
                                ->rules([
                                    fn() => function (string $attribute, $value, $fail) {
                                        preg_match(
                                            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                                            $value,
                                            $matches
                                        );
                                        if (empty($matches[1])) {
                                            $fail('Harus berupa URL YouTube yang valid.');
                                        }
                                    }
                                ])
                                ->columnSpanFull(),

                            Textarea::make('description')
                                ->label('Deskripsi Video')
                                ->helperText('Opsional. Ringkasan isi video.')
                                ->rows(2)
                                ->maxLength(500)
                                ->nullable()
                                ->columnSpanFull(),

                            TextInput::make('order')
                                ->label('Urutan Video')
                                ->helperText('Urutan video dalam materi ini.')
                                ->numeric()
                                ->default(0)
                                ->minValue(0)
                                ->columnSpanFull(),
                        ])
                        ->addActionLabel('+ Tambah Video')
                        ->reorderable('order')
                        ->collapsible()
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),

        ]);
    }
}
