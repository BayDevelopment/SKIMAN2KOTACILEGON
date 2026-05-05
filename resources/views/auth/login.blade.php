<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Login - E-Learning' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex bg-slate-100">

    <!-- LEFT (branding) -->
    <div class="hidden md:flex w-1/2 bg-slate-900 text-white p-10 flex-col justify-between">

        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                E-Learning System
            </h1>
            <p class="text-slate-400 mt-2 text-sm">
                Platform pembelajaran digital modern
            </p>
        </div>

        <div>
            <h2 class="text-3xl font-semibold leading-snug">
                Belajar lebih mudah, fleksibel, dan terstruktur.
            </h2>
        </div>

        <p class="text-sm text-slate-500">
            © 2026 MAN 2 Kota Cilegon
        </p>

    </div>


    <!-- RIGHT (form) -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-6">

        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

                <!-- Title -->
                <div class="mb-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-900">
                        Masuk ke akun
                    </h2>
                    <p class="text-sm text-gray-400 mt-1">
                        Silakan login untuk melanjutkan
                    </p>
                </div>

                <!-- FORM -->
                <form method="POST" action="/login" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="text-sm text-gray-600">Email</label>

                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full mt-1 px-4 py-2.5 rounded-xl border 
            {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-slate-900' }}
            focus:outline-none focus:ring-2"
                            placeholder="email@example.com">

                        @error('email')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="text-sm text-gray-600">Password</label>

                        <input type="password" name="password"
                            class="w-full mt-1 px-4 py-2.5 rounded-xl border 
            {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-slate-900' }}
            focus:outline-none focus:ring-2"
                            placeholder="••••••••">

                        @error('password')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-gray-500">
                            <input type="checkbox" name="remember" class="rounded">
                            Ingat saya
                        </label>

                        <a href="#" class="text-slate-700 hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-slate-900 text-white py-2.5 rounded-xl 
               hover:bg-slate-800 transition font-medium">
                        Login
                    </button>
                </form>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#16a34a'
            });
        </script>
    @endif
</body>

</html>
