<header class="bg-white shadow p-2 md:p-4 flex justify-between items-center">
    <!-- Tombol Hamburger (hanya tampil di mobile) -->
    <button id="hamburger" class="md:hidden text-gray-700 focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <!-- Judul halaman -->
    <h1 id="page-title" class="text-lg md:text-xl font-semibold text-gray-800 truncate">
        {{ $title }}
    </h1>

    <!-- Info user (disembunyikan di mobile) -->
    <div class="hidden md:block text-right">
        <p class="font-semibold">Selamat Datang, {{ auth()->user()->username ?? 'Admin' }}!</p>
        <p id="current-time" class="text-sm text-gray-500"></p>
    </div>

</header>
