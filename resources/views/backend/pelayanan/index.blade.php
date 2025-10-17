@extends('layouts.main')

@push('styles')
    <!-- Tom Select CSS -->
    <link href="/assets/css/tom-select.css" rel="stylesheet">
    <style>
        /* Responsive table styles */
        @media (max-width: 1024px) {
            .table-responsive {
                font-size: 12px;
            }
            .table-responsive th,
            .table-responsive td {
                padding: 8px 6px !important;
            }
            .table-responsive .action-buttons {
                flex-direction: column;
                gap: 4px;
            }
        }

        @media (max-width: 768px) {
            .table-responsive {
                display: block;
                white-space: nowrap;
            }
            .table-responsive thead {
                font-size: 10px;
            }
            .table-responsive th,
            .table-responsive td {
                padding: 6px 4px !important;
                min-width: 80px;
            }
            .table-responsive .description-col {
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .table-responsive .requirements-col {
                max-width: 100px;
            }
            .table-responsive .requirements-col span {
                font-size: 9px;
                padding: 2px 4px;
                margin: 1px;
                display: inline-block;
            }
        }

        /* Updated mobile card styles to match persyaratan page */
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
    </style>
@endpush

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
    <div class="mx-auto">
        <!-- Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-3 sm:p-6 border border-blue-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 gap-3 sm:gap-0">
                <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-blue-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-list-alt text-blue-600"></i> Daftar {{ $title }}
                </h2>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto relative z-50">
                    <!-- Search form -->
                    <form method="GET" action="{{ route('pelayanan') }}" class="flex w-full sm:w-auto">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari pelayanan / persyaratan..."
                            class="border border-blue-300 rounded-l-lg px-3 py-2 text-sm w-full sm:w-64 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <button type="submit"
                            class="bg-blue-600 text-white px-3 py-2 rounded-r-lg hover:bg-blue-700 transition">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            {{-- Table Dekstop --}}
            <div class="desktop-table-view overflow-x-auto rounded-xl border border-blue-200">
                <table class="min-w-full rounded-xl overflow-hidden table-responsive">
                    <thead class="bg-blue-600 text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 text-center w-12">No</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-32">Nama Pelayanan</th>
                            <th class="px-2 sm:px-4 py-3 text-left w-16">Icon</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-40">Deskripsi</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-32">Persyaratan</th>
                            <th class="px-2 sm:px-4 py-3 text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm bg-white">
                        @forelse ($pelayanan as $data)
                            <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                                <td class="px-2 sm:px-4 py-3 text-center font-semibold text-blue-600 align-top">
                                    {{ $pelayanan->firstItem() + $loop->index }}
                                </td>
                                <td class="px-2 sm:px-4 py-3 font-medium align-top">{{ $data->nama }}</td>
                                <td class="px-2 sm:px-4 py-3 text-center align-top">{!! $data->icon !!}</td>
                                <td class="px-2 sm:px-4 py-3 description-col align-top" title="{{ $data->deskripsi }}">{{ $data->deskripsi }}</td>
                                <td class="px-2 sm:px-4 py-3 requirements-col align-top">
                                    @foreach ($data->pelayananPersyaratan as $item)
                                        <span class="px-1 sm:px-2 py-1 bg-blue-500 text-white rounded text-xs mr-1 mb-1 inline-block">{{ $item->persyaratan->nama }}</span>
                                    @endforeach
                                </td>
                                <td class="px-2 sm:px-4 py-3 text-center align-top">
                                    <div class="flex justify-center gap-2 action-buttons">
                                        <a href="{{ route('pelayanan.edit', $data->id) }}"
                                            class="text-yellow-500 hover:text-yellow-600 transition transform hover:scale-110 p-1"
                                            title="Edit">
                                            <i class="fa fa-edit text-sm sm:text-lg"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ route('pelayanan.delete', $data->id) }}', '{{ $data->nama }}')"
                                            class="text-red-500 hover:text-red-600 transition transform hover:scale-110 p-1"
                                            title="Hapus">
                                            <i class="fa fa-trash text-sm sm:text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-6 text-gray-500">
                                    <i class="fa fa-inbox text-2xl mb-2 block"></i>
                                    Tidak Ada Data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                @if ($pelayanan->hasPages())
                    <div class="mt-6 w-full flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-4 text-sm text-gray-700">

                        <!-- Info jumlah data -->
                        <div class="text-center sm:text-left text-gray-600 w-full sm:w-auto">
                            Menampilkan
                            <span class="font-semibold text-blue-600">
                                {{ $pelayanan->firstItem() }}–{{ $pelayanan->lastItem() }}
                            </span>
                            dari
                            <span class="font-semibold text-blue-600">{{ $pelayanan->total() }}</span> data
                        </div>

                        <!-- Tombol Navigasi -->
                        <div class="flex flex-wrap justify-center gap-2 w-full sm:w-auto">
                            {{-- Tombol Previous --}}
                            @if ($pelayanan->onFirstPage())
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&laquo;</span>
                            @else
                                <a href="{{ $pelayanan->previousPageUrl() }}"
                                class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">&laquo;</a>
                            @endif

                            {{-- Tombol Halaman --}}
                            @foreach ($pelayanan->getUrlRange(1, $pelayanan->lastPage()) as $page => $url)
                                @if ($page == $pelayanan->currentPage())
                                    <span class="px-3 py-2 bg-blue-600 text-white rounded-lg font-bold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                    class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Tombol Next --}}
                            @if ($pelayanan->hasMorePages())
                                <a href="{{ $pelayanan->nextPageUrl() }}"
                                class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">&raquo;</a>
                            @else
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&raquo;</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Mobile Card View - Updated to match pelayanan style -->
            <div class="mobile-card-view space-y-3">
                @forelse ($pelayanan as $data)
                    <div class="bg-white rounded-lg border border-blue-200 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ $loop->iteration }}
                                    </span>
                                    <h3 class="font-semibold text-gray-800 text-sm">{{ $data->nama }}</h3>
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>Icon:</strong>
                                    <div class="mt-1">{!! $data->icon !!}</div>
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>Deskripsi:</strong>
                                    <div class="mt-1">{{ $data->deskripsi }}</div>
                                </div>

                                <div class="text-xs text-gray-600 mb-3">
                                    <strong>Persyaratan:</strong>
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @foreach ($data->pelayananPersyaratan as $item)
                                            <span class="px-2 py-1 bg-blue-500 text-white rounded text-xs">{{ $item->persyaratan->nama }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('pelayanan.edit', $data->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition flex items-center gap-1">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('pelayanan.delete', $data->id) }}', '{{ $data->nama }}')"
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
                    @if ($pelayanan->hasPages())
                        <div class="mt-6">
                            {{ $pelayanan->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
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
                Apakah Anda yakin ingin menghapus pelayanan <strong id="deleteName" class="text-gray-900"></strong>?
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
@endsection


@push('scripts')
    <!-- Tom Select JS -->
    <script src="/assets/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize TomSelect
            new TomSelect("#persyaratanSelect", {
                plugins: ['remove_button'],
                persist: false,
                create: false,
                maxItems: null,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
            });

            // Modal functionality
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const closeModalBtn2 = document.getElementById('closeModalBtn2');

            function openModal() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
                document.body.style.overflow = 'auto';
            }

            openModalBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            closeModalBtn2.addEventListener('click', closeModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });

        // Delete confirmation functionality
        function confirmDelete(url, name) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteModalContent = document.getElementById('deleteModalContent');
            const deleteName = document.getElementById('deleteName');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

            deleteName.textContent = name;
            confirmDeleteBtn.href = url;

            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModalContent.classList.remove('scale-95', 'opacity-0');
                deleteModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';

            function closeDeleteModal() {
                deleteModalContent.classList.remove('scale-100', 'opacity-100');
                deleteModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    deleteModal.classList.add('hidden');
                }, 300);
                document.body.style.overflow = 'auto';
            }

            cancelDeleteBtn.onclick = closeDeleteModal;

            deleteModal.onclick = function(e) {
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            };

            document.addEventListener('keydown', function escHandler(e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    closeDeleteModal();
                    document.removeEventListener('keydown', escHandler);
                }
            });
        }

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

    </script>
@endpush
