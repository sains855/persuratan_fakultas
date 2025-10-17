@extends('layouts.main')

@section('content')
    <div class="mx-auto">

        <!-- Notifikasi Pop-up Sukses -->
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

        <!-- Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-3 sm:p-6 border border-blue-200">
           <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-blue-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-list-alt text-blue-600"></i> Daftar {{ $title }}
                </h2>

                <div class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                    <!-- Form Search -->
                    <form method="GET" action="{{ url('/persyaratan') }}" class="flex items-center border rounded-lg overflow-hidden w-full sm:w-auto">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / keterangan..."
                            class="px-3 py-2 text-sm focus:outline-none w-full sm:w-48">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-2">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <!-- Tombol Tambah -->
                    <button id="openModalBtn"
                        class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-3 py-2 rounded-lg flex items-center gap-2 hover:from-blue-700 hover:to-blue-600 shadow-md transition text-xs sm:text-sm w-full sm:w-auto justify-center">
                        <i class="fa fa-plus"></i> <span>Tambah Persyaratan</span>
                    </button>
                </div>
            </div>
            {{-- Table Dekstop --}}
            <div class="hidden md:block overflow-x-auto rounded-xl border border-blue-200">
                <table class="min-w-full rounded-xl overflow-hidden">
                    <thead class="bg-blue-600 text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Keterangan</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm bg-white">
                        @forelse ($persyaratan as $data)
                            <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                                <td class="px-2 sm:px-4 py-3 text-center font-semibold text-blue-600 align-top">
                                    {{ $persyaratan->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 align-top">{{ $data->nama }}</td>
                                <td class="px-4 py-3 align-top">{!! $data->keterangan !!}</td>
                                <td class="px-4 py-3 text-center align-top">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('persyaratan.edit', $data->id) }}"
                                            class="text-yellow-500 hover:text-yellow-600 transition transform hover:scale-110"
                                            title="Edit">
                                            <i class="fa fa-edit text-lg"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ route('persyaratan.delete', $data->id) }}', '{{ $data->nama }}')"
                                            class="text-red-500 hover:text-red-600 transition transform hover:scale-110"
                                            title="Hapus">
                                            <i class="fa fa-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-6 text-gray-500">
                                    <i class="fa fa-inbox text-2xl mb-2 block"></i>
                                    Tidak Ada Data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if ($persyaratan->hasPages())
                    <div class="mt-6 flex flex-col sm:flex-row justify-center sm:justify-between items-center text-sm text-gray-700 gap-4">
                        <div class="text-gray-600">
                            Menampilkan
                            <span class="font-semibold text-blue-600">
                                {{ $persyaratan->firstItem() }}–{{ $persyaratan->lastItem() }}
                            </span>
                            dari
                            <span class="font-semibold text-blue-600">{{ $persyaratan->total() }}</span> data
                        </div>

                        <!-- Tombol Navigasi -->
                        <div class="flex items-center justify-center space-x-2">
                            {{-- Tombol Previous --}}
                            @if ($persyaratan->onFirstPage())
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&laquo;</span>
                            @else
                                <a href="{{ $persyaratan->previousPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">&laquo;</a>
                            @endif

                            {{-- Tombol Halaman --}}
                            @foreach ($persyaratan->getUrlRange(1, $persyaratan->lastPage()) as $page => $url)
                                @if ($page == $persyaratan->currentPage())
                                    <span class="px-3 py-2 bg-blue-600 text-white rounded-lg font-bold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Tombol Next --}}
                            @if ($persyaratan->hasMorePages())
                                <a href="{{ $persyaratan->nextPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">&raquo;</a>
                            @else
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&raquo;</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

           <!-- Tabel Mobile (Card Layout) -->
            <div class="block md:hidden space-y-3">
                @forelse ($persyaratan as $data)
                    <div class="bg-white rounded-lg border border-blue-200 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <!-- Nomor urut tetap berlanjut di setiap halaman -->
                                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ $loop->iteration + ($persyaratan->currentPage() - 1) * $persyaratan->perPage() }}
                                    </span>
                                    <h3 class="font-semibold text-gray-800 text-sm">{{ $data->nama }}</h3>
                                </div>
                                <div class="text-xs text-gray-600 mb-3">
                                    <strong>Keterangan:</strong>
                                    <div class="mt-1">{!! $data->keterangan !!}</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('persyaratan.edit', $data->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition flex items-center gap-1">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('persyaratan.delete', $data->id) }}', '{{ $data->nama }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition flex items-center gap-1">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-blue-200 p-6 text-center text-gray-500">
                        <i class="fa fa-inbox text-3xl mb-2 text-gray-300"></i>
                        <p>Tidak Ada data</p>
                    </div>
                @endforelse
            <!-- Pagination -->
                @if ($persyaratan->hasPages())
                    <div class="mt-6">
                        {{ $persyaratan->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>
        </div>

    <!-- Modal Tambah Data -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-2xl w-full max-w-md p-4 sm:p-6 relative transform scale-95 opacity-0 transition-all duration-300"
            id="modalContent">
            <!-- Tombol Close -->
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition">
                <i class="fa fa-times text-lg"></i>
            </button>

            <!-- Header Modal -->
            <h3 class="text-lg sm:text-xl font-bold mb-5 text-blue-700 flex items-center gap-2 pr-8">
                <i class="fa fa-plus-circle text-blue-500"></i> Tambah Persyaratan
            </h3>

            <!-- Form -->
            <form method="POST" action="{{ route('persyaratan.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Persyaratan<span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Keterangan<span class="text-red-500">*</span></label>
                    <textarea name="keterangan" rows="3"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 resize-vertical">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-2 mt-6">
                    <button type="button" id="closeModalBtn2"
                        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition text-sm order-2 sm:order-1">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transition text-sm order-1 sm:order-2">
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
                <div class="bg-red-100 rounded-full p-4">
                    <i class="fa fa-exclamation-triangle text-red-500 text-4xl"></i>
                </div>
            </div>

            <!-- Header Modal -->
            <h3 class="text-xl font-bold mb-2 text-gray-800 text-center">
                Konfirmasi Hapus
            </h3>
            <p class="text-gray-600 text-center mb-6">
                Apakah Anda yakin ingin menghapus persyaratan <strong id="deleteItemName"></strong>?
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button type="button" id="cancelDeleteBtn"
                    class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500 transition text-sm">
                    <i class="fa fa-times"></i> Batal
                </button>
                <a id="confirmDeleteBtn" href="#"
                    class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition text-sm text-center">
                    <i class="fa fa-trash"></i> Ya, Hapus
                </a>
            </div>
        </div>
    </div>

    <style>
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slide-out {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
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
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modalContent');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalBtn2 = document.getElementById('closeModalBtn2');
        const form = modal.querySelector('form');

        // Buka modal jika ada error Laravel
        @if ($errors->any())
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        @endif

        // Buka modal secara manual
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
            if (e.target === modal) closeModal();
        });

        // Tutup dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
        });

        // Validasi sederhana seperti di halaman berita
        form.addEventListener('submit', function(e) {
            const nama = form.querySelector('[name="nama"]');
            const ket = form.querySelector('[name="keterangan"]');

            let hasError = false;
            let firstError = null;

            // hapus pesan error lama
            form.querySelectorAll('.error-message-custom').forEach(m => m.remove());

            if (!nama.value.trim()) {
                tampilkanError(nama, 'Nama persyaratan harus diisi');
                hasError = true;
                if (!firstError) firstError = nama;
            }

            if (!ket.value.trim()) {
                tampilkanError(ket, 'Keterangan harus diisi');
                hasError = true;
                if (!firstError) firstError = ket;
            }

            if (hasError) {
                e.preventDefault();
                tampilkanNotifikasi('Mohon lengkapi semua field yang wajib diisi dengan benar', 'error');
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        });

        function tampilkanError(field, pesan) {
            const old = field.parentElement.querySelector('.error-message-custom');
            if (old) old.remove();
            field.classList.add('border-red-500', '!border-red-500');
            field.classList.remove('border-blue-300');

            const err = document.createElement('p');
            err.className = 'error-message-custom text-red-500 text-sm mt-1';
            err.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${pesan}`;
            field.parentElement.appendChild(err);
        }

        // Hapus error ketika user mengetik
        form.querySelectorAll('input, textarea').forEach(el => {
            el.addEventListener('input', () => {
                el.classList.remove('border-red-500', '!border-red-500');
                el.classList.add('border-blue-300');
                const msg = el.parentElement.querySelector('.error-message-custom');
                if (msg) msg.remove();
            });
        });

        // Fungsi notifikasi sama seperti modal berita
        function tampilkanNotifikasi(pesan, tipe = 'error') {
            const oldNotif = document.querySelector('.notifikasi-custom');
            if (oldNotif) oldNotif.remove();

            const notif = document.createElement('div');
            notif.className = 'notifikasi-custom fixed top-4 right-4 px-6 py-4 rounded-lg shadow-2xl z-[10000] animate-slide-in max-w-md';
            if (tipe === 'error') {
                notif.classList.add('bg-red-500', 'text-white');
                notif.innerHTML = `<div class="flex items-center gap-3">
                    <i class="fa fa-exclamation-circle text-xl"></i>
                    <span class="font-medium">${pesan}</span></div>`;
            } else {
                notif.classList.add('bg-green-500', 'text-white');
                notif.innerHTML = `<div class="flex items-center gap-3">
                    <i class="fa fa-check-circle text-xl"></i>
                    <span class="font-medium">${pesan}</span></div>`;
            }
            document.body.appendChild(notif);
            setTimeout(() => {
                notif.style.animation = 'slide-out 0.3s ease-out';
                setTimeout(() => notif.remove(), 300);
            }, 5000);
        }
    });

    // Modal Konfirmasi Hapus
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteItemName = document.getElementById('deleteItemName');

    function confirmDelete(url, nama) {
        deleteItemName.textContent = nama;
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
