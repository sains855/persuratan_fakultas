@extends('layouts.main')
@push('styles')
    <!-- Tom Select CSS -->
    <link href="/assets/css/tom-select.css" rel="stylesheet">
@endpush

@section('content')
    <div class="mx-auto">
        <!-- Card -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 shadow-xl rounded-2xl p-6 border border-red-200">
            <!-- Form -->
            <form method="POST" action="{{ route('pelayanan.update', $pelayanan->id) }}" id="formPelayanan">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Pelayanan</label>
                    <input type="text" name="nama" value="{{ old('nama', $pelayanan->nama) }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400" disabled>
                    @error('nama')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon', $pelayanan->icon) }}"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400">
                    @error('icon')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi"
                        class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 focus:border-red-400">{{ old('deskripsi', $pelayanan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Persyaratan</label>
                    <select id="persyaratanSelect" name="persyaratan_id[]" multiple>
                        @foreach ($persyaratan as $item)
                            <option value="{{ $item->id }}" @if (collect(old('persyaratan_id', $pelayanan->pelayananPersyaratan->pluck('persyaratan_id') ?? []))->contains(
                                    $item->id)) selected @endif>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('persyaratan_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('pelayanan') }}"
                        class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition">
                        Back
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-red-600 to-red-500 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-600 shadow-md transition">
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
@endsection

@push('scripts')
    <!-- Tom Select JS -->
    <script src="/assets/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi Tom Select
            let tomSelectInstance = new TomSelect("#persyaratanSelect", {
                plugins: ['remove_button'],
                persist: false,
                create: false,
                maxItems: null,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
            });

            const form = document.getElementById('formPelayanan');

            // ============ CEK SESSION SUCCESS DARI LARAVEL ============
            @if(session('success'))
                tampilkanNotifikasi("{{ session('success') }}", 'success');
            @endif

            // ============ VALIDASI FORM DENGAN PESAN BAHASA INDONESIA ============
            const pesanError = {
                icon: 'Icon harus diisi',
                deskripsi: 'Deskripsi harus diisi',
                persyaratan_id: 'Minimal satu persyaratan harus dipilih'
            };

            // Validasi form sebelum submit
            form.addEventListener('submit', function(e) {
                // Reset semua pesan error sebelumnya
                const errorMessages = this.querySelectorAll('.error-message-custom');
                errorMessages.forEach(msg => msg.remove());

                let hasError = false;
                let firstErrorField = null;

                // Validasi Icon
                const iconField = this.querySelector('[name="icon"]');
                if (!iconField.value.trim()) {
                    tampilkanError(iconField, pesanError.icon);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = iconField;
                }

                // Validasi Deskripsi
                const deskripsiField = this.querySelector('[name="deskripsi"]');
                if (!deskripsiField.value.trim()) {
                    tampilkanError(deskripsiField, pesanError.deskripsi);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = deskripsiField;
                }

                // Validasi Persyaratan (minimal 1 dipilih)
                const persyaratanSelect = document.getElementById('persyaratanSelect');
                const selectedValues = tomSelectInstance.getValue();

                if (!selectedValues || selectedValues.length === 0) {
                    tampilkanErrorSelect(persyaratanSelect, pesanError.persyaratan_id);
                    hasError = true;
                    if (!firstErrorField) firstErrorField = persyaratanSelect;
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

            // Fungsi untuk menampilkan pesan error pada input biasa
            function tampilkanError(field, pesan) {
                // Hapus error lama jika ada
                const oldError = field.parentElement.querySelector('.error-message-custom');
                if (oldError) oldError.remove();

                // Tambahkan border merah
                field.classList.add('border-red-500', '!border-red-500');
                field.classList.remove('border-red-300');

                // Buat elemen error baru
                const errorElement = document.createElement('p');
                errorElement.className = 'error-message-custom text-red-500 text-sm mt-1';
                errorElement.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${pesan}`;

                // Sisipkan setelah input field
                field.parentElement.appendChild(errorElement);
            }

            // Fungsi untuk menampilkan pesan error pada Tom Select
            function tampilkanErrorSelect(field, pesan) {
                // Hapus error lama jika ada
                const oldError = field.parentElement.querySelector('.error-message-custom');
                if (oldError) oldError.remove();

                // Tambahkan border merah pada wrapper Tom Select
                const tsControl = field.parentElement.querySelector('.ts-control');
                if (tsControl) {
                    tsControl.style.borderColor = '#ef4444';
                }

                // Buat elemen error baru
                const errorElement = document.createElement('p');
                errorElement.className = 'error-message-custom text-red-500 text-sm mt-1';
                errorElement.innerHTML = `<i class="fa fa-exclamation-circle"></i> ${pesan}`;

                // Sisipkan setelah Tom Select
                field.parentElement.appendChild(errorElement);
            }

            // Hapus error ketika user mulai mengetik/memilih
            const iconInput = form.querySelector('[name="icon"]');
            const deskripsiInput = form.querySelector('[name="deskripsi"]');

            if (iconInput) {
                iconInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            if (deskripsiInput) {
                deskripsiInput.addEventListener('input', function() {
                    this.classList.remove('border-red-500', '!border-red-500');
                    this.classList.add('border-red-300');
                    const errorMsg = this.parentElement.querySelector('.error-message-custom');
                    if (errorMsg) errorMsg.remove();
                });
            }

            // Hapus error ketika user memilih persyaratan
            tomSelectInstance.on('change', function() {
                const persyaratanSelect = document.getElementById('persyaratanSelect');
                const tsControl = persyaratanSelect.parentElement.querySelector('.ts-control');

                if (tsControl) {
                    tsControl.style.borderColor = '';
                }

                const errorMsg = persyaratanSelect.parentElement.querySelector('.error-message-custom');
                if (errorMsg) errorMsg.remove();
            });
        })
    </script>
@endpush
