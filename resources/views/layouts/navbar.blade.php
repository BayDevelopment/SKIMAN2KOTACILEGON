<nav
    class="fixed top-0 left-0 right-0 z-50 h-[52px]
            bg-white border-b border-gray-100
            flex items-center justify-between px-5">

    <!-- LEFT: Hamburger + Brand -->
    <div class="flex items-center gap-3">

        <!-- Hamburger -->
        <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- BRAND -->
        <div class="leading-tight">
            <p class="text-[14px] font-semibold text-gray-800 tracking-tight">
                E-Learning
            </p>
            <p class="text-[10px] text-gray-400">
                MAN 2 Kota Cilegon
            </p>
        </div>

    </div>

    {{-- RIGHT: Search + User --}}
    <div class="flex items-center gap-3">

        {{-- Search --}}
        <div class="hidden sm:flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 h-8 w-44">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
            </svg>
            <input type="text" placeholder="Cari materi..."
                class="bg-transparent text-xs text-gray-600 placeholder-gray-400 outline-none w-full">
        </div>

        {{-- User info --}}
        <div class="hidden sm:block text-right">
            <p class="text-xs font-medium text-gray-800 leading-tight">{{ auth()->user()->name ?? 'Ahmad Rizki' }}</p>
            <p class="text-[10px] text-gray-400">Student</p>
        </div>

        {{-- Avatar --}}
        <div
            class="w-8 h-8 rounded-full bg-blue-500 text-white
                    flex items-center justify-center text-xs font-medium flex-shrink-0">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>

    </div>

</nav>
