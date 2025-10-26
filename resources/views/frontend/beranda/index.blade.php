@extends('layouts.main_frontend ')

@section('content')
    <main>

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

    </main>
@endsection

@push('scripts')
@endpush
