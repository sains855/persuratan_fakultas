@extends('layouts.main')

@section('content')
    <div class="mx-auto">
        <!-- Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-6 border border-blue-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                <h2 class="text-lg sm:text-xl lg:text-2xl font-extrabold text-blue-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-edit text-blue-600"></i> Edit Berita
                </h2>
                <a href="{{ route('berita') }}"
                    class="bg-gradient-to-r from-gray-600 to-gray-500 text-white px-3 py-2 rounded-lg flex items-center gap-2 hover:from-gray-700 hover:to-gray-600 shadow-md transition text-sm w-full sm:w-auto justify-center sm:justify-start">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Form Edit -->
            <div class="bg-white rounded-xl p-6 shadow-md">
                <form method="POST" action="{{ route('berita.update', $berita->id) }}" enctype="multipart/form-data" id="formBerita">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Judul Berita</label>
                        <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm">
                        @error('judul')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Deskripsi</label>
                        <textarea id="editor" name="deskripsi" rows="4"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm resize-vertical">{{ old('deskripsi', $berita->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Thumbnail</label>

                        @if($berita->thumbnail)
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-2">Thumbnail saat ini:</p>
                                <img src="{{ asset($berita->thumbnail) }}" alt="Current thumbnail"
                                    class="w-32 h-32 object-cover rounded-lg shadow border border-gray-200">
                            </div>
                        @endif

                        <input type="file" name="thumbnail"
                            class="w-full border border-blue-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah thumbnail</p>
                        @error('thumbnail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-2 mt-6">
                        <a href="{{ route('berita') }}"
                            class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition text-sm text-center order-2 sm:order-1">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-600 shadow-md transition text-sm order-1 sm:order-2">
                            <i class="fa fa-save"></i> Update
                        </button>
                    </div>
                </form>
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

            // Inisialisasi editor saat halaman dimuat
            initEditor();

            const form = document.getElementById('formBerita');

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
    </script>
@endsection
