<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard E-Learning' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-blue-600/10 via-white to-blue-600/5 text-gray-800 antialiased">

    @include('layouts.navbar')

    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 hidden z-40 md:hidden"></div>

    <div class="flex min-h-screen pt-[52px]">
        @include('layouts.sidebar')

        <main id="mainContent" class="flex-1 md:ml-[220px] transition-all duration-300 p-6">
            <div class="max-w-7xl mx-auto space-y-5">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- STACK SCRIPT --}}
    @stack('script')

    {{-- LIBRARY --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SIDEBAR SCRIPT --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const main = document.getElementById('mainContent');

        function toggleSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            } else {
                sidebar.classList.toggle('sidebar-collapsed');

                main.classList.toggle('md:ml-[220px]');
                main.classList.toggle('md:ml-[70px]');
            }
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                overlay.classList.add('hidden');
                if (!sidebar.classList.contains('sidebar-collapsed')) {
                    main.classList.add('md:ml-[220px]');
                    main.classList.remove('md:ml-[70px]');
                }
            } else {
                main.classList.remove('md:ml-[220px]', 'md:ml-[70px]');
            }
        });
    </script>

    {{-- SWEET ALERT GLOBAL --}}
    @if (session('success') || session('error') || session('warning') || session('info'))
        <script>
            const alertData = {
                success: {
                    icon: 'success',
                    title: 'Berhasil',
                    color: '#16a34a'
                },
                error: {
                    icon: 'error',
                    title: 'Gagal',
                    color: '#dc2626'
                },
                warning: {
                    icon: 'warning',
                    title: 'Peringatan',
                    color: '#f59e0b'
                },
                info: {
                    icon: 'info',
                    title: 'Informasi',
                    color: '#2563eb'
                }
            };

            @foreach (['success', 'error', 'warning', 'info'] as $type)
                @if (session($type))
                    Swal.fire({
                        icon: alertData['{{ $type }}'].icon,
                        title: alertData['{{ $type }}'].title,
                        text: '{{ session($type) }}',
                        confirmButtonColor: alertData['{{ $type }}'].color
                    });
                @endif
            @endforeach
        </script>
    @endif

</body>

</html>
