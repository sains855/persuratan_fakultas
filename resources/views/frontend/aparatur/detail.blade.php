@extends('layouts.main_frontend')

@section('content')
<!-- Hero Section -->
<section id="hero" class="relative bg-gradient-to-br from-blue-600 to-blue-800 text-white pt-32 pb-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Aparatur Kelurahan Tipulu</h1>
            <p class="text-xl md:text-2xl text-blue-100">Mengenal Lebih Dekat Tim Pelayan Masyarakat</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-16" viewBox="0 0 1440 54" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 22L60 26C120 30 240 38 360 38C480 38 600 30 720 26C840 22 960 22 1080 26C1200 30 1320 38 1380 42L1440 46V54H1380C1320 54 1200 54 1080 54C960 54 840 54 720 54C600 54 480 54 360 54C240 54 120 54 60 54H0V22Z" fill="#F9FAFB"/>
        </svg>
    </div>
</section>

<!-- Aparatur Section -->
<section id="aparatur" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistik -->
        <div class="mb-12 text-center">
            <div class="inline-block bg-blue-100 rounded-full px-6 py-2 mb-4">
                <span class="text-blue-800 font-semibold">Total: {{ $aparatur->count() }} Aparatur</span>
            </div>
        </div>

        <!-- Grid Aparatur -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($aparatur as $item)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <!-- Foto -->
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-100 to-blue-50 aspect-square">
                    @if($item->foto)
                    <img src="{{ asset($item->foto) }}"
                         alt="{{ $item->nama }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-32 h-32 text-blue-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="p-5">
                    <!-- Nama -->
                    <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">
                        {{ $item->nama }}
                    </h3>

                    <!-- Jabatan -->
                    <div class="flex items-start mb-3">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $item->jabatan }}</p>
                    </div>

                    <!-- NIP (jika ada) -->
                    @if($item->nip)
                    <div class="flex items-center pt-3 border-t border-gray-100">
                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        <span class="text-xs text-gray-500 font-mono">{{ $item->nip }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full">
                <div class="text-center py-16">
                    <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Data Aparatur</h3>
                    <p class="text-gray-500">Data aparatur akan ditampilkan di sini</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Kembali ke Beranda -->
        <div class="mt-12 text-center">
            <a href="{{ url('/#aparatur') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection
