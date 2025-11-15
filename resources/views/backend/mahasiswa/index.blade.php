@extends('layouts.main')

@push('styles')
    <style>
        /* Mobile card styles to match pelayanan page */
        .mobile-card-view {
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-card-view {
                display: block !important;
            }
            .desktop-table-view {
                display: none !important;
            }
        }

        #openModalBtn {
            position: relative;
            z-index: 50;
            pointer-events: auto;
        }
        .desktop-table-view {
            position: relative;
            z-index: 0;
        }

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
                    <p class="font-bold">Gagal!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
                <button onclick="closeErrorNotification()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        @endif

       <!-- Card -->
       <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-3 sm:p-6 border border-blue-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 gap-3 sm:gap-0">
                <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-blue-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-graduation-cap text-blue-600"></i> Daftar {{ $title }}
                </h2>

                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto relative z-50">
                    <!-- Form Search -->
                    <form method="GET" action="{{ url('/mahasiswa') }}"
                        class="flex w-full sm:w-auto">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / NIM / Prodi..."
                            class="border border-blue-300 rounded-l-lg px-3 py-2 text-sm w-full sm:w-64 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-r-lg hover:bg-blue-700 transition">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <!-- Tombol Tambah -->
                    <button id="openModalBtn"
                        class="relative z-50 bg-gradient-to-r from-blue-600 to-blue-500 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center gap-2 hover:from-blue-700 hover:to-blue-600 shadow-md transition text-xs sm:text-sm w-full sm:w-auto justify-center">
                        <i class="fa fa-plus"></i> Mahasiswa
                    </button>
                </div>
            </div>

            <div class="desktop-table-view overflow-x-auto rounded-xl border border-blue-200">
                <table class="min-w-full rounded-xl overflow-hidden">
                    <thead class="bg-blue-600 text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 text-center w-12">No</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-[200px]">Nama</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-[150px]">TTL</th>
                            <th class="px-2 sm:px-4 py-3 text-left">Fakultas</th>
                            <th class="px-2 sm:px-4 py-3 text-left">Prodi</th>
                            <th class="px-2 sm:px-4 py-3 text-left">Kontak</th>
                            <th class="px-2 sm:px-4 py-3 text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm bg-white">
                        @forelse ($mahasiswa as $data)
                            <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                                <td class="px-2 sm:px-4 py-3 text-center font-semibold text-blue-600 align-top">
                                    {{ $mahasiswa->firstItem() + $loop->index }}
                                </td>
                                <td class="px-2 sm:px-4 py-3 align-top">
                                    <div class="d-flex flex-column">
                                        <p class="font-bold text-sm">{{ $data->nama }}</p>
                                        <p class="opacity-75 text-xs">NIM: {{ $data->nim }}</p>
                                        <p class="opacity-75 text-xs break-words max-w-[200px]">Alamat: {{ $data->alamat }}</p>
                                    </div>
                                </td>
                                <td class="px-2 sm:px-4 py-3 text-sm align-top">{{ $data->tempat_lahir . ', ' . $data->tgl_lahir }}</td>
                                <td class="px-2 sm:px-4 py-3 text-sm align-top">{{ $data->Fakultas }}</td>
                                <td class="px-2 sm:px-4 py-3 text-sm align-top">{{ $data->Prodi_jurusan }}</td>
                                <td class="px-2 sm:px-4 py-3 align-top">
                                    <div class="text-xs">
                                        <p><i class="fa fa-phone text-blue-600"></i> {{ $data->No_Hp ?? '-' }}</p>
                                        <p><i class="fa fa-envelope text-blue-600"></i> {{ $data->email }}</p>
                                    </div>
                                </td>
                                <td class="px-2 sm:px-4 py-3 text-center align-top">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('mahasiswa.edit', $data->nim) }}"
                                            class="text-yellow-500 hover:text-yellow-600 transition transform hover:scale-110 p-1"
                                            title="Edit">
                                            <i class="fa fa-edit text-sm sm:text-lg"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ route('mahasiswa.delete', $data->nim) }}', '{{ $data->nama }}')"
                                            class="text-red-500 hover:text-red-600 transition transform hover:scale-110 p-1"
                                            title="Hapus">
                                            <i class="fa fa-trash text-sm sm:text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-6 text-gray-500">
                                    <i class="fa fa-inbox text-2xl mb-2 block"></i>
                                    Tidak Ada Data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                @if ($mahasiswa->hasPages())
                    <div class="mt-6 w-full flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-4 text-sm text-gray-700 p-4">
                        <div class="text-center sm:text-left text-gray-600 w-full sm:w-auto">
                            Menampilkan
                            <span class="font-semibold text-blue-600">
                                {{ $mahasiswa->firstItem() }}–{{ $mahasiswa->lastItem() }}
                            </span>
                            dari
                            <span class="font-semibold text-blue-600">{{ $mahasiswa->total() }}</span> data
                        </div>

                        <!-- Tombol Navigasi -->
                        <div class="flex flex-wrap justify-center gap-2 w-full sm:w-auto">
                            {{-- Tombol Previous --}}
                            @if ($mahasiswa->onFirstPage())
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&laquo;</span>
                            @else
                                <a href="{{ $mahasiswa->previousPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">&laquo;</a>
                            @endif

                            {{-- Tombol Halaman --}}
                            @foreach ($mahasiswa->getUrlRange(1, $mahasiswa->lastPage()) as $page => $url)
                                @if ($page == $mahasiswa->currentPage())
                                    <span class="px-3 py-2 bg-blue-600 text-white rounded-lg font-bold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Tombol Next --}}
                            @if ($mahasiswa->hasMorePages())
                                <a href="{{ $mahasiswa->nextPageUrl() }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">&raquo;</a>
                            @else
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&raquo;</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card-view space-y-3">
                @forelse ($mahasiswa as $data)
                    <div class="bg-white rounded-lg border border-blue-200 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ $mahasiswa->firstItem() + $loop->index }}
                                    </span>
                                    <h3 class="font-semibold text-gray-800 text-sm">{{ $data->nama }}</h3>
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>NIM:</strong> {{ $data->nim }}
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>Alamat:</strong>
                                    <div class="mt-1">{{ $data->alamat }}</div>
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>TTL:</strong> {{ $data->tempat_lahir . ', ' . $data->tgl_lahir }}
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>Fakultas:</strong> {{ $data->Fakultas }}
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>Prodi_jurusan:</strong> {{ $data->{'Prodi_jurusan'} }}
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>No HP:</strong> {{ $data->No_Hp ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-600 mb-3">
                                    <strong>Email:</strong> {{ $data->email }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('mahasiswa.edit', $data->nim) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition flex items-center gap-1">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('mahasiswa.delete', $data->nim) }}', '{{ $data->nama }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition flex items-center gap-1">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-blue-200 p-6 text-center text-gray-500">
                        <i class="fa fa-inbox text-3xl mb-2 text-gray-300"></i>
                        <p>Tidak Ada Data</p>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if ($mahasiswa->hasPages())
                    <div class="mt-6">
                        {{ $mahasiswa->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data dengan scroll -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4">
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300 relative"
            id="modalContent">
            <!-- Tombol Close -->
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition z-10">
                <i class="fa fa-times text-lg"></i>
            </button>

            <!-- Header Modal -->
            <div class="sticky top-0 bg-gradient-to-br from-white to-blue-50 pt-6 pb-4 border-b border-blue-200 px-6">
                <h3 class="text-lg sm:text-xl font-bold text-blue-700 flex items-center gap-2">
                    <i class="fa fa-plus-circle text-blue-500"></i> Tambah Mahasiswa
                </h3>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('mahasiswa.store') }}" class="p-4 sm:p-6" id="formMahasiswa">
                @csrf
                <div class="space-y-4">
                    <!-- NIM -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">NIM <span class="text-red-500">*</span></label>
                        <input type="text" name="nim" value="{{ old('nim') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('nim')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Row untuk Tempat dan Tanggal Lahir -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Tempat Lahir -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                            @error('tempat_lahir')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}"
                                class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                            @error('tgl_lahir')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Fakultas -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Fakultas <span class="text-red-500">*</span></label>
                        <input type="text" name="Fakultas" value="{{ old('Fakultas') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('Fakultas')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prodi_jurusan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Prodi_jurusan <span class="text-red-500">*</span></label>
                        <input type="text" name="Prodi_jurusan" value="{{ old('Prodi_jurusan') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('Prodi_jurusan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="alamat"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400" rows="3">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">No HP</label>
                        <input type="text" name="No_Hp" value="{{ old('No_Hp') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('No_Hp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Tombol -->
                <div class="flex flex-col sm:flex-row justify-end gap-2 mt-6 border-t pt-4 sticky bottom-0 bg-gradient-to-br from-white to-blue-50 pb-2">
                    <button type="button" id="closeModalBtn2"
                        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition text-sm w-full sm:w-auto">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transition text-sm w-full sm:w-auto">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative transform scale-95 opacity-0 transition-all duration-300"
            id="deleteModalContent">
            <!-- Icon Warning -->
            <div class="text-center mb-4">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fa fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
            </div>

            <!-- Header Modal -->
            <h3 class="text-xl font-bold mb-2 text-gray-900 text-center">
                Konfirmasi Hapus
            </h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                Apakah Anda yakin ingin menghapus data mahasiswa <strong id="deleteNama" class="text-gray-900"></strong>?
            </p>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button type="button" id="cancelDeleteBtn"
                    class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                    Batal
                </button>
                <a href="#" id="confirmDeleteBtn"
                    class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm font-medium text-center">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>

@push('scripts')
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

        document.addEventListener('DOMContentLoaded', function() {
            const pageKey = window.location.pathname;
            const scrollPosition = localStorage.getItem(`${pageKey}-scroll`);
            const searchQuery = localStorage.getItem(`${pageKey}-search`);

            // Restore posisi scroll
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition));
            }

            window.addEventListener('beforeunload', () => {
                localStorage.setItem(`${pageKey}-scroll`, window.scrollY);
            });

            // Restore input pencarian
            const searchInput = document.querySelector('input[name="q"]');
            if (searchInput) {
                if (searchQuery && !searchInput.value) {
                    searchInput.value = searchQuery;
                }

                searchInput.addEventListener('input', () => {
                    localStorage.setItem(`${pageKey}-search`, searchInput.value);
                });
            }

            // Bersihkan cache jika sudah submit form
            const form = document.getElementById('formMahasiswa');
            if (form) {
                form.addEventListener('submit', () => {
                    localStorage.removeItem(`${pageKey}-scroll`);
                    localStorage.removeItem(`${pageKey}-search`);
                });
            }
        });

        // Auto close notifikasi
        document.addEventListener('DOMContentLoaded', function() {
            const successNotif = document.getElementById('successNotification');
            if (successNotif) {
                setTimeout(() => {
                    closeSuccessNotification();
                }, 5000);
            }

            const errorNotif = document.getElementById('errorNotification');
            if (errorNotif) {
                setTimeout(() => {
                    closeErrorNotification();
                }, 5000);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const closeModalBtn2 = document.getElementById('closeModalBtn2');

            // Cek jika ada error dari Laravel, buka modal otomatis
            @if($errors->any())
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            @endif

            // Buka modal
            openModalBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            });

            // Tutup modal
            function closeModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
                document.body.style.overflow = 'auto';
            }

            closeModalBtn.addEventListener('click', closeModal);
            closeModalBtn2.addEventListener('click', closeModal);

            // Tutup modal ketika klik di luar konten modal
            modal.addEventListener('click', function(e) {
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
            const form = document.getElementById('formMahasiswa');

            // Pesan error dalam bahasa Indonesia
            const pesanError = {
                nim: 'NIM harus diisi',
                nama: 'Nama harus diisi',
                tempat_lahir: 'Tempat lahir harus diisi',
                tgl_lahir: 'Tanggal lahir harus diisi',
                Fakultas: 'Fakultas harus diisi',
                'Prodi_jurusan': 'Prodi_jurusan harus diisi',
                alamat: 'Alamat harus diisi',
                email: 'Email harus diisi dengan format yang benar'
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

                    // Cek apakah field kosong (kecuali No_Hp yang optional)
                    if (!value && fieldName !== 'No_Hp') {
                        tampilkanError(field, pesanError[fieldName]);
                        hasError = true;
                        if (!firstErrorField) firstErrorField = field;
                        return;
                    }

                    // Validasi khusus untuk email
                    if (fieldName === 'email' && value) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(value)) {
                            tampilkanError(field, 'Format email tidak valid');
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

            // Validasi real-time untuk No HP (hanya angka)
            const noHpInput = form.querySelector('[name="No_Hp"]');
            if (noHpInput) {
                noHpInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }
        });

        // Fungsi untuk konfirmasi hapus
        function confirmDelete(url, nama) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteModalContent = document.getElementById('deleteModalContent');
            const deleteNama = document.getElementById('deleteNama');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

            // Set nama dan URL
            deleteNama.textContent = nama;
            confirmDeleteBtn.href = url;

            // Tampilkan modal
            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModalContent.classList.remove('scale-95', 'opacity-0');
                deleteModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';

            // Tutup modal
            function closeDeleteModal() {
                deleteModalContent.classList.remove('scale-100', 'opacity-100');
                deleteModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    deleteModal.classList.add('hidden');
                }, 300);
                document.body.style.overflow = 'auto';
            }

            cancelDeleteBtn.onclick = closeDeleteModal;

            // Tutup modal ketika klik di luar konten modal
            deleteModal.onclick = function(e) {
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            };

            // Close with Escape key
            document.addEventListener('keydown', function escHandler(e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    closeDeleteModal();
                    document.removeEventListener('keydown', escHandler);
                }
            });
        }
    </script>
@endpush
@endsection
