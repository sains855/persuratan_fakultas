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

@if(session('error'))
    <div id="errorNotification" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-2xl z-[10000] animate-slide-in max-w-md">
        <div class="flex items-center gap-3">
            <i class="fa fa-exclamation-circle text-2xl"></i>
            <div>
                <p class="font-bold">Error!</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
            <button onclick="closeErrorNotification()" class="ml-4 text-white hover:text-gray-200">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
@endif

<div class="container mx-auto px-4 py-4">
    <!-- Card -->
    <div class="bg-gradient-to-br from-red-50 to-red-100 shadow-xl rounded-2xl p-4 sm:p-6 border border-red-200">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-4">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-red-800 tracking-wide flex items-center gap-2">
                <i class="fa fa-pen-fancy text-red-600 text-lg sm:text-xl"></i>
                <span class="break-words">Daftar {{ $title }}</span>
            </h2>
            <button id="openModalBtn"
                class="bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:from-red-700 hover:to-red-600 shadow-md transition text-sm sm:text-base whitespace-nowrap">
                <i class="fa fa-plus"></i>
                <span class="hidden sm:inline">Tambah </span>TTD
            </button>
        </div>

        {{-- Table Desktop --}}
        <div class="hidden lg:block overflow-x-auto rounded-xl border border-red-200">
            <table class="min-w-full rounded-xl overflow-hidden">
                <thead class="bg-red-600 text-white uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center">Foto</th>
                        <th class="px-4 py-3 text-center">Posisi</th>
                        <th class="px-4 py-3 text-left">NIP</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Pangkat/Gol</th>
                        <th class="px-4 py-3 text-left">Fakultas</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm bg-white">
                    @forelse ($Ttd as $data)
                        <tr class="border-b border-gray-200 hover:bg-red-50 transition">
                            <td class="px-4 py-3 text-center align-top">
                                @if ($data->foto)
                                    <img src="{{ asset($data->foto) }}" alt="foto_ttd"
                                        class="w-16 h-16 object-cover rounded-lg mx-auto shadow">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center font-semibold text-red-600 align-top">{{ $data->posisi }}</td>
                            <td class="px-4 py-3 align-top">{{ $data->nip }}</td>
                            <td class="px-4 py-3 align-top">{{ $data->nama }}</td>
                            <td class="px-4 py-3 align-top">{{ $data->jabatan }}</td>
                            <td class="px-4 py-3 align-top">{{ $data->pangkat_golruang }}</td>
                            <td class="px-4 py-3 align-top">{{ $data->fakultas }}</td>
                            <td class="px-4 py-3 align-top">
                                <div class="flex justify-center items-center gap-3">
                                    <a href="{{ route('ttd.edit', $data->id) }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition transform hover:scale-110"
                                        title="Edit">
                                        <i class="fa fa-edit text-lg"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ route('ttd.delete', $data->id) }}', '{{ $data->nama }}')"
                                        class="text-red-500 hover:text-red-600 transition transform hover:scale-110"
                                        title="Hapus">
                                        <i class="fa fa-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-6 text-gray-500">
                                <i class="fa fa-inbox text-3xl mb-2 block"></i>
                                Tidak ada data TTD
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile & Tablet Card View -->
        <div class="lg:hidden space-y-3">
            @forelse ($Ttd as $data)
                <div class="bg-white rounded-lg border border-red-200 shadow-sm p-4">
                    <!-- Foto di Atas & Tengah -->
                    <div class="flex justify-center mb-4">
                        @if ($data->foto)
                            <img src="{{ asset($data->foto) }}" alt="foto_ttd"
                                class="w-24 h-24 object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>

                    <!-- Info TTD -->
                    <div class="space-y-2">
                        <div class="flex justify-center mb-3">
                            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded">
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

                        <div class="text-sm text-gray-600 text-center">
                            <strong>Pangkat/Gol:</strong> {{ $data->pangkat_golruang }}
                        </div>

                        <div class="text-sm text-gray-600 text-center">
                            <strong>Fakultas:</strong> {{ $data->fakultas }}
                        </div>
                    </div>

                    <!-- Aksi Buttons -->
                    <div class="flex justify-center gap-3 pt-3 mt-3 border-t border-gray-100">
                        <a href="{{ route('ttd.edit', $data->id) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded text-sm hover:bg-yellow-600 transition flex items-center gap-1">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <button onclick="confirmDelete('{{ route('ttd.delete', $data->id) }}', '{{ $data->nama }}')"
                            class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600 transition flex items-center gap-1">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-red-200 p-6 text-center text-gray-500">
                    <i class="fa fa-inbox text-3xl mb-2 text-gray-300"></i>
                    <p>Tidak ada data TTD</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Tambah TTD -->
<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-gradient-to-br from-white to-red-50 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-4 sm:p-6 relative transform scale-95 opacity-0 transition-all duration-300"
        id="modalContent">
        <!-- Tombol Close -->
        <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition z-10">
            <i class="fa fa-times text-lg"></i>
        </button>

        <!-- Header Modal -->
        <h3 class="text-xl font-bold mb-5 text-red-700 flex items-center gap-2 pr-8">
            <i class="fa fa-plus-circle text-red-500"></i> Tambah TTD
        </h3>

        <!-- Form -->
        <form method="POST" action="{{ route('ttd.store') }}" enctype="multipart/form-data" class="space-y-4" id="formTtd">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">NIP <span class="text-red-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip') }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm">
                    @error('nip')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm">
                    @error('jabatan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Pangkat/Golongan Ruang <span class="text-red-500">*</span></label>
                    <input type="text" name="pangkat_golruang" value="{{ old('pangkat_golruang') }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm">
                    @error('pangkat_golruang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Fakultas <span class="text-red-500">*</span></label>
                    <input type="text" name="fakultas" value="{{ old('fakultas') }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm">
                    @error('fakultas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Posisi <span class="text-red-500">*</span></label>
                    <input type="number" name="posisi" value="{{ old('posisi') }}" min="1"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm">
                    @error('posisi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Foto (Opsional)</label>
                    <input type="file" name="foto"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400 text-sm file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                        accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP, JPEG</p>
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
                    class="w-full sm:w-auto bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-600 shadow-md transition text-sm">
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
            Apakah Anda yakin ingin menghapus TTD <span id="deleteNama" class="font-semibold text-gray-800"></span>?
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

    // Fungsi untuk menutup notifikasi error
    function closeErrorNotification() {
        const notif = document.getElementById('errorNotification');
        if (notif) {
            notif.style.animation = 'slide-out 0.3s ease-out';
            setTimeout(() => notif.remove(), 300);
        }
    }

    // Auto close notifikasi setelah 5 detik
    document.addEventListener('DOMContentLoaded', function() {
        const successNotif = document.getElementById('successNotification');
        const errorNotif = document.getElementById('errorNotification');

        if (successNotif) {
            setTimeout(() => closeSuccessNotification(), 5000);
        }

        if (errorNotif) {
            setTimeout(() => closeErrorNotification(), 5000);
        }

        // Modal tambah TTD functionality
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modalContent');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalBtn2 = document.getElementById('closeModalBtn2');
        const form = document.getElementById('formTtd');

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

        // Validasi form
        const pesanError = {
            nip: 'NIP harus diisi',
            nama: 'Nama harus diisi',
            jabatan: 'Jabatan harus diisi',
            pangkat: 'Pangkat/Golongan Ruang harus diisi',
            fakultas: 'Fakultas harus diisi',
            posisi: 'Posisi harus diisi',
            foto: 'Format foto harus JPG, PNG, WEBP, atau JPEG'
        };

        form.addEventListener('submit', function(e) {
            const errorMessages = this.querySelectorAll('.error-message-custom');
            errorMessages.forEach(msg => msg.remove());

            let hasError = false;
            let firstErrorField = null;

            // Validasi setiap field
            const fields = ['nip', 'nama', 'jabatan', 'pangkat_golruang', 'fakultas', 'posisi'];
            fields.forEach(fieldName => {
                const field = this.querySelector(`[name="${fieldName}"]`);
                if (field && !field.value.trim()) {
                    const errorKey = fieldName === 'pangkat_golruang' ? 'pangkat' : fieldName;
                    tampilkanError(field, pesanError[errorKey]);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = field;
                }
            });

            // Validasi foto
            const fotoField = this.querySelector('[name="foto"]');
            if (fotoField && fotoField.files.length > 0) {
                const file = fotoField.files[0];
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                if (!allowedTypes.includes(file.type)) {
                    tampilkanError(fotoField, 'Format file harus JPG, PNG, WEBP, atau JPEG');
                    hasError = true;
                    if (!firstErrorField) firstErrorField = fotoField;
                }
            }

            if (hasError) {
                e.preventDefault();
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorField.focus();
                }
                tampilkanNotifikasi('Mohon lengkapi semua field yang wajib diisi dengan benar', 'error');
            }
        });

        function tampilkanError(field, pesan) {
            const oldError = field.parentElement.querySelector('.error-message-custom');
            if (oldError) oldError.remove();

            field.classList.add('border-red-500', '!border-red-500');
            field.classList.remove('border-red-300');

            const errorElement = document.createElement('p');
            errorElement.className = 'error-message-custom text-red-500 text-xs mt-1';
            errorElement.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${pesan}`;
            field.parentElement.appendChild(errorElement);
        }

        // Hapus error saat user mengetik
        const inputs = ['nip', 'nama', 'jabatan', 'pangkat_golruang', 'fakultas', 'posisi', 'foto'];
        inputs.forEach(inputName => {
            const input = form.querySelector(`[name="${inputName}"]`);
            if (input) {
                const eventType = inputName === 'foto' ? 'change' : 'input';
                input.addEventListener(eventType, function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }
        });

        function tampilkanNotifikasi(pesan, tipe = 'error') {
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
            setTimeout(() => {
                notif.style.animation = 'slide-out 0.3s ease-out';
                setTimeout(() => notif.remove(), 300);
            }, 5000);
        }
    });

    // Modal konfirmasi hapus
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
