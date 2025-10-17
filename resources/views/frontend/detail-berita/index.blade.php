@extends('layouts.main_frontend')

@section('content')
    {{-- Detail Berita --}}
    <main class="container mx-auto px-4 py-10">
        <article class="max-w-4xl mx-auto">
            {{-- Judul & Meta --}}
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                {{ $berita->judul }}
            </h1>
            <div class="flex items-center space-x-4 text-gray-500 text-sm mb-6">
                <span>{{ $berita->created_at->format('d M Y') }}</span>
                <span>•</span>
                <span>Penulis: {{ $berita->penulis ?? 'Admin Kelurahan' }}</span>
            </div>

            {{-- Gambar Utama --}}
            @if ($berita->thumbnail)
                <img src="{{ asset($berita->thumbnail) }}" class="w-full h-full object-cover"
                    alt="[Gambar kegiatan rapat warga]">
            @else
                <span class="text-gray-400">-</span>
            @endif
            {{-- Isi Berita --}}
            <div class="prose lg:prose-lg max-w-none text-justify leading-relaxed">
                {!! $berita->deskripsi !!}
            </div>

            {{-- Navigasi Berita Lain --}}
            <div class="mt-12 border-t pt-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Berita Lainnya</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($beritaLain as $item)
                        <a href="{{ route('detail-berita', $item->id) }}"
                            class="block rounded-xl shadow hover:shadow-md transition bg-white overflow-hidden">
                            @if ($berita->thumbnail)
                                <img src="{{ asset($item->thumbnail) }}" class="w-full h-48 object-cover"
                                    alt="[Gambar kegiatan rapat warga]">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-800 line-clamp-2">{{ $item->judul }}</h4>
                                <p class="text-gray-500 text-sm mt-1">
                                    {{ $item->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </article>
    </main>
@endsection
