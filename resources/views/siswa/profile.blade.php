@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PROFILE CARD -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                <!-- HEADER -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-500 p-6 text-center relative">

                    <!-- AVATAR -->
                    <div
                        class="mx-auto w-20 h-20 rounded-full bg-white text-blue-600 flex items-center justify-center text-2xl font-bold shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h2 class="mt-4 text-white font-semibold text-lg">
                        {{ $user->name }}
                    </h2>

                    <p class="text-white/80 text-sm">
                        {{ $user->email }}
                    </p>

                </div>

                <!-- INFO -->
                <div class="p-5 space-y-4 text-sm">

                    <div class="flex justify-between">
                        <span class="text-gray-400">NIS</span>
                        <span class="font-medium text-gray-700">{{ $user->nis ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-400">Kelas</span>
                        <span class="font-medium text-gray-700">{{ $user->kelas ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-400">Last Login</span>
                        <span class="font-medium text-gray-700">
                            {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d M Y H:i') : '-' }}
                        </span>
                    </div>

                </div>

            </div>
        </div>


        <!-- DETAIL CARD -->
        <div class="lg:col-span-2">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                <h3 class="text-sm font-semibold text-gray-700 mb-4">
                    Informasi Pengguna
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                    <div>
                        <label class="text-gray-400 text-xs">Nama Lengkap</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-700">
                            {{ $user->name }}
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-400 text-xs">Email</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-700">
                            {{ $user->email }}
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-400 text-xs">NIS</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-700">
                            {{ $user->nis ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-400 text-xs">Kelas</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-700">
                            {{ $user->kelas ?? '-' }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
