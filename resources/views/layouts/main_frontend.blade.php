<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Resmi Kelurahan Tipulu</title>

    <meta name="google-site-verification" content="nQDPltT3lbevHFhYmcdR1_9crePvIG-lDKTJuNJElS8" />

    <!-- 🌍 SEO Meta Tags -->
    <meta name="description" content="Portal resmi Kelurahan Tipulu melalui program Meambo. Layanan administrasi publik seperti surat keterangan domisili, izin usaha mikro, dan surat pengantar RT/RW secara online.">
    <meta name="keywords" content="PTSP Kelurahan Tipulu, Meambo, Kelurahan Tipulu, layanan publik Kendari, pelayanan terpadu satu pintu, surat keterangan domisili, surat pengantar RT RW, izin usaha mikro, pelayanan online, pemerintah kota Kendari, kelurahan Tipulu Kendari">
    <meta name="author" content="Pemerintah Kelurahan Tipulu">
    <meta name="robots" content="index, follow">

    <!-- 🧿 Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/APP%20LOGO.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/APP%20LOGO.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/APP%20LOGO.png') }}">
    <meta name="theme-color" content="#1e3a8a">

    <!-- 🧩 Open Graph -->
    <meta property="og:title" content="Portal Resmi Kelurahan Tipulu | Meambo - Layanan Publik Online">
    <meta property="og:description" content="Pelayanan publik online Kelurahan Tipulu melalui program Meambo — cepat, mudah, dan transparan.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://meambo.id/">
    <meta property="og:image" content="{{ asset('assets/img/APP%20LOGO.png') }}">

    <!-- 🐦 Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Portal Resmi Kelurahan Tipulu | Meambo">
    <meta name="twitter:description" content="Akses layanan administrasi kelurahan secara online dengan cepat dan mudah.">
    <meta name="twitter:image" content="{{ asset('assets/img/APP%20LOGO.png') }}">

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
            padding-top: 80px; /* Tambahan padding agar konten tidak tertutup navbar */
        }
        main {
            flex: 1;
        }
</style>

<body class="bg-gray-50 text-gray-800">

    @php
        // Kalau sedang di halaman utama "/"
        $isHome = request()->is('');
        $prefix = $isHome ? '' : url('/');
    @endphp

    <header id="navbar" class="sticky-nav bg-white/80 backdrop-blur-sm transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <a href="#" class="flex items-center space-x-3">
                        <img class="h-[100px] w-auto" src="/assets/img/HEADER%20LOGO.png"
                            alt="Logo Kelurahan Tipulu">
                    </a>
                </div>
                <div class="hidden md:block">
                    <nav class="ml-10 flex items-baseline space-x-8">
                        <a href="{{ $prefix }}#hero"
                            class="text-gray-600 hover:text-blue-600 font-medium">Beranda</a>
                        <a href="{{ $prefix }}#layanan"
                            class="text-gray-600 hover:text-blue-600 font-medium">Layanan</a>
                        <a href="{{ $prefix }}#berita"
                            class="text-gray-600 hover:text-blue-600 font-medium">Berita</a>
                        <a href="{{ $prefix }}#aparatur"
                            class="text-gray-600 hover:text-blue-600 font-medium">Aparatur</a>
                        <a href="{{ $prefix }}#data-penduduk"
                            class="text-gray-600 hover:text-blue-600 font-medium">Statistik</a  >
                        <a href="{{ $prefix }}#profil"
                            class="text-gray-600 hover:text-blue-600 font-medium">Profil</a>
                        <a href="{{ $prefix }}#kontak"
                            class="text-gray-600 hover:text-blue-600 font-medium">Kontak</a>
                    </nav>
                </div>
                <div class="flex items-center">
                    <button id="mobile-menu-button"
                        class="md:hidden ml-4 p-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
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
                    class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                <a href="{{ $prefix }}#layanan"
                    class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Layanan</a>
                <a href="{{ $prefix }}#berita"
                    class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Berita</a>
                <a href="{{ $prefix }}#profil"
                    class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Profil</a>
                <a href="{{ $prefix }}#data-penduduk"
                    class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Statistik</a>
                <a href="{{ $prefix }}#kontak"
                    class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 mt-auto">
        <div class="text-center text-gray-400 text-sm">
            © <span id="year"></span> KKN-T UHO Tahun 2025 Kelurahan Tipulu || Pemerintah Kelurahan Tipulu. All Rights Reserved.
        </div>
    </footer>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>

    <div id="chat-widget" class="fixed bottom-6 right-6 z-50">
        <button id="chat-open-btn"
            class="bg-blue-600 text-white rounded-full p-4 shadow-lg hover:bg-blue-700 transition-transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-blue-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2.5 11.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm-5 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm-5 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" />
            </svg>
        </button>
    </div>
    <div id="chat-modal"
        class="hidden fixed bottom-6 right-6 sm:bottom-24 sm:right-6 w-[calc(100%-3rem)] sm:w-full sm:max-w-md h-[calc(100%-5rem)] sm:h-full sm:max-h-[70vh] bg-white rounded-2xl shadow-2xl z-50 flex flex-col transition-transform duration-300 transform translate-y-8 opacity-0">
        <div class="flex justify-between items-center p-4 bg-blue-600 text-white rounded-t-2xl flex-shrink-0">
            <h3 class="font-bold text-lg">Asisten Virtual Kelurahan</h3>
            <button id="chat-close-btn" class="p-1 rounded-full hover:bg-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-4">
        </div>
        <div class="p-4 border-t border-gray-200 bg-white rounded-b-2xl flex-shrink-0">
            <div class="flex items-center space-x-2">
                <input type="text" id="chat-input" placeholder="Tanyakan sesuatu..."
                    class="flex-1 w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500">
                <button id="chat-send-btn"
                    class="bg-blue-600 text-white rounded-full p-3 hover:bg-blue-700 transition-colors disabled:bg-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

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

            // Animasi counter untuk statistik penduduk
            function animateCounter(element) {
                if (!element) return;

                const target = parseInt(element.getAttribute('data-target'));
                const duration = 2000; // 2 detik
                const step = target / (duration / 16); // 60fps
                let current = 0;

                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        element.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current).toLocaleString();
                    }
                }, 16);
            }

            // Jalankan animasi counter
            const totalPendudukEl = document.getElementById('total-penduduk');
            const lakiLakiEl = document.getElementById('laki-laki');
            const perempuanEl = document.getElementById('perempuan');

            if (totalPendudukEl) animateCounter(totalPendudukEl);
            if (lakiLakiEl) animateCounter(lakiLakiEl);
            if (perempuanEl) animateCounter(perempuanEl);

            // Data untuk Komposisi Jenis Kelamin
            const genderChartEl = document.getElementById('genderChart');

            if (genderChartEl) {
                const genderData = {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        label: 'Jumlah Jiwa',
                        data: [{{ $totalLakiLaki ?? 30 }}, {{ $totalPerempuan ?? 25 }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(236, 72, 153, 0.8)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(236, 72, 153, 1)'
                        ],
                        borderWidth: 1
                    }]
                };

                const genderConfig = {
                    type: 'doughnut',
                    data: genderData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString() +
                                            ' jiwa';
                                    }
                                }
                            }
                        }
                    }
                };

                // Inisialisasi grafik
                const genderChart = new Chart(genderChartEl, genderConfig);
            }

            // Carousel untuk berita
            const carouselInner = document.getElementById('carousel-inner');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            if (carouselInner && prevBtn && nextBtn) {
                let currentIndex = 0;
                const items = document.querySelectorAll('#carousel-inner > div');
                const totalItems = items.length;

                function updateCarousel() {
                    const itemWidth = items[0].offsetWidth;
                    carouselInner.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
                }

                nextBtn.addEventListener('click', () => {
                    if (currentIndex < totalItems - 1) {
                        currentIndex++;
                        updateCarousel();
                    }
                });

                prevBtn.addEventListener('click', () => {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateCarousel();
                    }
                });

                window.addEventListener('resize', updateCarousel);
            }

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
