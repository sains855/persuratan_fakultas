<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Kelurahan Tipulu</title>
    <script src="/assets/js/tail.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
        <!-- 🧿 Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/APP%20LOGO.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/APP%20LOGO.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/APP%20LOGO.png') }}">
    <meta name="theme-color" content="#1e3a8a">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-content {
            display: none;
        }

        .dashboard-content.active {
            display: block;
        }

        .sidebar-link.active {
            background-color: #3b82f6;
            color: white;
        }

        /* Animasi Sidebar meluncur dari kiri */
        @keyframes slideInFromLeft {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .animate-slide-in-left {
            animation: slideInFromLeft 0.5s ease-out forwards;
        }

        /* Animasi Konten Utama meluncur dari atas dengan fade */
        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in-top {
            animation: slideInFromTop 0.6s ease-out forwards;
        }
        
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100">

    <div id="admin-dashboard">
        <div class="flex h-screen bg-gray-100">

            <!-- ===== Sidebar ===== -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            {{-- Mengubah margin kiri agar responsif. Tidak ada margin di mobile, ml-64 di desktop --}}
            <div class="w-full md:ml-64 flex-1 flex flex-col overflow-hidden animate-slide-in-top">

                <!-- ===== Header ===== -->
                @include('layouts.header')

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-6">
                    <!-- Konten dinamis akan dimuat di sini -->
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("sidebar-overlay");
        const hamburger = document.getElementById("hamburger");

        if (hamburger) {
            hamburger.addEventListener("click", () => {
                sidebar.classList.toggle("-translate-x-full");
                overlay.classList.toggle("hidden");
            });
        }

        if (overlay) {
            overlay.addEventListener("click", () => {
                sidebar.classList.add("-translate-x-full");
                overlay.classList.add("hidden");
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const closeModalBtn2 = document.getElementById('closeModalBtn2');

            if (modal && modalContent) {
                function openModal() {
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modalContent.classList.remove('scale-95', 'opacity-0');
                        modalContent.classList.add('scale-100', 'opacity-100');
                    }, 10);
                }

                function closeModal() {
                    modalContent.classList.remove('scale-100', 'opacity-100');
                    modalContent.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => modal.classList.add('hidden'), 200);
                }

                if (openModalBtn) openModalBtn.addEventListener('click', openModal);
                if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
                if (closeModalBtn2) closeModalBtn2.addEventListener('click', closeModal);

                // Optional: klik area di luar modalContent untuk menutup modal
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
            }
        });

        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'Asia/Makassar'
            };
            const timeEl = document.getElementById('current-time');
            if (timeEl) {
                timeEl.textContent = now.toLocaleDateString('id-ID', options) + ' WITA';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTime();
            setInterval(updateTime, 1000 * 60);
        });
    </script>
    @stack('scripts')
</body>

</html>
