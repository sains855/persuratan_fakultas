@extends('layouts.main')

@section('content')
    <div class="mx-auto">
        <!-- Card -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 shadow-xl rounded-2xl p-6 border border-red-200">
            <!-- Form -->
            <form method="POST" action="{{ route('ttd.update', $Ttd->id) }}" enctype="multipart/form-data" id="formEditTtd">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">NIP <span class="text-red-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip', $Ttd->nip) }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400">
                    @error('nip')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $Ttd->nama) }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400">
                    @error('nama')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $Ttd->jabatan) }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400">
                    @error('jabatan')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Pangkat/Gol <span class="text-red-500">*</span></label>
                    <input type="text" name="pangkat/gol" value="{{ old('pangkat/gol', $Ttd->{'pangkat/gol'}) }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400">
                    @error('pangkat/gol')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Foto</label>

                    <!-- Preview Foto Lama -->
                    @if ($Ttd->foto)
                        <div class="mb-2">
                            <img src="{{ asset($Ttd->foto) }}" alt="Foto lama"
                                class="w-32 h-32 object-cover rounded-lg shadow-md">
                        </div>
                    @endif

                    <input type="file" name="foto" accept="image/*"
                        class="w-full border border-red-300 rounded-lg px-3 py-2
                               focus:ring-2 focus:ring-red-400 focus:border-red-400 file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP, JPEG (Max: 2MB)</p>
                    @error('foto')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('ttd') }}"
                        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition">
                        Back
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-lg
                               hover:from-red-700 hover:to-red-600 shadow-md transition">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formEditTtd');

            // ============ VALIDASI FORM DENGAN PESAN BAHASA INDONESIA ============
            const pesanError = {
                nip: 'NIP harus diisi',
                nama: 'Nama harus diisi',
                jabatan: 'Jabatan harus diisi',
                pangkat: 'Pangkat/Gol harus diisi',
                foto: 'Format foto harus JPG, PNG, WEBP, atau JPEG (max: 2MB)'
            };

            // Validasi form sebelum submit
            form.addEventListener('submit', function(e) {
                // Reset semua pesan error sebelumnya
                const errorMessages = this.querySelectorAll('.error-message-custom');
                errorMessages.forEach(msg => msg.remove());

                let hasError = false;
                let firstErrorField = null;

                // Validasi NIP
                const nipField = this.querySelector('[name="nip"]');
                if (!nipField.value.trim()) {
                    tampilkanError(nipField, pesanError.nip);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = nipField;
                }

                // Validasi Nama
                const namaField = this.querySelector('[name="nama"]');
                if (!namaField.value.trim()) {
                    tampilkanError(namaField, pesanError.nama);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = namaField;
                }

                // Validasi Jabatan
                const jabatanField = this.querySelector('[name="jabatan"]');
                if (!jabatanField.value.trim()) {
                    tampilkanError(jabatanField, pesanError.jabatan);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = jabatanField;
                }

                // Validasi Pangkat/Gol
                const pangkatField = this.querySelector('[name="pangkat/gol"]');
                if (!pangkatField.value.trim()) {
                    tampilkanError(pangkatField, pesanError.pangkat);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = pangkatField;
                }

                // Validasi Foto (opsional, hanya jika ada file yang dipilih)
                const fotoField = this.querySelector('[name="foto"]');
                if (fotoField.files.length > 0) {
                    const file = fotoField.files[0];
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!allowedTypes.includes(file.type)) {
                        tampilkanError(fotoField, 'Format file harus JPG, PNG, WEBP, atau JPEG');
                        hasError = true;
                        if (!firstErrorField) firstErrorField = fotoField;
                    } else if (file.size > maxSize) {
                        tampilkanError(fotoField, 'Ukuran file maksimal 2MB');
                        hasError = true;
                        if (!firstErrorField) firstErrorField = fotoField;
                    }
                }

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
                field.classList.remove('border-red-300');

                // Buat elemen error baru
                const errorElement = document.createElement('p');
                errorElement.className = 'error-message-custom text-red-500 text-xs mt-1';
                errorElement.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${pesan}`;

                // Sisipkan setelah input field
                field.parentElement.appendChild(errorElement);
            }

            // Hapus error ketika user mulai mengetik/memilih
            const nipInput = form.querySelector('[name="nip"]');
            const namaInput = form.querySelector('[name="nama"]');
            const jabatanInput = form.querySelector('[name="jabatan"]');
            const pangkatInput = form.querySelector('[name="pangkat/gol"]');
            const fotoInput = form.querySelector('[name="foto"]');

            if (nipInput) {
                nipInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (namaInput) {
                namaInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (jabatanInput) {
                jabatanInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (pangkatInput) {
                pangkatInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (fotoInput) {
                fotoInput.addEventListener('change', function() {
                    // Reset error styling
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();

                    // Validasi ukuran file real-time
                    if (this.files.length > 0) {
                        const file = this.files[0];
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                        // Cek tipe file
                        if (!allowedTypes.includes(file.type)) {
                            tampilkanError(this, 'Format file harus JPG, PNG, WEBP, atau JPEG');
                            this.value = ''; // Reset input
                            return;
                        }

                        // Cek ukuran file
                        if (file.size > maxSize) {
                            const ukuranMB = (file.size / (1024 * 1024)).toFixed(2);
                            tampilkanError(this, `Ukuran file ${ukuranMB}MB melebihi batas maksimal 2MB`);
                            this.value = ''; // Reset input

                            // Tampilkan notifikasi
                            tampilkanNotifikasi(`File terlalu besar (${ukuranMB}MB). Maksimal 2MB`, 'error');
                        }
                    }
                });
            }

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
        });
    </script>
@endsection
