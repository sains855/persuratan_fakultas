@extends('layouts.main_frontend')
@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50">
        {{-- Konten utama (form di tengah layar) --}}
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">Form Cek NIM</h2>

                {{-- Flash success --}}
                @if (session('success'))
                    <div class="auto-hide mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                        <button type="button" onclick="this.closest('.auto-hide').remove()"
                            class="ml-4 text-green-700">✕</button>
                    </div>
                @endif

                {{-- Flash error --}}
                @if (session('error'))
                    <div class="auto-hide mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                        <button type="button" onclick="this.closest('.auto-hide').remove()"
                            class="ml-4 text-red-600">✕</button>
                    </div>
                @endif

                {{-- Informasi Pelayanan --}}
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <span class="font-semibold">Jenis Pelayanan:</span><br>
                        {{ $pelayanan->nama }}
                    </p>
                </div>

                <form action="{{ route('pengajuan.cek', $id) }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-600">
                            Nomor Induk Mahasiswa (NIM)
                        </label>
                        <input type="text" name="nim" id="nim"
                            class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nim') border-red-500 @enderror"
                            placeholder="Masukkan NIM Anda"
                            value="{{ old('nim') }}"
                            required>
                        @error('nim')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition">
                        Cek NIM
                    </button>

                    <a href="{{ route('beranda') }}"
                        class="block w-full text-center bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition">
                        Kembali
                    </a>
                </form>
            </div>
        </main>
    </div>

    {{-- Auto-hide flash messages after 5 seconds --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const autoHideElements = document.querySelectorAll('.auto-hide');
            autoHideElements.forEach(element => {
                setTimeout(() => {
                    element.style.transition = 'opacity 0.5s';
                    element.style.opacity = '0';
                    setTimeout(() => element.remove(), 500);
                }, 5000);
            });
        });
    </script>
@endsection
