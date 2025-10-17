@extends('layouts.main_frontend ', ['landingPage' => $landingPage])

@section('content')
    <main>
        <section id="hero" class="relative min-h-[90vh] flex items-center overflow-hidden">
            <div class="absolute inset-0 bg-black/50 z-10"></div>
                <div class="absolute inset-0">
                   <img src="{{ $landingPage && $landingPage->gambar_utama 
                    ? asset('storage/' . $landingPage->gambar_utama) 
                    : asset('https://img.lovepik.com/photo/50108/6061.jpg_wh860.jpg') }}" 
                    alt="Gambar Utama" 
                    class="w-full h-full object-cover">
                </div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
                <div class="max-w-3xl text-center mx-auto">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight animate-fade-in">
                        Selamat Datang di Portal Resmi {{ $landingPage->nama_instansi ?? '-' }}</h1>
                    <p class="mt-6 text-lg md:text-xl text-gray-200 animate-fade-in-delay">
                        {{ $landingPage->slogan ?? '-' }}</p>
                    <div class="mt-10 flex flex-col sm:flex-row justify-center items-center gap-4 animate-fade-in-up-delay">
                        <a href="#layanan"
                            class="bg-yellow-500 text-gray-900 font-bold py-3 px-8 rounded-lg text-lg hover:bg-yellow-400 transition-transform hover:scale-105 w-full sm:w-auto">Lihat
                            Layanan Kami</a>
                        <a href="#"
                            class="bg-white/20 backdrop-blur-sm text-white font-medium py-3 px-8 rounded-lg text-lg hover:bg-white/30 transition-transform hover:scale-105 w-full sm:w-auto">Cara
                            Penggunaan Sistem</a>
                    </div>
                </div>
            </div>
        </section>

            <section id="layanan" class="py-20 bg-white">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 fade-in-up">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Layanan Administrasi Terpadu</h2>
                        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Akses layanan administrasi kependudukan
                            dengan mudah dan cepat langsung dari genggaman Anda.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($pelayanan as $item)
                            <div
                                class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-2 transition-all duration-300 fade-in-up flex flex-col text-center h-full">
                                <div class="flex-grow">
                                    <div
                                        class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mb-6 text-3xl mx-auto">
                                        <i class="{{ $item->icon }}"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold mb-3">{{ $item->nama }}</h3>
                                    <p class="text-gray-600">{{ $item->deskripsi }}</p>
                                </div>
                                <div class="mt-auto pt-6">
                                    <a href="{{ route('pengajuan', $item->id) }}"
                                        class="font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                        Ajukan Sekarang
                                        <i class="fas fa-arrow-right ml-1"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-center mt-12 fade-in-up">
                    <a href="{{ route('list-pelayanan') }}"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors text-lg">Lihat
                        Semua Layanan</a>
                </div>
            </section>
            </div>
        </section>

        <section id="berita" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Berita & Informasi Terkini</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Ikuti perkembangan dan pengumuman terbaru
                        dari Kelurahan Tipulu.</p>
                </div>
                <div class="relative fade-in-up">
                    <div id="carousel-wrapper" class="overflow-hidden">
                        <div id="carousel-inner" class="flex transition-transform duration-500 ease-in-out">
                            @foreach ($berita as $item)
                                <div class="flex-shrink-0 w-full md:w-1/2 lg:w-1/3 p-4">
                                    <a href="{{ route('detail-berita', $item->id) }}">
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden h-full">
                                            @if ($item->thumbnail)
                                                <img src="{{ asset($item->thumbnail) }}" class="w-full h-48 object-cover"
                                                    alt="[Gambar kegiatan rapat warga]">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                            <div class="p-6">
                                                <h3 class="text-xl font-bold mb-3 hover:text-blue-700">
                                                    {{ $item->judul ?? '-' }}
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $item->tgl_posting ? \Carbon\Carbon::parse($item->tgl_posting)->format('d-m-Y') : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button id="prev-btn"
                        class="absolute top-1/2 left-0 -translate-y-1/2 bg-white/70 p-2 rounded-full shadow-md hover:bg-white transition">
                        <svg class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="next-btn"
                        class="absolute top-1/2 right-0 -translate-y-1/2 bg-white/70 p-2 rounded-full shadow-md hover:bg-white transition">
                        <svg class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <section id="aparatur" class="py-20 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aparatur Kelurahan Tipulu</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Mengenal lebih dekat para aparatur yang
                        berdedikasi melayani masyarakat.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($aparatur as $index => $item)
                        <div
                            class="text-center bg-gray-100 p-8 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-2 transition-all duration-300 fade-in-up
                            {{ $index > 1 ? 'hidden sm:block' : '' }}">
                            @if ($item->foto)
                                <img src="{{ asset($item->foto) }}"
                                    class="w-32 h-32 rounded-full mx-auto mb-4 object-cover" alt="[Foto Aparatur]">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                            <h3 class="text-xl font-bold">{{ $item->nama }}</h3>
                            <p class="text-gray-600 mt-2 font-semibold">NIP : {{ $item->nip }}</p>
                            <p class="text-blue-600 font-semibold">{{ $item->jabatan }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-12 fade-in-up">

                <a href="{{ route('detail-aparatur') }}"
                        class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors text-lg">Lihat
                        Semua Aparatur</a>
                </div>

            </div>
        </section>

        <section id="data-penduduk" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Sekilas Data Kependudukan Kelurahan Tipulu
                    </h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Data demografi terbaru sebagai bentuk
                        transparansi informasi publik.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="grid grid-cols-2 gap-6 fade-in-up">
                        <div class="bg-blue-50 p-6 rounded-lg text-center col-span-2">
                            <p class="text-lg text-blue-800 font-medium">Total Penduduk</p>
                            <p id="total-penduduk" class="text-4xl font-bold text-blue-600 mt-2" data-target="{{ $totalPenduduk }}">0
                            </p>
                            <p class="text-sm text-blue-700">Jiwa</p>
                        </div>
                    </div>
                    <!-- Grafik komposisi jenis kelamin - ELEMEN BARU -->
                    <div class="bg-white p-6 rounded-xl shadow-sm fade-in-up">
                        <h3 class="text-xl font-bold mb-4 text-center text-gray-800">Komposisi Jenis Kelamin</h3>
                        <div class="h-64">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="profil" class="py-20 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Profil Kelurahan</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        Pelajari lebih dalam tentang sejarah, visi, dan misi Kelurahan Tipulu untuk membangun lingkungan yang lebih maju dan harmonis.
                    </p>
                </div>

                <!-- Gunakan flex agar tinggi kiri & kanan sejajar -->
                <div class="flex flex-col lg:flex-row gap-8 items-stretch">

                    <!-- Kolom kiri -->
                    <div class="flex flex-col justify-between w-full lg:w-1/2 space-y-8">
                        <!-- Card Sejarah -->
                        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition duration-300 ease-in-out flex-1 text-center">
                            <h3 class="text-2xl font-bold mb-4 text-gray-900">Sejarah Singkat</h3>
                            <p class="text-gray-600 mb-6">
                                {{ Str::limit(html_entity_decode(strip_tags($landingPage->deskripsi ?? '')), 150, '...') }}
                                
                            </p>
                            <a href="{{ route('sejarah') }}"
                            class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-green-700 transition">
                            Lihat Selengkapnya →
                        </a>
                    </div>
                    
                    <!-- Card Visi Misi -->
                    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition duration-300 ease-in-out flex-1 text-center">
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Visi & Misi</h3>
                            <p class="text-gray-600 mb-6">
                                {{ Str::limit(html_entity_decode(strip_tags($landingPage->visi ?? '')), 150, '...') }}
                            </p>
                            <a href="{{ route('visimisi') }}"
                            class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-green-700 transition">
                                Lihat Selengkapnya →
                            </a>
                        </div>
                    </div>

                  <!-- Kolom kanan (maps) -->
                    <div class="w-full lg:w-1/2 rounded-2xl overflow-hidden shadow-lg">
                        <iframe
                            src="https://www.google.com/maps?q={{ urlencode($landingPage->koordinat ?? '-3.9639639,122.5485688') }}&hl=id&z=15&output=embed"
                            width="100%"
                            height="100%"
                            class="min-h-[520px] h-full"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="py-20 bg-blue-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Butuh Bantuan?</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Kami siap membantu Anda. Hubungi kami
                        melalui kontak di bawah ini atau kunjungi kantor kami pada jam pelayanan.</p>
                </div>
                <div
                    class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md grid grid-cols-1 md:grid-cols-2 gap-8 fade-in-up">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Informasi Kontak</h3>
                        <ul class="space-y-4 text-gray-700">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>{{ $landingPage->alamat ?? '-' }}</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <a href="tel:+62-XXX-XXXX-XXXX"
                                    class="hover:text-blue-600">{{ $landingPage->telpon ?? '-' }}</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:info@kelurahantipulu.go.id"
                                    class="hover:text-blue-600">{{ $landingPage->email ?? '-' }}</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Waktu Pelayanan</h3>
                        <p>{!! $landingPage->waktu_pelayanan ?? '07:00 - 15:00 WITA' !!}</p>
                        <div class="mt-6">
                            <a href="#"
                                class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Unduh Panduan Sistem
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
@endpush
