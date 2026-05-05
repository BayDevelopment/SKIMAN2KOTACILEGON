<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi User')
                    ->description('Data utama pengguna.')
                    ->schema([

                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ahmad Rizki')
                            ->helperText('Nama akan ditampilkan di sistem.'),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Gunakan email aktif untuk login.'),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn($context) => $context === 'create')
                            ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn($state) => filled($state))
                            ->helperText('Kosongkan jika tidak ingin mengubah password.'),

                    ])
                    ->columnSpanFull(),

                Section::make('Data Siswa')
                    ->description('Isi jika user adalah siswa.')
                    ->schema([

                        TextInput::make('nis')
                            ->label('NIS')
                            ->unique(ignoreRecord: true)
                            ->placeholder('Nomor Induk Siswa')
                            ->helperText('Opsional. Harus unik jika diisi.'),

                        TextInput::make('kelas')
                            ->label('Kelas')
                            ->placeholder('Contoh: X IPA 1')
                            ->helperText('Kelas siswa saat ini.'),

                    ])
                    ->columnSpanFull(),


                Section::make('Pengaturan')
                    ->description('Atur role dan status user.')
                    ->schema([

                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'siswa' => 'Siswa',
                            ])
                            ->required()
                            ->default('siswa')
                            ->helperText('Admin memiliki akses penuh.'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk memblokir akses login.')
                            ->onColor('success')
                            ->offColor('danger'),

                    ])
                    ->columnSpanFull(),


                Section::make('Foto Profil')
                    ->description('Upload foto pengguna.')
                    ->schema([

                        FileUpload::make('avatar')
                            ->label('Avatar')
                            ->image()
                            ->directory('avatars')
                            ->maxSize(1024)
                            ->imagePreviewHeight('120')
                            ->helperText('Upload gambar (JPG/PNG, max 1MB). Opsional.'),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
