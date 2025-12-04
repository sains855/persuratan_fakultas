@extends('layouts.main_frontend')

@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50 pt-6 pb-12">
        {{-- Konten utama (form di tengah layar) --}}
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-2xl bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">
                    {{ $title }}
                </h2>

                {{-- Flash success --}}
                @if (session('success'))
                    {{-- Latar Belakang Gelap (Overlay) --}}
                    <div x-data="{ show: true }" x-show="show" x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60"
                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        {{-- Kotak Popup --}}
                        <div @click.away="show = false"
                            class="mx-4 w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <div class="text-center">
                                {{-- Ikon Centang --}}
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>

                                {{-- Judul dan Pesan --}}
                                <h3 class="mt-4 text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                    Berhasil!
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-5 sm:mt-6">
                                <a href="{{ route('beranda') }}"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:text-sm">
                                    Oke, Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Flash success_mahasiswa --}}
                @if (session('success_mahasiswa'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium">{{ session('success_mahasiswa') }}</p>
                        </div>
                        <button type="button" onclick="this.closest('.auto-hide').remove()"
                            class="ml-4 text-green-700">✕</button>
                    </div>
                @endif

                {{-- Flash info --}}
                @if (session('info'))
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium">{{ session('info') }}</p>
                        </div>
                        <button type="button" onclick="this.closest('.auto-hide').remove()"
                            class="ml-4 text-blue-700">✕</button>
                    </div>
                @endif

                {{-- Flash error --}}
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                        <button type="button" onclick="this.closest('.auto-hide').remove()"
                            class="ml-4 text-red-600">✕</button>
                    </div>
                @endif

                {{-- Validation Errors --}}
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

                {{-- ✅ JIKA BELUM CEK NIM - TAMPILKAN FORM CEK NIM --}}
                @if (!isset($nim))
                    <form action="{{ route('frontend.keteranganbeasiswa.cekNim') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-600">
                                Masukkan NIM <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nim') border-red-500 @enderror"
                                placeholder="Contoh: 123456789">
                            @error('nim')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Cek NIM
                            </button>
                        </div>
                    </form>

                {{-- ✅ JIKA NIM TIDAK DITEMUKAN - TAMPILKAN FORM DATA MAHASISWA --}}
                @elseif ($showMahasiswaForm)
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-700">
                            ⚠️ NIM tidak ditemukan di database. Silakan isi data mahasiswa terlebih dahulu.
                        </p>
                    </div>

                    <form action="{{ route('frontend.keteranganbeasiswa.storeMahasiswa') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="nim" value="{{ $nim }}">

                        {{-- Data Mahasiswa --}}
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Mahasiswa</h3>

                            {{-- NIM (readonly) --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600">NIM</label>
                                <input type="text" value="{{ $nim }}" readonly
                                    class="mt-2 w-full px-4 py-2 border rounded-lg bg-gray-100">
                            </div>

                            {{-- Nama Mahasiswa --}}
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-600">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Lengkap">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="mb-4">
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-600">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tempat_lahir') border-red-500 @enderror"
                                    placeholder="Masukkan Tempat Lahir">
                                @error('tempat_lahir')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="mb-4">
                                <label for="tgl_lahir" class="block text-sm font-medium text-gray-600">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}" required
                                    max="{{ date('Y-m-d') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tgl_lahir') border-red-500 @enderror">
                                @error('tgl_lahir')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fakultas --}}
                            <div class="mb-4">
                                <label for="Fakultas" class="block text-sm font-medium text-gray-600">
                                    Fakultas <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="Fakultas" id="Fakultas" value="{{ old('Fakultas') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('Fakultas') border-red-500 @enderror"
                                    placeholder="Masukkan Fakultas">
                                @error('Fakultas')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Program Studi/Jurusan --}}
                            <div class="mb-4">
                                <label for="Prodi_jurusan" class="block text-sm font-medium text-gray-600">
                                    Program Studi/Jurusan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="Prodi_jurusan" id="Prodi_jurusan" value="{{ old('Prodi_jurusan') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('Prodi_jurusan') border-red-500 @enderror"
                                    placeholder="Masukkan Program Studi/Jurusan">
                                @error('Prodi_jurusan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-600">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nomor HP --}}
                            <div class="mb-4">
                                <label for="No_Hp" class="block text-sm font-medium text-gray-600">
                                    Nomor HP <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="No_Hp" id="No_Hp" value="{{ old('No_Hp') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('No_Hp') border-red-500 @enderror"
                                    placeholder="contoh: 081234567890">
                                @error('No_Hp')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-600">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                                    placeholder="contoh: mahasiswa@email.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Simpan & Lanjutkan
                            </button>
                        </div>
                    </form>

                {{-- ✅ JIKA DATA BEASISWA SUDAH TERISI - TAMPILKAN DATA BEASISWA SAJA --}}
                @elseif (isset($sudahTerisi) && $sudahTerisi)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">
                            ℹ️ Data keterangan beasiswa untuk NIM ini sudah pernah diisi.
                        </p>
                    </div>

                    {{-- Card Data Mahasiswa --}}
                    <div class="mb-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Data Mahasiswa
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Nama</p>
                                <p class="font-semibold text-gray-800">{{ $mahasiswa->nama }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">NIM</p>
                                <p class="font-semibold text-gray-800">{{ $mahasiswa->nim }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Fakultas</p>
                                <p class="font-semibold text-gray-800">{{ $mahasiswa->Fakultas }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Program Studi</p>
                                <p class="font-semibold text-gray-800">{{ $mahasiswa->Prodi_jurusan }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card Data Beasiswa --}}
                    <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Keterangan Beasiswa
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Status Beasiswa</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $keteranganBeasiswa->status_beasiswa == 'Menerima Beasiswa' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $keteranganBeasiswa->status_beasiswa }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Keterangan</p>
                                <div class="p-4 bg-white rounded-lg border border-gray-200">
                                    <p class="text-gray-800">{{ $keteranganBeasiswa->keterangan_beasiswa }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                {{-- ✅ JIKA NIM DITEMUKAN & BELUM ISI BEASISWA - TAMPILKAN FORM KETERANGAN BEASISWA --}}
                @elseif ($nimDitemukan)
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700">
                            ✅ Data mahasiswa ditemukan. Silakan lengkapi form keterangan beasiswa.
                        </p>
                    </div>

                    {{-- Tampilkan Data Mahasiswa --}}
                    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">Data Mahasiswa:</p>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Nama:</span> {{ $mahasiswa->nama }}</p>
                            <p><span class="font-medium">NIM:</span> {{ $mahasiswa->nim }}</p>
                            <p><span class="font-medium">Fakultas:</span> {{ $mahasiswa->Fakultas }}</p>
                            <p><span class="font-medium">Program Studi:</span> {{ $mahasiswa->Prodi_jurusan }}</p>
                        </div>
                    </div>

                    <form action="{{ route('frontend.keteranganbeasiswa.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="mahasiswa_nim" value="{{ $mahasiswa->nim }}">

                        {{-- Status Beasiswa --}}
                        <div>
                            <label for="status_beasiswa" class="block text-sm font-medium text-gray-600">
                                Status Beasiswa <span class="text-red-500">*</span>
                            </label>
                            <select name="status_beasiswa" id="status_beasiswa" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('status_beasiswa') border-red-500 @enderror">
                                <option value="">-- Pilih Status Beasiswa --</option>
                                <option value="Menerima Beasiswa" {{ old('status_beasiswa') == 'Menerima Beasiswa' ? 'selected' : '' }}>
                                    Menerima Beasiswa
                                </option>
                                <option value="Tidak Menerima Beasiswa" {{ old('status_beasiswa') == 'Tidak Menerima Beasiswa' ? 'selected' : '' }}>
                                    Tidak Menerima Beasiswa
                                </option>
                            </select>
                            @error('status_beasiswa')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Keterangan Beasiswa --}}
                        <div>
                            <label for="keterangan_beasiswa" class="block text-sm font-medium text-gray-600">
                                Keterangan Beasiswa <span class="text-red-500">*</span>
                            </label>
                            <textarea name="keterangan_beasiswa" id="keterangan_beasiswa" rows="4" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('keterangan_beasiswa') border-red-500 @enderror"
                                placeholder="Masukkan keterangan atau detail tentang beasiswa (misal: nama beasiswa, periode, dll)">{{ old('keterangan_beasiswa') }}</textarea>
                            @error('keterangan_beasiswa')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition">
                                Simpan Keterangan Beasiswa
                            </button>
                        </div>
                    </form>
                @endif

                {{-- Tombol Kembali --}}
                @if(isset($nim))
                    <div class="mt-6 text-center">
                        <a href="{{ route('frontend.keteranganbeasiswa.create') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            ← Cek NIM Lain
                        </a>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
