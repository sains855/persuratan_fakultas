@extends('layouts.main_frontend')

@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50 pt-6 pb-12">
        {{-- Konten utama (form di tengah layar) --}}
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md">
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
                    <div class="auto-hide mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg flex items-start justify-between">
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

                {{-- ✅ JIKA NIM TIDAK DITEMUKAN - TAMPILKAN FORM MANUAL --}}
                @if (!$nimDitemukan)
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-700">
                            ⚠️ NIM tidak ditemukan di database. Silakan isi data secara manual.
                        </p>
                    </div>

                    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">
                        <input type="hidden" name="nim" value="{{ request('nim') }}">

                        {{-- Nama Mahasiswa --}}
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                placeholder="Masukkan Nama Lengkap">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-600">Nomor WhatsApp</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_hp') border-red-500 @enderror"
                                placeholder="contoh: 081234567890">
                            @error('no_hp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Loop persyaratan --}}
                        @foreach ($pelayanan->pelayananPersyaratan as $item)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ $item->persyaratan->nama }}
                                </label>
                                <input type="file" name="dokumen[{{ $item->persyaratan_id }}]" required
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full border border-gray-300 rounded-lg shadow-sm text-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('dokumen.' . $item->persyaratan_id) border-red-500 @enderror">
                                @error('dokumen.' . $item->persyaratan_id)
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Ajukan
                            </button>
                        </div>
                    </form>

                {{-- ✅ JIKA DATA ALUMNI PERLU DIISI DULU --}}
                @elseif ($showAlumniForm)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-700">
                            📝 Silakan lengkapi data alumni terlebih dahulu sebelum mengajukan surat.
                        </p>
                    </div>

                    <form action="{{ route('pengajuan.storeAlumni') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">

                        {{-- Nama Mahasiswa (readonly) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Nama Mahasiswa</label>
                            <input type="text" value="{{ $mahasiswa->nama }}" readonly
                                class="mt-2 w-full px-4 py-2 border rounded-lg bg-gray-100">
                        </div>

                        {{-- No Ijazah --}}
                        <div>
                            <label for="no_ijazah" class="block text-sm font-medium text-gray-600">Nomor Ijazah</label>
                            <input type="text" name="no_ijazah" id="no_ijazah" value="{{ old('no_ijazah') }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_ijazah') border-red-500 @enderror"
                                placeholder="Masukkan Nomor Ijazah">
                            @error('no_ijazah')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tahun Studi Mulai --}}
                        <div>
                            <label for="tahun_studi_mulai" class="block text-sm font-medium text-gray-600">Tahun Studi Mulai</label>
                            <input type="number" name="tahun_studi_mulai" id="tahun_studi_mulai"
                                value="{{ old('tahun_studi_mulai') }}" required
                                min="1900" max="{{ date('Y') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tahun_studi_mulai') border-red-500 @enderror"
                                placeholder="contoh: 2018">
                            @error('tahun_studi_mulai')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tahun Studi Selesai --}}
                        <div>
                            <label for="tahun_studi_selesai" class="block text-sm font-medium text-gray-600">Tahun Studi Selesai</label>
                            <input type="number" name="tahun_studi_selesai" id="tahun_studi_selesai"
                                value="{{ old('tahun_studi_selesai') }}" required
                                min="1900" max="{{ date('Y') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tahun_studi_selesai') border-red-500 @enderror"
                                placeholder="contoh: 2022">
                            @error('tahun_studi_selesai')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Yudisium --}}
                        <div>
                            <label for="tgl_yudisium" class="block text-sm font-medium text-gray-600">Tanggal Yudisium</label>
                            <input type="date" name="tgl_yudisium" id="tgl_yudisium"
                                value="{{ old('tgl_yudisium') }}" required
                                max="{{ date('Y-m-d') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tgl_yudisium') border-red-500 @enderror">
                            @error('tgl_yudisium')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition">
                                Simpan Data Alumni
                            </button>
                        </div>
                    </form>

                {{-- ✅ JIKA DATA LENGKAP - TAMPILKAN FORM PENGAJUAN NORMAL --}}
                @else
                    {{-- Form Pengajuan --}}
                    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
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

                        {{-- ✅ TAMPILKAN DATA TAMBAHAN SESUAI JENIS SURAT --}}
                        @if ($pelayanan->nama == "Surat Keterangan Aktif Kuliah" && $orangTua)
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm font-medium text-blue-700">Data Orang Tua:</p>
                                <p class="text-sm text-gray-600">Nama: {{ $orangTua->nama_ayah ?? $orangTua->nama_ibu ?? '-' }}</p>
                            </div>
                        @endif

                        @if ($pelayanan->nama == "Surat Keterangan Alumni" && $alumni)
                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-sm font-medium text-green-700">Data Alumni:</p>
                                <p class="text-sm text-gray-600">No. Ijazah: {{ $alumni->no_ijazah }}</p>
                                <p class="text-sm text-gray-600">Periode: {{ $alumni->tahun_studi_mulai }} - {{ $alumni->tahun_studi_selesai }}</p>
                            </div>
                        @endif

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-600">Nomor WhatsApp</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_hp') border-red-500 @enderror"
                                placeholder="contoh: 081234567890">
                            @error('no_hp')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Loop persyaratan --}}
                        @foreach ($pelayanan->pelayananPersyaratan as $item)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ $item->persyaratan->nama }}
                                </label>
                                <input type="file" name="dokumen[{{ $item->persyaratan_id }}]" required
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full border border-gray-300 rounded-lg shadow-sm text-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('dokumen.' . $item->persyaratan_id) border-red-500 @enderror">
                                @error('dokumen.' . $item->persyaratan_id)
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        {{-- Tombol Submit --}}
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                Ajukan
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </main>
    </div>
@endsection
