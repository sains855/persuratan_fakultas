@extends('layouts.main')

@section('content')

@if(session('success'))
        <div id="successNotification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl z-[10000] animate-slide-in max-w-md">
            <div class="flex items-center gap-3">
                <i class="fa fa-check-circle text-2xl"></i>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="closeSuccessNotification()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        @endif

    <div class="container mx-auto px-4 py-4">

        <!-- Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-4 sm:p-6 border border-blue-200">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-4">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-blue-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-newspaper text-blue-600 text-lg sm:text-xl"></i>
                    <span class="break-words">Daftar {{ $title }}</span>
                </h2>
                <button id="openModalBtn"
                    class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:from-blue-700 hover:to-blue-600 shadow-md transition text-sm sm:text-base whitespace-nowrap">
                    <i class="fa fa-plus"></i>
                    <span class="hidden sm:inline">Tambah </span>Aparatur
                </button>
            </div>
            {{-- Table Dekstop --}}
            <div class="hidden lg:block overflow-x-auto rounded-xl border border-blue-200">
                <table class="min-w-full rounded-xl overflow-hidden">
                    <thead class="bg-blue-600 text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center">Foto</th>
                            <th class="px-4 py-3 text-center">Posisi</th>
                            <th class="px-4 py-3 text-left">NIP</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Jabatan</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm bg-white">
                        @forelse ($aparatur as $data)
                            <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                                <td class="px-4 py-3 text-center align-top">
                                    @if ($data->foto)
                                        <img src="{{ asset($data->foto) }}" alt="foto_aparatur"
                                            class="w-16 h-16 object-cover rounded-lg mx-auto shadow">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-semibold text-blue-600 align-top">{{ $data->posisi }}</td>
                                <td class="px-4 py-3 align-top">{{ $data->nip }}</td>
                                <td class="px-4 py-3 align-top">{{ $data->nama }}</td>
                                <td class="px-4 py-3 align-top">{{ $data->jabatan }}</td>
                                <td class="px-4 py-3 align-top">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="{{ route('aparatur.edit', $data->id) }}"
                                            class="text-yellow-500 hover:text-yellow-600 transition transform hover:scale-110"
                                            title="Edit">
                                            <i class="fa fa-edit text-lg"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ route('aparatur.delete', $data->id) }}', '{{ $data->nama }}')"
                                            class="text-red-500 hover:text-red-600 transition transform hover:scale-110"
                                            title="Hapus">
                                            <i class="fa fa-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-6 text-gray-500">
                                    <i class="fa fa-inbox text-3xl mb-2 block"></i>
                                    Tidak ada data aparatur
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile & Tablet Card View -->
            <div class="lg:hidden space-y-3">
                @forelse ($aparatur as $data)
                    <div class="bg-white rounded-lg border border-blue-200 shadow-sm p-4">
                        <!-- Foto di Atas & Tengah -->
                        <div class="flex justify-center mb-4">
                            @if ($data->foto)
                                <img src="{{ asset($data->foto) }}" alt="foto_aparatur"
                                    class="w-24 h-24 object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        <!-- Info Aparatur -->
                        <div class="space-y-2">
                            <div class="flex justify-center mb-3">
                                <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded">
                                    Posisi {{ $data->posisi }}
                                </span>
                            </div>

                            <div class="text-center mb-2">
                                <h3 class="font-semibold text-gray-800 text-base">{{ $data->nama }}</h3>
                            </div>

                            <div class="text-sm text-gray-600 text-center">
                                <strong>NIP:</strong> {{ $data->nip }}
                            </div>

                            <div class="text-sm text-gray-600 text-center">
                                <strong>Jabatan:</strong> {{ $data->jabatan }}
                            </div>
                        </div>

                        <!-- Aksi Buttons -->
                        <div class="flex justify-center gap-3 pt-3 mt-3 border-t border-gray-100">
                            <a href="{{ route('aparatur.edit', $data->id) }}"
                                class="bg-yellow-500 text-white px-4 py-2 rounded text-sm hover:bg-yellow-600 transition flex items-center gap-1">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('aparatur.delete', $data->id) }}', '{{ $data->nama }}')"
                                class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600 transition flex items-center gap-1">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-blue-200 p-6 text-center text-gray-500">
                        <i class="fa fa-inbox text-3xl mb-2 text-gray-300"></i>
                        <p>Tidak ada data aparatur</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Tambah Aparatur -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-4 sm:p-6 relative transform scale-95 opacity-0 transition-all duration-300"
            id="modalContent">
            <!-- Tombol Close -->
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition z-10">
                <i class="fa fa-times text-lg"></i>
            </button>

            <!-- Header Modal -->
            <h3 class="text-xl font-bold mb-5 text-blue-700 flex items-center gap-2 pr-8">
                <i class="fa fa-plus-circle text-blue-500"></i> Tambah Aparatur
            </h3>

            <!-- Form -->
            <form method="POST" action="{{ route('aparatur.store') }}" enctype="multipart/form-data" class="space-y-4" id="formAparatur">
                @csrf
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm">
                        @error('nip')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm">
                        @error('jabatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Posisi <span class="text-red-500">*</span></label>
                        <input type="number" name="posisi" value="{{ old('posisi') }}" step="1" min="1" onkeydown="return false"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm">
                        @error('posisi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Foto<span class="text-red-500">*</span></label>
                        <input type="file" name="foto"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
                        @error('foto')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" id="closeModalBtn2"
                        class="w-full sm:w-auto bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transition text-sm">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative transform scale-95 opacity-0 transition-all duration-300"
            id="deleteModalContent">
            <!-- Icon Warning -->
            <div class="flex justify-center mb-4">
                <div class="bg-red-100 rounded-full p-3">
                    <i class="fa fa-exclamation-triangle text-red-600 text-3xl"></i>
                </div>
            </div>

            <!-- Header -->
            <h3 class="text-xl font-bold text-center text-gray-800 mb-2">
                Konfirmasi Hapus
            </h3>

            <!-- Message -->
            <p class="text-center text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus aparatur <span id="deleteNama" class="font-semibold text-gray-800"></span>?
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button type="button" id="cancelDeleteBtn"
                    class="w-full sm:w-auto bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500 transition text-sm">
                    Batal
                </button>
                <a id="confirmDeleteBtn" href="#"
                    class="w-full sm:w-auto bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-2 rounded-lg hover:from-red-700 hover:to-red-600 shadow-md transition text-sm text-center">
                    <i class="fa fa-trash"></i> Hapus
                </a>
            </div>
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

            // Fungsi untuk menutup notifikasi sukses
    function closeSuccessNotification() {
        const notif = document.getElementById('successNotification');
        if (notif) {
            notif.style.animation = 'slide-out 0.3s ease-out';
            setTimeout(() => notif.remove(), 300);
        }
    }

    // Auto close notifikasi sukses setelah 5 detik
    document.addEventListener('DOMContentLoaded', function() {
        const successNotif = document.getElementById('successNotification');
        if (successNotif) {
            setTimeout(() => {
                closeSuccessNotification();
            }, 5000);
        }
    });
        document.addEventListener('DOMContentLoaded', function() {
            // Modal tambah aparatur functionality
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const closeModalBtn2 = document.getElementById('closeModalBtn2');
            const form = document.getElementById('formAparatur');

            // Cek jika ada error dari Laravel, buka modal otomatis
            @if($errors->any())
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            @endif

            openModalBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            });

            function closeModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
                document.body.style.overflow = 'auto';
            }

            [closeModalBtn, closeModalBtn2].forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // ============ VALIDASI FORM DENGAN PESAN BAHASA INDONESIA ============
            const pesanError = {
                nip: 'NIP harus diisi',
                nama: 'Nama aparatur harus diisi',
                jabatan: 'Jabatan harus diisi',
                posisi: 'Posisi harus diisi dengan angka yang valid',
                foto: 'Foto harus diupload (format: JPG, PNG, JPEG, GIF, max: 2MB)'
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

                // Validasi Posisi
                const posisiField = this.querySelector('[name="posisi"]');
                if (!posisiField.value.trim()) {
                    tampilkanError(posisiField, pesanError.posisi);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = posisiField;
                } else if (isNaN(posisiField.value) || parseInt(posisiField.value) < 0) {
                    tampilkanError(posisiField, 'Posisi harus berupa angka positif');
                    hasError = true;
                    if (!firstErrorField) firstErrorField = posisiField;
                }

                // Validasi Foto (opsional, hanya jika ada file yang dipilih)
                const fotoField = this.querySelector('[name="foto"]');
                if (fotoField.files.length > 0) {
                    const file = fotoField.files[0];
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!allowedTypes.includes(file.type)) {
                        tampilkanError(fotoField, 'Format file harus JPG, PNG, JPEG, atau GIF');
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
                field.classList.remove('border-blue-300');

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
            const posisiInput = form.querySelector('[name="posisi"]');
            const fotoInput = form.querySelector('[name="foto"]');

            if (nipInput) {
                nipInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-blue-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (namaInput) {
                namaInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-blue-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (jabatanInput) {
                jabatanInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-blue-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (posisiInput) {
                posisiInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-blue-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (fotoInput) {
                fotoInput.addEventListener('change', function() {
                    // Reset error styling
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-blue-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();

                    // Validasi ukuran file real-time
                    if (this.files.length > 0) {
                        const file = this.files[0];
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

                        // Cek tipe file
                        if (!allowedTypes.includes(file.type)) {
                            tampilkanError(this, 'Format file harus JPG, PNG, JPEG, atau GIF');
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

        // Modal konfirmasi hapus functionality
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteNama = document.getElementById('deleteNama');

        function confirmDelete(url, nama) {
            deleteNama.textContent = nama;
            confirmDeleteBtn.href = url;

            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModalContent.classList.remove('scale-95', 'opacity-0');
                deleteModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        cancelDeleteBtn.addEventListener('click', () => {
            deleteModalContent.classList.remove('scale-100', 'opacity-100');
            deleteModalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 300);
        });

        // Close delete modal when clicking outside
        deleteModal.addEventListener('click', (e) => {
            if (e.target === deleteModal) {
                deleteModalContent.classList.remove('scale-100', 'opacity-100');
                deleteModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    deleteModal.classList.add('hidden');
                }, 300);
            }
        });
    </script>
@endsection
