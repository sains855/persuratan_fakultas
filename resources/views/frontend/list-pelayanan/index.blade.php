@extends('layouts.main_frontend')

@section('content')
<main class="container mx-auto px-4 py-16">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
            Semua Layanan Administrasi
        </h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Temukan dan ajukan berbagai layanan administrasi kependudukan yang kami sediakan untuk kemudahan Anda.
        </p>
    </div>

    {{-- Section Layanan Online --}}
    <h3 class="text-2xl font-bold mb-6 text-blue-700 text-center">Layanan Online</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @foreach ($pelayanan as $item)
            <div class="bg-white border border-gray-200 p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col text-center">
                <div class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mb-6 text-3xl mx-auto">
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
</main>
@endsection
