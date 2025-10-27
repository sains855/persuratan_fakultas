@extends('layouts.main')

@push('styles')
    <style>
        /* Animasi notifikasi */
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-out {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
    </style>
@endpush

@section('content')
    <div class="mx-auto">
        <!-- Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-6 border border-blue-200">
            <!-- Form -->
            <form method="POST" action="{{ route('masyarakat.update', $masyarakat->nik) }}" id="formEditMasyarakat">
                @csrf
                @method('PUT')

                <!-- NIK -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $masyarakat->nik) }}"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    @error('nik')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $masyarakat->nama) }}"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    @error('nama')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">{{ old('alamat', $masyarakat->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RT & RW -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">RT <span class="text-red-500">*</span></label>
                        <input type="number" name="RT" value="{{ old('RT', $masyarakat->RT) }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('RT')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">RW <span class="text-red-500">*</span></label>
                        <input type="number" name="RW" value="{{ old('RW', $masyarakat->RW) }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('RW')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tempat Lahir -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $masyarakat->tempat_lahir) }}"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    @error('tempat_lahir')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $masyarakat->tgl_lahir) }}"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    @error('tgl_lahir')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <option value="">-- Pilih Status --</option>
                        <option value="Belum Kawin" {{ old('status', $masyarakat->status) == 'Belum Kawin' ? 'selected' : '' }}>
                            Belum Kawin
                        </option>
                        <option value="Kawin" {{ old('status', $masyarakat->status) == 'Kawin' ? 'selected' : '' }}>
                            Kawin
                        </option>
                        <option value="Kawin Belum Tercatat" {{ old('status', $masyarakat->status) == 'Kawin Belum Tercatat' ? 'selected' : '' }}>
                            Kawin Belum Tercatat
                        </option>
                        <option value="Cerai Mati" {{ old('status', $masyarakat->status) == 'Cerai Mati' ? 'selected' : '' }}>
                            Cerai Mati
                        </option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Pekerjaan -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $masyarakat->pekerjaan) }}"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    @error('pekerjaan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agama -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Agama <span class="text-red-500">*</span></label>
                    <select name="agama"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" {{ old('agama', $masyarakat->agama) == 'Islam' ? 'selected' : '' }}>Islam
                        </option>
                        <option value="Kristen" {{ old('agama', $masyarakat->agama) == 'Kristen' ? 'selected' : '' }}>
                            Kristen</option>
                        <option value="Katolik" {{ old('agama', $masyarakat->agama) == 'Katolik' ? 'selected' : '' }}>
                            Katolik</option>
                        <option value="Hindu" {{ old('agama', $masyarakat->agama) == 'Hindu' ? 'selected' : '' }}>Hindu
                        </option>
                        <option value="Budha" {{ old('agama', $masyarakat->agama) == 'Budha' ? 'selected' : '' }}>Budha
                        </option>
                        <option value="Konghucu" {{ old('agama', $masyarakat->agama) == 'Konghucu' ? 'selected' : '' }}>
                            Konghucu</option>
                    </select>
                    @error('agama')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jk"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jk', $masyarakat->jk) == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="Perempuan" {{ old('jk', $masyarakat->jk) == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                    @error('jk')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Tombol -->
                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('masyarakat') }}"
                        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition">
                        Back
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transition">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formEditMasyarakat');

            // Pesan error dalam bahasa Indonesia
            const pesanError = {
                nik: 'NIK harus diisi dan terdiri dari 16 digit angka',
                nama: 'Nama harus diisi',
                RT: 'RT harus diisi',
                RW: 'RW harus diisi',
                alamat: 'Alamat harus diisi',
                tempat_lahir: 'Tempat lahir harus diisi',
                tgl_lahir: 'Tanggal lahir harus diisi',
                status: 'Status harus dipilih',
                agama: 'Agama harus dipilih',
                pekerjaan: 'Pekerjaan harus diisi',
                jk: 'Jenis kelamin harus dipilih'
            };

            // Validasi form sebelum submit
            form.addEventListener('submit', function(e) {
                // Reset semua pesan error sebelumnya
                const errorMessages = this.querySelectorAll('.error-message-custom');
                errorMessages.forEach(msg => msg.remove());

                let hasError = false;
                let firstErrorField = null;

                // Validasi setiap field
                Object.keys(pesanError).forEach(fieldName => {
                    const field = this.querySelector(`[name="${fieldName}"]`);
                    if (!field) return;

                    const value = field.value.trim();

                    // Cek apakah field kosong
                    if (!value) {
                        tampilkanError(field, pesanError[fieldName]);
                        hasError = true;
                        if (!firstErrorField) firstErrorField = field;
                        return;
                    }

                    // Validasi khusus untuk NIK (harus 16 digit)
                    if (fieldName === 'nik') {
                        if (!/^\d{16}$/.test(value)) {
                            tampilkanError(field, 'NIK harus terdiri dari 16 digit angka');
                            hasError = true;
                            if (!firstErrorField) firstErrorField = field;
                        }
                    }

                    // Validasi khusus untuk RT dan RW (harus angka)
                    if ((fieldName === 'RT' || fieldName === 'RW')) {
                        if (!/^\d+$/.test(value)) {
                            tampilkanError(field, `${fieldName} harus berupa angka`);
                            hasError = true;
                            if (!firstErrorField) firstErrorField = field;
                        }
                    }
                });

                // Cegah submit jika ada error
                if (hasError) {
                    e.preventDefault();

                    // Scroll ke error pertama
                    if (firstErrorField) {
                        firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstErrorField.focus();
                    }

                    // Tampilkan notifikasi
                    tampilkanNotifikasi('Mohon lengkapi semua field yang wajib diisi dengan benar', 'error');
                }
            });

            // Fungsi untuk menampilkan pesan error
            function tampilkanError(field, pesan) {
                // Hapus error lama jika ada
                const oldError = field.parentElement.querySelector('.error-message-custom');
                if (oldError) oldError.remove();

                // Tambahkan border merah
                field.classList.add('border-red-500', '!border-red-500');
                field.classList.remove('border-blue-300');

                // Buat elemen error baru
                const errorElement = document.createElement('p');
                errorElement.className = 'error-message-custom text-red-500 text-sm mt-1';
                errorElement.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${pesan}`;

                // Sisipkan setelah input field
                field.parentElement.appendChild(errorElement);
            }

            // Hapus error ketika user mulai mengetik/memilih
            const allFields = form.querySelectorAll('input, select, textarea');
            allFields.forEach(field => {
                field.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-blue-300');

                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });

                // Untuk select, gunakan 'change' event
                if (field.tagName === 'SELECT') {
                    field.addEventListener('change', function() {
                        this.classList.remove('border-red-500', '!border-red-500');
                        this.classList.add('border-blue-300');

                        const errorMsg = this.parentElement.querySelector('.error-message-custom');
                        if (errorMsg) errorMsg.remove();
                    });
                }
            });

            // Fungsi untuk menampilkan notifikasi
            function tampilkanNotifikasi(pesan, tipe = 'error') {
                // Hapus notifikasi lama jika ada
                const oldNotif = document.querySelector('.notifikasi-custom');
                if (oldNotif) oldNotif.remove();

                const notif = document.createElement('div');
                notif.className = 'notifikasi-custom fixed top-4 right-4 px-6 py-4 rounded-lg shadow-2xl z-[10000] animate-slide-in max-w-md';

                if (tipe === 'error') {
                    notif.classList.add('bg-red-500', 'text-white');
                    notif.innerHTML = `
                        <div class="flex items-center gap-3">
                            <i class="fa fa-exclamation-circle text-xl"></i>
                            <span class="font-medium">${pesan}</span>
                        </div>
                    `;
                } else {
                    notif.classList.add('bg-green-500', 'text-white');
                    notif.innerHTML = `
                        <div class="flex items-center gap-3">
                            <i class="fa fa-check-circle text-xl"></i>
                            <span class="font-medium">${pesan}</span>
                        </div>
                    `;
                }

                document.body.appendChild(notif);

                // Hapus notifikasi setelah 5 detik
                setTimeout(() => {
                    notif.style.animation = 'slide-out 0.3s ease-out';
                    setTimeout(() => notif.remove(), 300);
                }, 5000);
            }

            // Validasi real-time untuk NIK (hanya angka dan maksimal 16 digit)
            const nikInput = form.querySelector('[name="nik"]');
            if (nikInput) {
                nikInput.addEventListener('input', function(e) {
                    // Hanya izinkan angka
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Batasi maksimal 16 digit
                    if (this.value.length > 16) {
                        this.value = this.value.slice(0, 16);
                    }
                });
            }

            // Validasi real-time untuk RT dan RW (hanya angka)
            const rtInput = form.querySelector('[name="RT"]');
            const rwInput = form.querySelector('[name="RW"]');

            if (rtInput) {
                rtInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            if (rwInput) {
                rwInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }
        });
    </script>
@endpush
@endsection
