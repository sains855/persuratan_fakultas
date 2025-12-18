@extends('layouts.main')

@push('styles')
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
            .table-responsive .keterangan-col {
                max-width: 150px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }

        /* Mobile Card View styles */
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
    </style>
@endpush

@section('content')

    {{-- Success Notification --}}
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
        <div class="bg-gradient-to-br from-red-50 to-red-100 shadow-xl rounded-2xl p-3 sm:p-6 border border-red-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 gap-3 sm:gap-0">
                <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-red-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-graduation-cap text-red-600"></i> Daftar {{ $title }}
                </h2>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto relative z-50">
                    <form method="GET" action="{{ route('keterangan_beasiswa.index') }}" class="flex w-full sm:w-auto">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari NIM / Status / Keterangan..."
                            class="border border-red-300 rounded-l-lg px-3 py-2 text-sm w-full sm:w-64 focus:ring-2 focus:ring-red-400 focus:border-red-400">
                        <button type="submit"
                            class="bg-red-600 text-white px-3 py-2 rounded-r-lg hover:bg-red-700 transition">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table Dekstop --}}
            <div class="desktop-table-view overflow-x-auto rounded-xl border border-red-200">
                <table class="min-w-full rounded-xl overflow-hidden table-responsive">
                    <thead class="bg-red-600 text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 text-center w-12">No</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-32">NIM Mahasiswa</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-40">Status Beasiswa</th>
                            <th class="px-2 sm:px-4 py-3 text-left min-w-40">Keterangan</th>
                            <th class="px-2 sm:px-4 py-3 text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm bg-white">
                        @forelse ($beasiswa as $data)
                            <tr class="border-b border-gray-200 hover:bg-red-50 transition">
                                <td class="px-2 sm:px-4 py-3 text-center font-semibold text-red-600 align-top">
                                    {{ $beasiswa->firstItem() + $loop->index }}
                                </td>
                                <td class="px-2 sm:px-4 py-3 font-medium align-top">{{ $data->mahasiswa_nim }}</td>
                                <td class="px-2 sm:px-4 py-3 align-top">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($data->status_beasiswa == 'Aktif')
                                            bg-green-500 text-white
                                        @elseif($data->status_beasiswa == 'Nonaktif')
                                            bg-red-500 text-white
                                        @else
                                            bg-yellow-500 text-white
                                        @endif
                                    ">
                                        {{ $data->status_beasiswa }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-4 py-3 keterangan-col align-top" title="{{ $data->keterangan_beasiswa }}">
                                    {{ $data->keterangan_beasiswa }}
                                </td>
                                <td class="px-2 sm:px-4 py-3 text-center align-top">
                                    <div class="flex justify-center gap-2 action-buttons">
                                        <button onclick="confirmDelete('{{ route('keterangan_beasiswa.delete', $data->id) }}', '{{ $data->mahasiswa_nim }}')"
                                            class="text-red-500 hover:text-red-600 transition transform hover:scale-110 p-1"
                                            title="Hapus">
                                            <i class="fa fa-trash text-sm sm:text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-6 text-gray-500">
                                    <i class="fa fa-inbox text-2xl mb-2 block"></i>
                                    Tidak Ada Data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($beasiswa->hasPages())
                    <div class="mt-6 w-full flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-4 text-sm text-gray-700">

                        <div class="text-center sm:text-left text-gray-600 w-full sm:w-auto">
                            Menampilkan
                            <span class="font-semibold text-red-600">
                                {{ $beasiswa->firstItem() }}–{{ $beasiswa->lastItem() }}
                            </span>
                            dari
                            <span class="font-semibold text-red-600">{{ $beasiswa->total() }}</span> data
                        </div>

                        <div class="flex flex-wrap justify-center gap-2 w-full sm:w-auto">
                            {{-- Tombol Previous --}}
                            @if ($beasiswa->onFirstPage())
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&laquo;</span>
                            @else
                                <a href="{{ $beasiswa->previousPageUrl() }}"
                                class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">&laquo;</a>
                            @endif

                            {{-- Tombol Halaman --}}
                            @foreach ($beasiswa->getUrlRange(1, $beasiswa->lastPage()) as $page => $url)
                                @if ($page == $beasiswa->currentPage())
                                    <span class="px-3 py-2 bg-red-600 text-white rounded-lg font-bold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                    class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Tombol Next --}}
                            @if ($beasiswa->hasMorePages())
                                <a href="{{ $beasiswa->nextPageUrl() }}"
                                class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">&raquo;</a>
                            @else
                                <span class="px-3 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">&raquo;</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="mobile-card-view space-y-3">
                @forelse ($beasiswa as $data)
                    <div class="bg-white rounded-lg border border-red-200 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ $loop->iteration }}
                                    </span>
                                    <h3 class="font-semibold text-gray-800 text-sm">NIM: {{ $data->mahasiswa_nim }}</h3>
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>Status Beasiswa:</strong>
                                    <div class="mt-1">
                                         <span class="px-2 py-1 rounded text-xs font-semibold
                                            @if($data->status_beasiswa == 'Aktif')
                                                bg-green-500 text-white
                                            @elseif($data->status_beasiswa == 'Nonaktif')
                                                bg-red-500 text-white
                                            @else
                                                bg-yellow-500 text-white
                                            @endif
                                        ">
                                            {{ $data->status_beasiswa }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-xs text-gray-600 mb-3">
                                    <strong>Keterangan:</strong>
                                    <div class="mt-1">{{ $data->keterangan_beasiswa }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('keterangan_beasiswa.edit', $data->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition flex items-center gap-1">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('keterangan_beasiswa.delete', $data->id) }}', '{{ $data->mahasiswa_nim }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition flex items-center gap-1">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-red-200 p-6 text-center text-gray-500">
                        <i class="fa fa-inbox text-3xl mb-2 text-gray-300"></i>
                        <p>Tidak Ada Data</p>
                    </div>
                @endforelse

                @if ($beasiswa->hasPages())
                    <div class="mt-6">
                        {{ $beasiswa->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative transform scale-95 opacity-0 transition-all duration-300"
            id="deleteModalContent">
            <div class="text-center mb-4">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fa fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
            </div>

            <h3 class="text-xl font-bold mb-2 text-gray-900 text-center">
                Konfirmasi Hapus
            </h3>
            <p class="text-sm text-gray-500 text-center mb-6">
                Apakah Anda yakin ingin menghapus keterangan beasiswa untuk NIM <strong id="deleteName" class="text-gray-900"></strong>?
            </p>

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

    {{-- Asumsi Anda memiliki modal untuk Tambah Data di bagian lain --}}
    {{-- <div id="modal" class="hidden fixed inset-0...">...</div> --}}

@endsection


@push('scripts')
    <script>
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
        window.closeSuccessNotification = function() {
            const notif = document.getElementById('successNotification');
            if (notif) {
                // Asumsi ada CSS animation 'slide-out'
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
