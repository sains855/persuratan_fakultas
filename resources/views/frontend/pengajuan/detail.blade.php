@extends('layouts.main_frontend')

@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50 pt-6 pb-12">
        {{-- Konten utama (form di tengah layar) --}}
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-2xl bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">
                    Detail Pengajuan {{ $pelayanan->nama }}
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

                {{-- Flash error (single message) --}}
                @if (session('error'))
                    <div
                        class="auto-hide mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg flex items-start justify-between">
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

                {{-- ✅ JIKA NIM TIDAK DITEMUKAN - TAMPILKAN FORM DATA MAHASISWA DULU --}}
                @if (!$nimDitemukan)
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-700">
                            ⚠️ NIM tidak ditemukan di database. Silakan isi data mahasiswa terlebih dahulu.
                        </p>
                    </div>

                    <form action="{{ route('pengajuan.storeMahasiswa') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">
                        <input type="hidden" name="nim" value="{{ request('nim') }}">

                        {{-- Data Mahasiswa --}}
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Mahasiswa</h3>

                            {{-- NIM (readonly) --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600">NIM</label>
                                <input type="text" value="{{ request('nim') }}" readonly
                                    class="mt-2 w-full px-4 py-2 border rounded-lg bg-gray-100">
                            </div>

                            {{-- Nama Mahasiswa --}}
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-600">Nama Lengkap <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Lengkap">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="mb-4">
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-600">Tempat Lahir <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tempat_lahir') border-red-500 @enderror"
                                    placeholder="Masukkan Tempat Lahir">
                                @error('tempat_lahir')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="mb-4">
                                <label for="tgl_lahir" class="block text-sm font-medium text-gray-600">Tanggal Lahir <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}"
                                    required max="{{ date('Y-m-d') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tgl_lahir') border-red-500 @enderror">
                                @error('tgl_lahir')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fakultas --}}
                            <div class="mb-4">
                                <label for="Fakultas" class="block text-sm font-medium text-gray-600">Fakultas <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="Fakultas" id="Fakultas" value="{{ old('Fakultas') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('Fakultas') border-red-500 @enderror"
                                    placeholder="Masukkan Fakultas">
                                @error('Fakultas')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Program Studi/Jurusan --}}
                            <div class="mb-4">
                                <label for="Prodi_jurusan" class="block text-sm font-medium text-gray-600">Program
                                    Studi/Jurusan <span class="text-red-500">*</span></label>
                                <input type="text" name="Prodi_jurusan" id="Prodi_jurusan"
                                    value="{{ old('Prodi_jurusan') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('Prodi_jurusan') border-red-500 @enderror"
                                    placeholder="Masukkan Program Studi/Jurusan">
                                @error('Prodi_jurusan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="semester" class="block text-sm font-medium text-gray-600">Semester
                                    <span class="text-red-500">*</span></label>
                                <input type="number" name="semester" id="semester"
                                    value="{{ old('semester') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('Prodi_jurusan') border-red-500 @enderror"
                                    placeholder="Masukkan semester">
                                @error('semester')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="ipk" class="block text-sm font-medium text-gray-600">IPK <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="ipk" id="ipk" value="{{ old('ipk') }}"
                                    required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan IPK">
                                @error('ipk')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="ipk_terbilang" class="block text-sm font-medium text-gray-600">IPK Terbilang
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="ipk_terbilang" id="ipk_terbilang"
                                    value="{{ old('ipk_terbilang') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan IPK Terbilang">
                                @error('ipk_terbilang')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat <span
                                        class="text-red-500">*</span></label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nomor HP --}}
                            <div class="mb-4">
                                <label for="No_Hp" class="block text-sm font-medium text-gray-600">Nomor HP <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="No_Hp" id="No_Hp" value="{{ old('No_Hp') }}"
                                    required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('No_Hp') border-red-500 @enderror"
                                    placeholder="contoh: 081234567890">
                                @error('No_Hp')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-600">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    required
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

                    {{-- ✅ JIKA DATA ORANG TUA PERLU DIISI DULU (Surat Keterangan Aktif Kuliah) --}}
                @elseif ($showOrangTuaForm)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">
                            ✅ Data mahasiswa telah tersimpan. Silakan lengkapi data orang tua untuk melanjutkan.
                        </p>
                    </div>

                    {{-- Tampilkan Data Mahasiswa --}}
                    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">Data Mahasiswa:</p>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Nama:</span> {{ $mahasiswa->nama }}</p>
                            <p><span class="font-medium">NIM:</span> {{ $mahasiswa->nim }}</p>
                        </div>
                    </div>

                    <form action="{{ route('pengajuan.storeOrangTua') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">
                        <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">

                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Orang Tua</h3>

                            {{-- Nama Orang Tua --}}
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-600">Nama Orang Tua <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                    required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Orang Tua">
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- pekerjaaan --}}
                            <div class="mb-4">
                                <label for="pekerjaaan" class="block text-sm font-medium text-gray-600">pekerjaan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="pekerjaaan" id="pekerjaaan" value="{{ old('pekerjaaan') }}"
                                    required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('pekerjaaan') border-red-500 @enderror"
                                    placeholder="Masukkan pekerjaaan">
                                @error('pekerjaaan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- NIP/No. Pensiun/NRP --}}
                            <div class="mb-4">
                                <label for="NIP_NOPensiun_NRP" class="block text-sm font-medium text-gray-600">NIP/No.
                                    Pensiun/NRP</label>
                                <input type="text" name="NIP_NOPensiun_NRP" id="NIP_NOPensiun_NRP"
                                    value="{{ old('NIP_NOPensiun_NRP') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('NIP_NOPensiun_NRP') border-red-500 @enderror"
                                    placeholder="Masukkan NIP/No. Pensiun/NRP (jika ada)">
                                @error('NIP_NOPensiun_NRP')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Pangkat --}}
                            <div class="mb-4">
                                <label for="pangkat" class="block text-sm font-medium text-gray-600">Pangkat</label>
                                <input type="text" name="pangkat" id="pangkat" value="{{ old('pangkat') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('pangkat') border-red-500 @enderror"
                                    placeholder="Masukkan Pangkat (jika ada)">
                                @error('pangkat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Instansi --}}
                            <div class="mb-4">
                                <label for="instansi" class="block text-sm font-medium text-gray-600">Instansi</label>
                                <input type="text" name="instansi" id="instansi" value="{{ old('instansi') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('instansi') border-red-500 @enderror"
                                    placeholder="Masukkan Instansi (jika ada)">
                                @error('instansi')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat <span
                                        class="text-red-500">*</span></label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nomor HP Orang Tua --}}
                            <div class="mb-4">
                                <label for="no_hp" class="block text-sm font-medium text-gray-600">Nomor HP Orang
                                    Tua</label>
                                <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_hp') border-red-500 @enderror"
                                    placeholder="contoh: 081234567890">
                                @error('no_hp')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition">
                                Simpan & Lanjutkan ke Pengajuan
                            </button>
                        </div>
                    </form>

                    {{-- ✅ JIKA DATA ALUMNI PERLU DIISI DULU (Surat Keterangan Alumni) --}}
                @elseif ($showAlumniForm)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">
                            ✅ Data mahasiswa telah tersimpan. Silakan lengkapi data alumni untuk melanjutkan.
                        </p>
                    </div>

                    {{-- Tampilkan Data Mahasiswa --}}
                    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">Data Mahasiswa:</p>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Nama:</span> {{ $mahasiswa->nama }}</p>
                            <p><span class="font-medium">NIM:</span> {{ $mahasiswa->nim }}</p>
                        </div>
                    </div>

                    <form action="{{ route('pengajuan.storeAlumni') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">
                        <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">

                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Alumni</h3>

                            {{-- No Ijazah --}}
                            <div class="mb-4">
                                <label for="no_ijazah" class="block text-sm font-medium text-gray-600">Nomor Ijazah <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="no_ijazah" id="no_ijazah" value="{{ old('no_ijazah') }}"
                                    required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_ijazah') border-red-500 @enderror"
                                    placeholder="Masukkan Nomor Ijazah">
                                @error('no_ijazah')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tahun Studi Mulai --}}
                            <div class="mb-4">
                                <label for="tahun_studi_mulai" class="block text-sm font-medium text-gray-600">Tahun Studi
                                    Mulai <span class="text-red-500">*</span></label>
                                <input type="number" name="tahun_studi_mulai" id="tahun_studi_mulai"
                                    value="{{ old('tahun_studi_mulai') }}" required min="1900"
                                    max="{{ date('Y') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tahun_studi_mulai') border-red-500 @enderror"
                                    placeholder="contoh: 2018">
                                @error('tahun_studi_mulai')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tahun Studi Selesai --}}
                            <div class="mb-4">
                                <label for="tahun_studi_selesai" class="block text-sm font-medium text-gray-600">Tahun
                                    Studi Selesai <span class="text-red-500">*</span></label>
                                <input type="number" name="tahun_studi_selesai" id="tahun_studi_selesai"
                                    value="{{ old('tahun_studi_selesai') }}" required min="1900"
                                    max="{{ date('Y') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tahun_studi_selesai') border-red-500 @enderror"
                                    placeholder="contoh: 2022">
                                @error('tahun_studi_selesai')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Yudisium --}}
                            <div class="mb-4">
                                <label for="tgl_yudisium" class="block text-sm font-medium text-gray-600">Tanggal Yudisium
                                    <span class="text-red-500">*</span></label>
                                <input type="date" name="tgl_yudisium" id="tgl_yudisium"
                                    value="{{ old('tgl_yudisium') }}" required
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tgl_yudisium') border-red-500 @enderror">
                                @error('tgl_yudisium')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition">
                                Simpan & Lanjutkan ke Pengajuan
                            </button>
                        </div>
                    </form>

                    {{-- ✅ JIKA DATA LENGKAP - TAMPILKAN FORM PENGAJUAN NORMAL --}}
                @else
                    {{-- Form Pengajuan --}}
                    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-5">
                        @csrf
                        <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">
                        <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">

                        {{-- Nama Mahasiswa (readonly) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nama Mahasiswa</label>
                            <input type="text" value="{{ $mahasiswa->nama }}" readonly
                                class="mt-2 w-full px-4 py-2 border rounded-lg bg-gray-100">
                        </div>

                        {{-- NIM (readonly) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-600">NIM</label>
                            <input type="text" value="{{ $mahasiswa->nim }}" readonly
                                class="mt-2 w-full px-4 py-2 border rounded-lg bg-gray-100">
                        </div>
                        {{-- Data IPK dengan tombol edit --}}
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm font-medium text-gray-700">Data IPK:</p>
                                <a href="{{ route('pengajuan.editMahasiswa', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-semibold border-b border-blue-600">
                                    Edit
                                </a>
                            </div>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><span class="font-medium">IPK:</span>
                                    {{ $mahasiswa->ipk }}</p>
                                <p><span class="font-medium">IPK Terbilang:</span>
                                    {{ $mahasiswa->ipk_terbilang }}</p>
                            </div>
                        </div>

                        {{-- ✅ TAMPILKAN DATA TAMBAHAN SESUAI JENIS SURAT --}}
                        {{-- ✅ TAMPILKAN DATA TAMBAHAN SESUAI JENIS SURAT --}}
                        @if ($pelayanan->nama == 'Surat Keterangan Aktif Kuliah' && $orangTua)
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                {{-- Tombol Edit ditambahkan di sini --}}
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-sm font-medium text-blue-700">Data Orang Tua:</p>
                                    <a href="{{ route('pengajuan.editOrangTua', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}"
                                        class="text-xs text-blue-600 hover:text-blue-800 font-semibold border-b border-blue-600">
                                        Edit
                                    </a>
                                </div>
                                {{-- Akhir Tombol Edit --}}
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p><span class="font-medium">Nama:</span> {{ $orangTua->nama }}</p>
                                    <p><span class="font-medium">pekerjan:</span> {{ $orangTua->pekerjaaan }}</p>
                                    @if ($orangTua->instansi)
                                        <p><span class="font-medium">Instansi:</span> {{ $orangTua->instansi }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if ($pelayanan->nama == 'Surat Keterangan Alumni' && $alumni)
                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                {{-- Tombol Edit ditambahkan di sini --}}
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-sm font-medium text-green-700">Data Alumni:</p>
                                    <a href="{{ route('pengajuan.editAlumni', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}"
                                        class="text-xs text-green-600 hover:text-green-800 font-semibold border-b border-green-600">
                                        Edit
                                    </a>
                                </div>
                                {{-- Akhir Tombol Edit --}}
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p><span class="font-medium">No. Ijazah:</span> {{ $alumni->no_ijazah }}</p>
                                    <p><span class="font-medium">Periode Studi:</span> {{ $alumni->tahun_studi_mulai }} -
                                        {{ $alumni->tahun_studi_selesai }}</p>
                                    <p><span class="font-medium">Tanggal Yudisium:</span>
                                        {{ \Carbon\Carbon::parse($alumni->tgl_yudisium)->format('d F Y') }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-600">Nomor WhatsApp <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="no_hp" id="no_hp"
                                value="{{ old('no_hp', $mahasiswa->No_Hp ?? '') }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_hp') border-red-500 @enderror"
                                placeholder="contoh: 081234567890">
                            @error('no_hp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Dokumen Persyaratan --}}
                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Dokumen Persyaratan</h3>
                            @foreach ($pelayanan->pelayananPersyaratan as $item)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        {{ $item->persyaratan->nama }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="dokumen[{{ $item->persyaratan_id }}]" required
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="block w-full border border-gray-300 rounded-lg shadow-sm text-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('dokumen.' . $item->persyaratan_id) border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</p>
                                    @error('dokumen.' . $item->persyaratan_id)
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Ajukan Permohonan
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </main>
    </div>
@endsection
