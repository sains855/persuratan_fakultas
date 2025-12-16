@extends('layouts.main_frontend')

@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50 pt-6 pb-12">
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-2xl bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">
                    Edit Data Alumni
                </h2>

                {{-- Tampilkan Data Mahasiswa (untuk info) --}}
                <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-2">Data Mahasiswa:</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Nama:</span> {{ $mahasiswa->nama }}</p>
                        <p><span class="font-medium">NIM:</span> {{ $mahasiswa->nim }}</p>
                    </div>
                </div>

                {{-- Flash error & validation errors (Anda bisa copy dari detail.blade.php) --}}
                @if (session('error'))
                    <div class="auto-hide mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                        <button type="button" onclick="this.closest('.auto-hide').remove()"
                            class="ml-4 text-red-600">✕</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="font-medium text-red-600 mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengajuan.updateAlumni', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT') {{-- PENTING: Gunakan method PUT untuk update --}}
                    <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">
                    <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">

                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Form Edit Data Alumni</h3>

                        {{-- No Ijazah --}}
                        <div class="mb-4">
                            <label for="no_ijazah" class="block text-sm font-medium text-gray-600">Nomor Ijazah <span class="text-red-500">*</span></label>
                            <input type="text" name="no_ijazah" id="no_ijazah" value="{{ old('no_ijazah', $alumni->no_ijazah) }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_ijazah') border-red-500 @enderror"
                                placeholder="Masukkan Nomor Ijazah">
                            @error('no_ijazah')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tahun Studi Mulai --}}
                        <div class="mb-4">
                            <label for="tahun_studi_mulai" class="block text-sm font-medium text-gray-600">Tahun Studi Mulai <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_studi_mulai" id="tahun_studi_mulai"
                                value="{{ old('tahun_studi_mulai', $alumni->tahun_studi_mulai) }}" required
                                min="1900" max="{{ date('Y') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tahun_studi_mulai') border-red-500 @enderror"
                                placeholder="contoh: 2018">
                            @error('tahun_studi_mulai')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tahun Studi Selesai --}}
                        <div class="mb-4">
                            <label for="tahun_studi_selesai" class="block text-sm font-medium text-gray-600">Tahun Studi Selesai <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_studi_selesai" id="tahun_studi_selesai"
                                value="{{ old('tahun_studi_selesai', $alumni->tahun_studi_selesai) }}" required
                                min="1900" max="{{ date('Y') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tahun_studi_selesai') border-red-500 @enderror"
                                placeholder="contoh: 2022">
                            @error('tahun_studi_selesai')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Yudisium --}}
                        <div class="mb-4">
                            <label for="tgl_yudisium" class="block text-sm font-medium text-gray-600">Tanggal Yudisium <span class="text-red-500">*</span></label>
                            <input type="date" name="tgl_yudisium" id="tgl_yudisium"
                                value="{{ old('tgl_yudisium', $alumni->tgl_yudisium) }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tgl_yudisium') border-red-500 @enderror">
                            @error('tgl_yudisium')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-4 flex justify-between">
                        <a href="{{ route('pengajuan.detail', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                           Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
