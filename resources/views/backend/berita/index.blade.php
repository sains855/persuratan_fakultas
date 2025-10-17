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

    <div class="mx-auto">
        <!-- Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-6 border border-blue-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-blue-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-newspaper text-blue-600"></i> Daftar {{ $title }}
                </h2>
                <button id="openModalBtn"
                    class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-3 py-2 rounded-lg flex items-center gap-2 hover:from-blue-700 hover:to-blue-600 shadow-md transition text-sm w-full sm:w-auto justify-center sm:justify-start">
                    <i class="fa fa-plus"></i> Berita
                </button>
            </div>
            {{-- Table Dekstop --}}
            <div class="hidden lg:block overflow-x-auto rounded-xl border border-blue-200">
                <table class="min-w-full rounded-xl overflow-hidden">
                    <thead class="bg-blue-600 text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Deskripsi</th>
                            <th class="px-4 py-3 text-center">Thumbnail</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm bg-white">
                        @forelse ($berita as $data)
                            <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                                <td class="px-4 py-3 text-center font-semibold text-blue-600 align-top">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 align-top">{{ $data->judul }}</td>
                                <td class="px-4 py-3 align-top">{!! Str::limit($data->deskripsi, 80) !!}</td>
                                <td class="px-4 py-3 text-center align-top">
                                    @if ($data->thumbnail)
                                        <img src="{{ asset($data->thumbnail) }}" alt="thumb"
                                            class="w-16 h-16 object-cover rounded-lg mx-auto shadow">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 align-top">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="{{ route('berita.edit', $data->id) }}"
                                            class="text-yellow-500 hover:text-yellow-600 transition transform hover:scale-110"
                                            title="Edit">
                                            <i class="fa fa-edit text-lg"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ route('berita.delete', $data->id) }}', '{{ $data->judul }}')"
                                            class="text-red-500 hover:text-red-600 transition transform hover:scale-110"
                                            title="Hapus">
                                            <i class="fa fa-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-6 text-gray-500">
                                    <i class="fa fa-inbox text-2xl mb-2 block"></i>
                                    Tidak ada data berita
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View - Matching pelayanan style -->
            <div class="lg:hidden space-y-3">
                @forelse ($berita as $data)
                    <div class="bg-white rounded-lg border border-blue-200 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                        {{ $loop->iteration }}
                                    </span>
                                    <h3 class="font-semibold text-gray-800 text-sm">{{ $data->judul }}</h3>
                                </div>

                                <div class="text-xs text-gray-600 mb-2">
                                    <strong>Deskripsi:</strong>
                                    <div class="mt-1">{!! Str::limit($data->deskripsi, 100) !!}</div>
                                </div>

                                @if ($data->thumbnail)
                                    <div class="text-xs text-gray-600 mb-3">
                                        <strong>Thumbnail:</strong>
                                        <div class="mt-1">
                                            <img src="{{ asset($data->thumbnail) }}" alt="thumb"
                                                class="w-full max-w-[200px] h-32 object-cover rounded-lg shadow">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('berita.edit', $data->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition flex items-center gap-1">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('berita.delete', $data->id) }}', '{{ $data->judul }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition flex items-center gap-1">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-blue-200 p-6 text-center text-gray-500">
                        <i class="fa fa-inbox text-3xl mb-2 text-gray-300"></i>
                        <p>Tidak ada data berita</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Tambah Berita -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] overflow-y-auto"
            id="modalContent">
            <!-- Tombol Close -->
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition">
                <i class="fa fa-times text-lg"></i>
            </button>

            <!-- Header Modal -->
            <h3 class="text-xl font-bold mb-5 text-blue-700 flex items-center gap-2 pr-8">
                <i class="fa fa-plus-circle text-blue-500"></i> Tambah Berita
            </h3>

            <!-- Form -->
            <form method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data" id="formBerita">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Judul Berita</label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm">
                    @error('judul')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Deskripsi</label>
                    <textarea id="editor" name="deskripsi" rows="4"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm resize-vertical">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Thumbnail</label>
                    <input type="file" name="thumbnail"
                        class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm"
                        accept="image/*">
                    @error('thumbnail')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fa fa-exclamation-triangle text-red-500 text-3xl"></i>
                </div>
            </div>

            <!-- Header Modal -->
            <h3 class="text-xl font-bold mb-3 text-gray-800 text-center">
                Konfirmasi Hapus
            </h3>

            <!-- Message -->
            <p class="text-gray-600 text-center mb-6">
                Apakah Anda yakin ingin menghapus berita<br>
                <strong id="deleteItemName" class="text-gray-800"></strong>?
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button type="button" id="cancelDeleteBtn"
                    class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500 transition text-sm">
                    Batal
                </button>
                <a id="confirmDeleteBtn" href="#"
                    class="bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-2 rounded-lg hover:from-red-700 hover:to-red-600 shadow-md transition text-sm text-center">
                    <i class="fa fa-trash"></i> Hapus
                </a>
            </div>
        </div>
    </div>

    <!-- TinyMCE CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

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
            // Inisialisasi TinyMCE
            let editorInstance = null;

            function initEditor() {
                if (editorInstance) {
                    tinymce.remove('#editor');
                }

                tinymce.init({
                    selector: '#editor',
                    height: 300,
                    menubar: false,
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'help', 'wordcount'
                    ],
                    toolbar: 'undo redo | blocks | ' +
                        'bold italic forecolor backcolor | alignleft aligncenter ' +
                        'alignright alignjustify | bullist numlist outdent indent | ' +
                        'removeformat | help',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                    skin: 'oxide',
                    content_css: 'default',
                    language: 'id',
                    branding: false,
                    setup: function(editor) {
                        editorInstance = editor;

                        // Hapus error ketika user mengetik di TinyMCE
                        editor.on('keyup change', function() {
                            const deskripsiField = document.querySelector('[name="deskripsi"]');
                            if (deskripsiField) {
                                deskripsiField.classList.remove('border-red-500', '!border-red-500');
                                deskripsiField.classList.add('border-blue-300');
                                const errorMsg = deskripsiField.parentElement.querySelector('.error-message-custom');
                                if (errorMsg) errorMsg.remove();
                            }
                        });
                    }
                });
            }

            // Modal Tambah Berita
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const closeModalBtn2 = document.getElementById('closeModalBtn2');
            const form = document.getElementById('formBerita');

            // Cek jika ada error dari Laravel, buka modal otomatis
            @if($errors->any())
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                    initEditor();
                }, 10);
                document.body.style.overflow = 'hidden';
            @endif

            openModalBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                    // Inisialisasi editor ketika modal dibuka
                    initEditor();
                }, 10);
                document.body.style.overflow = 'hidden';
            });

            function closeModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    // Hapus instance editor ketika modal ditutup
                    if (editorInstance) {
                        tinymce.remove('#editor');
                        editorInstance = null;
                    }
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
                judul: 'Judul berita harus diisi',
                deskripsi: 'Deskripsi harus diisi',
                thumbnail: 'Thumbnail harus diupload (format: JPG, PNG, JPEG, GIF, max: 2MB)'
            };

            // Validasi form sebelum submit
            form.addEventListener('submit', function(e) {
                // Reset semua pesan error sebelumnya
                const errorMessages = this.querySelectorAll('.error-message-custom');
                errorMessages.forEach(msg => msg.remove());

                let hasError = false;
                let firstErrorField = null;

                // Validasi Judul
                const judulField = this.querySelector('[name="judul"]');
                if (!judulField.value.trim()) {
                    tampilkanError(judulField, pesanError.judul);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = judulField;
                }

                // Validasi Deskripsi (TinyMCE)
                if (editorInstance) {
                    const deskripsiContent = editorInstance.getContent({format: 'text'}).trim();
                    const deskripsiField = this.querySelector('[name="deskripsi"]');

                    if (!deskripsiContent) {
                        tampilkanError(deskripsiField, pesanError.deskripsi);
                        hasError = true;
                        if (!firstErrorField) firstErrorField = deskripsiField;
                    }
                }

                // Validasi Thumbnail (opsional, hanya jika ada file yang dipilih)
                const thumbnailField = this.querySelector('[name="thumbnail"]');
                if (thumbnailField.files.length > 0) {
                    const file = thumbnailField.files[0];
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!allowedTypes.includes(file.type)) {
                        tampilkanError(thumbnailField, 'Format file harus JPG, PNG, JPEG, atau GIF');
                        hasError = true;
                        if (!firstErrorField) firstErrorField = thumbnailField;
                    } else if (file.size > maxSize) {
                        tampilkanError(thumbnailField, 'Ukuran file maksimal 2MB');
                        hasError = true;
                        if (!firstErrorField) firstErrorField = thumbnailField;
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
                errorElement.className = 'error-message-custom text-red-500 text-sm mt-1';
                errorElement.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${pesan}`;

                // Sisipkan setelah input field
                field.parentElement.appendChild(errorElement);
            }

            // Hapus error ketika user mulai mengetik/memilih
            const judulInput = form.querySelector('[name="judul"]');
            const thumbnailInput = form.querySelector('[name="thumbnail"]');

            if (judulInput) {
                judulInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-blue-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (thumbnailInput) {
                thumbnailInput.addEventListener('change', function() {
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

        // Modal Konfirmasi Hapus
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteItemName = document.getElementById('deleteItemName');

        function confirmDelete(url, itemName) {
            deleteItemName.textContent = itemName;
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
