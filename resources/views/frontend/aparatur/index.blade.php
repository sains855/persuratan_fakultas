@extends('layouts.main_frontend')

@section('content')
<main class="container mx-auto px-4 py-16">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
            Semua Aparatur Kelurahan Tipulu
        </h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Mengenal lebih dekat para aparatur yang berperan penting dalam pelayanan masyarakat di Kelurahan Tipulu.
        </p>
    </div>

    {{-- Grid Aparatur --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        @foreach ($aparatur as $item)
            <div class="bg-white shadow-md rounded-2xl p-6 text-center hover:shadow-lg transition-transform duration-300 hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    @if ($item->foto && file_exists(public_path($item->foto)))
                        <img src="{{ asset($item->foto) }}"
                            alt="{{ $item->nama }}"
                            class="w-24 h-24 rounded-full object-cover border border-gray-300">
                    @else
                        <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-4xl">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif

                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $item->nama }}</h3>
                <p class="text-gray-600 text-sm mb-1">NIP : {{ $item->nip }}</p>
                <p class="text-blue-600 font-semibold">{{ $item->jabatan }}</p>
            </div>
        @endforeach
    </div>
</main>
@endsection
