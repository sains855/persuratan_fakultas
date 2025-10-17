@extends('layouts.main_frontend')

@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50 pt-6 pb-12">
        {{-- Konten utama (form di tengah layar) --}}
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">
                    Detail Pengajuan {{ ucfirst($pelayanan->nama) }}
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
                                <a href="{{ route('beranda') }}" {{-- Ganti 'beranda' dengan nama route homepage Anda --}}
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

                {{-- Form Pengajuan --}}
                <form action="{{ route('pengajuan.store', $pelayanan->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    @if ($pelayanan->nama == 'Surat Keterangan Tempat Tinggal Sementara')
                        {{-- Alamat Sementara --}}
                        <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-600">Nama Pengaju</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                placeholder="Masukkan Nama" required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-600">Nomor Induk
                                Kependudukan (NIK)</label>
                            <input type="text" name="nik" id="nik" maxlength="16" value="{{ old('nik') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nik') border-red-500 @enderror"
                                placeholder="Masukkan NIK Anda" required>
                            @error('nik')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="alamat_sementara" class="block text-sm font-medium text-gray-600">Alamat
                                Sementara</label>
                            <input type="text" name="alamat_sementara" id="alamat_sementara"
                                value="{{ old('alamat_sementara') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat_sementara') border-red-500 @enderror"
                                placeholder="Masukkan Alamat Sementara" required>
                            @error('alamat_sementara')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-600">Jenis
                                Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('jenis_kelamin') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- RT --}}
                        <div>
                            <label for="RT" class="block text-sm font-medium text-gray-600">RT</label>
                            <input
                                type="number"
                                name="RT"
                                id="RT"
                                value="{{ old('RT') }}"
                                min="0"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('RT') border-red-500 @enderror"
                                placeholder="Masukkan RT"
                                required
                            >
                            @error('RT')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- RW --}}
                        <div>
                            <label for="RW" class="block text-sm font-medium text-gray-600">RW</label>
                            <input
                                type="number"
                                name="RW"
                                id="RW"
                                value="{{ old('RW') }}"
                                min="0"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('RW') border-red-500 @enderror"
                                placeholder="Masukkan RW"
                                required
                            >
                            @error('RW')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{--status--}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-600">Status</label>
                            <select name="status" id="status"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('status') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Kawin" {{ old('status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Belum Kawin" {{ old('status') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pekerjaan" class="block text-sm font-medium text-gray-600">Pekerjaan</label>
                            <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('pekerjaan') border-red-500 @enderror"
                                placeholder="Masukkan Pekerjaan" required>
                            @error('pekerjaan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label for="tgl_lahir" class="block text-sm font-medium text-gray-600">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tgl_lahir') border-red-500 @enderror"
                                required>
                            @error('tgl_lahir')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Tempat Lahir --}}
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-600">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tempat_lahir') border-red-500 @enderror"
                                placeholder="Masukkan Tempat Lahir" required>
                            @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Agama --}}
                        <div>
                            <label for="agama" class="block text-sm font-medium text-gray-600">Agama</label>
                            <select name="agama" id="agama"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('agama') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                </option>
                            </select>
                            @error('agama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="nik" value="{{ $masyarakat->nik }}">
                        <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">

                        {{-- Nama Pengaju --}}
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-600">Nama Pengaju</label>
                            <input type="text" name="nama" id="nama"
                                value="{{ old('nama', $masyarakat->nama) }}"
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                placeholder="Masukkan Nama" disabled>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($pelayanan->nama == 'Surat Izin Keramaian')
                            {{-- Nama Acara --}}
                            <div>
                                <label for="nama_acara" class="block text-sm font-medium text-gray-600">Nama Acara</label>
                                <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama_acara') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Acara" required>
                                @error('nama_acara')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Penyelenggara --}}
                            <div>
                                <label for="penyelenggara"
                                    class="block text-sm font-medium text-gray-600">Penyelenggara</label>
                                <input type="text" name="penyelenggara" id="penyelenggara"
                                    value="{{ old('penyelenggara') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('penyelenggara') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Penyelenggara">
                                @error('penyelenggara')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deskripsi Acara --}}
                            <div>
                                <label for="deskripsi_acara" class="block text-sm font-medium text-gray-600">Deskripsi
                                    Acara</label>
                                <textarea name="deskripsi_acara" id="deskripsi_acara" rows="3"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('deskripsi_acara') border-red-500 @enderror"
                                    placeholder="Masukkan Deskripsi Acara Seperi : Untuk Pernikahan Anakku">{{ old('deskripsi_acara') }}</textarea>
                                @error('deskripsi_acara')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-600">Tanggal
                                    Acara</label>
                                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tanggal') border-red-500 @enderror"
                                    required>
                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tempat --}}
                            <div>
                                <label for="tempat" class="block text-sm font-medium text-gray-600">Tempat Acara</label>
                                <input type="text" name="tempat" id="tempat" value="{{ old('tempat') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tempat') border-red-500 @enderror"
                                    placeholder="Masukkan Tempat Acara" required>
                                @error('tempat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Pukul --}}
                            <div>
                                <label for="pukul" class="block text-sm font-medium text-gray-600">Pukul</label>
                                <input type="text" name="pukul" id="pukul" value="{{ old('pukul') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('pukul') border-red-500 @enderror"
                                    placeholder="Contoh: 19.00 WITA - selesai">
                                @error('pukul')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($pelayanan->nama == 'Surat Keterangan Kematian')
                            {{-- Nama Meninggal --}}
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-600">Nama
                                    Meninggal</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Yang Meninggal" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-600">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('jenis_kelamin') border-red-500 @enderror"
                                    required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Umur --}}
                            <div>
                                <label for="umur" class="block text-sm font-medium text-gray-600">Umur</label>
                                <input
                                    type="number"
                                    name="umur"
                                    id="umur"
                                    min="0"
                                    max="120"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none
                                    @error('umur') border-red-500 @enderror"
                                    placeholder="Masukkan Umur (minimal 0 tahun)"
                                    required
                                >
                                @error('umur')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan Alamat Lengkap" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Hari --}}
                            <div>
                                <label for="hari" class="block text-sm font-medium text-gray-600">Hari</label>
                                <select name="hari" id="hari"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('hari') border-red-500 @enderror"
                                    required>
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                @error('hari')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Meninggal --}}
                            <div>
                                <label for="tanggal_meninggal" class="block text-sm font-medium text-gray-600">Tanggal
                                    Meninggal</label>
                                <input type="date" name="tanggal_meninggal" id="tanggal_meninggal"
                                    value="{{ old('tanggal_meninggal') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tanggal_meninggal') border-red-500 @enderror"
                                    required>
                                @error('tanggal_meninggal')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tempat Meninggal --}}
                            <div>
                                <label for="tempat_meninggal" class="block text-sm font-medium text-gray-600">Tempat
                                    Meninggal</label>
                                <input type="text" name="tempat_meninggal" id="tempat_meninggal"
                                    value="{{ old('tempat_meninggal') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tempat_meninggal') border-red-500 @enderror"
                                    placeholder="Masukkan Tempat Meninggal" required>
                                @error('tempat_meninggal')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Penyebab --}}
                            <div>
                                <label for="penyebab" class="block text-sm font-medium text-gray-600">Penyebab</label>
                                <input type="text" name="penyebab" id="penyebab" value="{{ old('penyebab') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('penyebab') border-red-500 @enderror"
                                    placeholder="Masukkan Penyebab Kematian" required>
                                @error('penyebab')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($pelayanan->nama == 'Surat Keterangan Pindah Penduduk')
                            {{-- FORM PINDAH PENDUDUK --}}
                            {{-- Desa/Kelurahan --}}
                            <div>
                                <label for="desa_kelurahan" class="block text-sm font-medium text-gray-600">Desa /
                                    Kelurahan</label>
                                <input type="text" name="desa_kelurahan" id="desa_kelurahan"
                                    value="{{ old('desa_kelurahan') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('desa_kelurahan') border-red-500 @enderror"
                                    placeholder="Masukkan Desa / Kelurahan Pindah" required>
                                @error('desa_kelurahan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-600">Kecamatan</label>
                                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('kecamatan') border-red-500 @enderror"
                                    placeholder="Masukkan Kecamatan Pindah" required>
                                @error('kecamatan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kabupaten / Kodya --}}
                            <div>
                                <label for="kab_kota" class="block text-sm font-medium text-gray-600">Kabupaten /
                                    Kota</label>
                                <input type="text" name="kab_kota" id="kab_kota" value="{{ old('kab_kota') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('kab_kota') border-red-500 @enderror"
                                    placeholder="Masukkan Kabupaten / Kota Pindah" required>
                                @error('kab_kotaa')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Provinsi --}}
                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-600">Provinsi</label>
                                <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('provinsi') border-red-500 @enderror"
                                    placeholder="Masukkan Provinsi Pindah" required>
                                @error('provinsi')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Pindah --}}
                            <div>
                                <label for="tanggal_pindah" class="block text-sm font-medium text-gray-600">Tanggal
                                    Pindah</label>
                                <input type="date" name="tanggal_pindah" id="tanggal_pindah"
                                    value="{{ old('tanggal_pindah') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tanggal_pindah') border-red-500 @enderror"
                                    required>
                                @error('tanggal_pindah')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alasan Pindah --}}
                            <div>
                                <label for="alasan_pindah" class="block text-sm font-medium text-gray-600">Alasan
                                    Pindah</label>
                                <textarea name="alasan_pindah" id="alasan_pindah" rows="3"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alasan_pindah') border-red-500 @enderror"
                                    placeholder="Masukkan Alasan Pindah">{{ old('alasan_pindah') }}</textarea>
                                @error('alasan_pindah')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Pengikut --}}
                            <div>
                                <label for="pengikut" class="block text-sm font-medium text-gray-600">Pengikut</label>
                                <input type="number" name="pengikut" id="pengikut" value="{{ old('pengikut') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('pengikut') border-red-500 @enderror"
                                    placeholder="Masukkan Jumlah Pengikut">
                                @error('pengikut')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif($pelayanan->nama == 'Surat Keterangan Domisili Usaha dan Yayasan')
                            {{-- Nama Usaha / Yayasan --}}
                            <div>
                                <label for="nama_usaha" class="block text-sm font-medium text-gray-600">Nama Usaha /
                                    Yayasan</label>
                                <input type="text" name="nama_usaha" id="nama_usaha" value="{{ old('nama_usaha') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama_usaha') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Usaha / Yayasan" required>
                                @error('nama_usaha')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="alamat_usaha" class="block text-sm font-medium text-gray-600">Alamat Usaha /
                                    Yayasan</label>
                                <textarea name="alamat_usaha" id="alamat_usaha" rows="3"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat_usaha') border-red-500 @enderror"
                                    placeholder="Masukkan Alamat Usaha / Yayasan" required>{{ old('alamat_usaha') }}</textarea>
                                @error('alamat_usaha')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_kegiatan_usaha" class="block text-sm font-medium text-gray-600">Jenis
                                    Kegiatan Usaha</label>
                                <input type="text" name="jenis_kegiatan_usaha" id="jenis_kegiatan_usaha"
                                    value="{{ old('jenis_kegiatan_usaha') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('jenis_kegiatan_usaha') border-red-500 @enderror"
                                    placeholder="Masukkan Jenis Kegiatan Usaha" required>
                                @error('jenis_kegiatan_usaha')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="penanggung_jawab" class="block text-sm font-medium text-gray-600">Penanggung
                                    Jawab</label>
                                <input type="text" name="penanggung_jawab" id="penanggung_jawab"
                                    value="{{ old('penanggung_jawab') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('penanggung_jawab') border-red-500 @enderror"
                                    placeholder="Masukkan Penanggung Jawab" required>
                                @error('penanggung_jawab')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif($pelayanan->nama == 'Surat Keterangan Memiliki Usaha (SKU)')
                            {{-- Nama Usaha --}}
                            <div>
                                <label for="nama_usaha" class="block text-sm font-medium text-gray-600">Nama Usaha</label>
                                <input type="text" name="nama_usaha" id="nama_usaha" value="{{ old('nama_usaha') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('nama_usaha') border-red-500 @enderror"
                                    placeholder="Masukkan Nama Usaha" required>
                                @error('nama_usaha')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tahun Berdiri --}}

                            <div x-data="{ open: false, selectedYear: '{{ old('tahun_berdiri') ?? '' }}' }" class="relative">
                                <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                                <label for="tahun_berdiri" class="block text-sm font-medium text-gray-600">
                                    Tahun Berdiri
                                </label>

                                <!-- Tombol utama -->
                                <button type="button" @click="open = !open"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg bg-white text-left flex justify-between items-center
                                        focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    <span x-text="selectedYear || 'Pilih Tahun'"></span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Daftar tahun -->
                                <div x-show="open" @click.outside="open = false"
                                    class="absolute z-10 mt-1 max-h-48 w-full overflow-y-auto border border-gray-300 bg-white rounded-lg shadow-lg">
                                    @for ($year = date('Y'); $year >= 1900; $year--)
                                    <div @click="selectedYear = '{{ $year }}'; open = false;"
                                        class="px-4 py-2 hover:bg-blue-100 cursor-pointer text-gray-700"
                                        :class="{ 'bg-blue-500 text-white': selectedYear == '{{ $year }}' }">
                                        {{ $year }}
                                    </div>
                                    @endfor
                                </div>

                                <!-- Hidden input untuk form -->
                                <input type="hidden" name="tahun_berdiri" x-model="selectedYear">

                                @error('tahun_berdiri')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                        @elseif ($pelayanan->nama == 'Surat Keterangan Tidak Mampu (SKTM)' || $pelayanan->nama == 'Surat Keterangan Belum Bekerja' || $pelayanan->nama == 'Surat Keterangan Belum Nikah')
                            {{-- Keperluan --}}
                            <div>
                                <label for="keperluan" class="block text-sm font-medium text-gray-600">Keperluan</label>
                                <input type="text" name="keperluan" id="keperluan" value="{{ old('keperluan') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('keperluan') border-red-500 @enderror"
                                    placeholder="Masukkan Keperluan" required>
                                @error('keperluan')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif ($pelayanan->nama == 'Surat Keterangan Tempat Tinggal Sementara')
                            {{-- Alamat Tujuan --}}
                            <div>
                                <label for="alamat_sementara" class="block text-sm font-medium text-gray-600">Alamat
                                    Sementara</label>
                                <input type="text" name="alamat_sementara" id="alamat_sementara"
                                    value="{{ old('alamat_sementara') }}"
                                    class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('alamat_sementara') border-red-500 @enderror"
                                    placeholder="Masukkan Alamat Sementara" required>
                                @error('alamat_sementara')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    @endif
                    {{-- Keperluan --}}

                    {{-- Nomor WhatsApp --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-600">Nomor WhatsApp</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                            class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('no_hp') border-red-500 @enderror"
                            placeholder="contoh: 081234567890" required>
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
                                accept=".pdf,application/pdf"
                                class="block w-full border border-gray-300 rounded-lg shadow-sm text-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
            </div>
        </main>
    </div>
@endsection
