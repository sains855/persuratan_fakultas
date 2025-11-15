@extends('layouts.main_frontend ')

@section('content')
    <main>
        <section id="hero" class="relative min-h-[90vh] flex items-center overflow-hidden">
            <div class="absolute inset-0 bg-black/50 z-10"></div>
            <div class="absolute inset-0">
                <img src="https://img.lovepik.com/photo/50108/6061.jpg_wh860.jpg" alt="Kantor Kelurahan Tipulu"
                    class="w-full h-full object-cover ken-burns">
            </div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
                <div class="max-w-3xl text-center mx-auto">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight animate-fade-in">
                        Selamat Datang di Portal Resmi Persuratan FMIPA UHO</h1>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($pelayanan as $item)
                        <div
                            class="bg-white border border-gray-200 p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col text-center">
                            <div
                                class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mb-6 text-3xl mx-auto">
                                <i class="{{ $item->icon }}"></i>
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-xl font-bold mb-3 text-gray-800">{{ $item->nama }}</h3>
                                <p class="text-gray-600 mb-6 text-base">{{ $item->deskripsi }}</p>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('pengajuan', $item->id) }}"
                                    class="font-semibold text-blue-600 hover:text-blue-800 transition-colors group inline-flex items-center justify-center">
                                    Ajukan Sekarang
                                    <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        </div>
        </section>

    </main>
@endsection

@push('scripts')
@endpush
