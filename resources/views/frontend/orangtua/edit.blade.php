@extends('layouts.main_frontend')

@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50 pt-6 pb-12">
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-2xl bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">
                    Edit Data Orang Tua
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

                <form action="{{ route('pengajuan.updateOrangTua', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT') {{-- PENTING: Gunakan method PUT untuk update --}}
                    <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">
                    <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">

                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Form Edit Data Orang Tua</h3>

                        {{-- Nama Orang Tua --}}
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-600">Nama Orang Tua <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $orangTua->nama) }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                placeholder="Masukkan Nama Orang Tua">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- pekerjaaan --}}
                        <div class="mb-4">
                            <label for="pekerjaaan" class="block text-sm font-medium text-gray-600">Pekerjaan <span class="text-red-500">*</span></label>
                            <input type="text" name="pekerjaaan" id="pekerjaaan" value="{{ old('pekerjaaan', $orangTua->pekerjaaan) }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('pekerjaaan') border-red-500 @enderror"
                                placeholder="Masukkan Pekerjaan">
                            @error('pekerjaaan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NIP/No. Pensiun/NRP --}}
                        <div class="mb-4">
                            <label for="NIP_NOPensiun_NRP" class="block text-sm font-medium text-gray-600">NIP/No. Pensiun/NRP</label>
                            <input type="text" name="NIP_NOPensiun_NRP" id="NIP_NOPensiun_NRP" value="{{ old('NIP_NOPensiun_NRP', $orangTua->NIP_NOPensiun_NRP) }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('NIP_NOPensiun_NRP') border-red-500 @enderror"
                                placeholder="Masukkan NIP/No. Pensiun/NRP (jika ada)">
                            @error('NIP_NOPensiun_NRP')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pangkat --}}
                        <div class="mb-4">
                            <label for="pangkat" class="block text-sm font-medium text-gray-600">Pangkat</label>
                            <input type="text" name="pangkat" id="pangkat" value="{{ old('pangkat', $orangTua->pangkat) }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('pangkat') border-red-500 @enderror"
                                placeholder="Masukkan Pangkat (jika ada)">
                            @error('pangkat')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Instansi --}}
                        <div class="mb-4">
                            <label for="instansi" class="block text-sm font-medium text-gray-600">Instansi</label>
                            <input type="text" name="instansi" id="instansi" value="{{ old('instansi', $orangTua->instansi) }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('instansi') border-red-500 @enderror"
                                placeholder="Masukkan Instansi (jika ada)">
                            @error('instansi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-4">
                            <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="alamat" id="alamat" rows="3" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat') border-red-500 @enderror"
                                placeholder="Masukkan Alamat Lengkap">{{ old('alamat', $orangTua->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor HP Orang Tua --}}
                        <div class="mb-4">
                            <label for="no_hp" class="block text-sm font-medium text-gray-600">Nomor HP Orang Tua</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $orangTua->no_hp) }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_hp') border-red-500 @enderror"
                                placeholder="contoh: 081234567890">
                            @error('no_hp')
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
