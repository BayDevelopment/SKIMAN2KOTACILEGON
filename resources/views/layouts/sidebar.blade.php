<aside id="sidebar"
    class="fixed top-[52px] left-0 z-40
           w-[220px] h-[calc(100vh-52px)]
           bg-slate-900 text-white flex flex-col
           transition-all duration-300 ease-in-out
           -translate-x-full md:translate-x-0">

    <div class="flex-1 px-3 py-4 overflow-y-auto overflow-x-hidden">
        <p class="text-[9px] font-medium uppercase text-white/50 px-3 mb-2 hide-on-collapse">Menu</p>

        <nav class="space-y-1">
            <a href="{{ route('siswa.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition group
    {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-600 text-white' : 'text-white/50 hover:bg-white/10' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="hide-on-collapse">Dashboard</span>
            </a>
            <a href="{{ route('siswa.kategori') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition group
    {{ request()->routeIs('siswa.kategori') ? 'bg-blue-600 text-white' : 'text-white/50 hover:bg-white/10' }}">
                <!-- KATEGORI -->
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
                <span class="hide-on-collapse">Kategori</span>
            </a>
            <a href="{{ route('siswa.profile') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition group
    {{ request()->routeIs('siswa.profile') ? 'bg-blue-600 text-white' : 'text-white/50 hover:bg-white/10' }}">
                <!-- KATEGORI -->
                <!-- PROFILE -->
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM12 14c-4.42 0-8 2.69-8 6h16c0-3.31-3.58-6-8-6z" />
                </svg>
                <span class="hide-on-collapse">Profile</span>
            </a>

            {{-- Tambahkan class hide-on-collapse pada semua teks menu --}}
        </nav>
    </div>

    <div class="p-4 ">

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] text-red-400 hover:bg-red-600 hover:text-white transition group">

                {{-- ICON LOGOUT --}}
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V7m-6 12h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v3" />
                </svg>

                <span class="hide-on-collapse">Logout</span>
            </button>
        </form>

    </div>
    {{-- User Footer --}}
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3">
            <div
                class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0 hide-on-collapse">
                <p class="text-xs font-medium truncate">{{ auth()->user()->name ?? 'Ahmad Rizki' }}</p>
                <p class="text-[10px] text-white/40">Student</p>
            </div>
        </div>
    </div>
</aside>
@push('script')
    <script>
        document.querySelector('form[action="{{ route('logout') }}"]').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Logout?',
                text: 'Kamu akan keluar dari akun',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    </script>
@endpush
