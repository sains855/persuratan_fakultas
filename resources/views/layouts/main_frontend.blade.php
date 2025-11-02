<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Administrasi Terpadu FMIPA</title>

    <meta name="google-site-verification" content="nQDPltT3lbevHFhYmcdR1_9crePvIG-lDKTJuNJElS8" />
    <script src="/assets/js/tail.js"></script>
    <script src="/assets/js/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

 <style>
        /* CSS untuk membuat navbar sticky/tetap saat scroll */
        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 80px;
        }
        main {
            flex: 1;
        }

        /* Tema Merah Maroon */
        .text-maroon-600 {
            color: #800000;
        }
        .hover\:text-maroon-600:hover {
            color: #800000;
        }
        .bg-maroon-600 {
            background-color: #800000;
        }
        .focus\:ring-maroon-500:focus {
            --tw-ring-color: #9d1b1b;
        }
        .hover\:bg-maroon-50:hover {
            background-color: #fef2f2;
        }
</style>

<body class="bg-gray-50 text-gray-800">

    @php
        // Kalau sedang di halaman utama "/"
        $isHome = request()->is('');
        $prefix = $isHome ? '' : url('/');
    @endphp

    <header id="navbar" class="sticky-nav bg-white 80 backdrop-blur-sm transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <a href="#" class="flex items-center space-x-3">
                        <img class="h-[65px] w-auto" src="/assets/img/untitled.png"
                            alt="Logo Kelurahan Tipulu">
                    </a>
                </div>
                <div class="hidden md:block">
                    <nav class="ml-10 flex items-baseline space-x-8">
                        <a href="{{ $prefix }}#hero"
                            class="text-gray-600 hover:text-maroon-600 font-medium">Beranda</a>
                        <a href="{{ $prefix }}#layanan"
                            class="text-gray-600 hover:text-maroon-600 font-medium">Layanan</a>
                        <a href="{{ $prefix }}#berita"
                            class="text-gray-600 hover:text-maroon-600 font-medium">Berita</a>
                        <a href="{{ $prefix }}#aparatur"
                            class="text-gray-600 hover:text-maroon-600 font-medium">Aparatur</a>
                        <a href="{{ $prefix }}#data-penduduk"
                            class="text-gray-600 hover:text-maroon-600 font-medium">Statistik</a  >
                        <a href="{{ $prefix }}#profil"
                            class="text-gray-600 hover:text-maroon-600 font-medium">Profil</a>
                        <a href="{{ $prefix }}#kontak"
                            class="text-gray-600 hover:text-maroon-600 font-medium">Kontak</a>
                    </nav>
                </div>
                <div class="flex items-center">
                    <button id="mobile-menu-button"
                        class="md:hidden ml-4 p-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-maroon-500">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ $prefix }}#hero"
                    class="text-gray-600 hover:bg-maroon-50 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                <a href="{{ $prefix }}#layanan"
                    class="text-gray-600 hover:bg-maroon-50 block px-3 py-2 rounded-md text-base font-medium">Layanan</a>
                <a href="{{ $prefix }}#berita"
                    class="text-gray-600 hover:bg-maroon-50 block px-3 py-2 rounded-md text-base font-medium">Berita</a>
                <a href="{{ $prefix }}#profil"
                    class="text-gray-600 hover:bg-maroon-50 block px-3 py-2 rounded-md text-base font-medium">Profil</a>
                <a href="{{ $prefix }}#data-penduduk"
                    class="text-gray-600 hover:bg-maroon-50 block px-3 py-2 rounded-md text-base font-medium">Statistik</a>
                <a href="{{ $prefix }}#kontak"
                    class="text-gray-600 hover:bg-maroon-50 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 mt-auto">
        <div class="text-center text-gray-400 text-sm">
            © <span id="year"></span> Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Halu Oleo. All Rights Reserved.
        </div>
    </footer>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>

    <script src="/assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto close mobile menu setelah link diklik
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuLinks = document.querySelectorAll('#mobile-menu a');

            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Tutup mobile menu
                    mobileMenu.classList.add('hidden');
                });
            });


            // Animasi scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, observerOptions);

            // Observe semua elemen dengan class fade-in-up
            document.querySelectorAll('.fade-in-up').forEach(el => {
                observer.observe(el);
            });

            // Update tahun di footer
            const yearEl = document.getElementById('year');
            if (yearEl) {
                yearEl.textContent = new Date().getFullYear();
            }
        });
    </script>
</body>
</html>
