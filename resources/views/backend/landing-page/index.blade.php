@extends('layouts.main')

@section('content')

<script>
    setTimeout(() => {
        document.querySelectorAll('[role="alert"]').forEach(el => el.remove());
    }, 4000); // hilang setelah 4 detik
</script>

{{-- Alert Sukses --}}
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

{{-- Alert Error --}}
@if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

{{-- Alert Validasi (Jika ada error pada input) --}}
@if ($errors->any())
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Perhatian!</strong>
        <ul class="list-disc pl-5 mt-2 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="p-6 bg-blue-50 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-700 text-center">Manajemen Landing Page</h2>

    <!-- Tambahkan enctype agar bisa upload file -->
    <form action="{{ route('landing-page.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $landingPage->id ?? '' }}">

        <!-- Nama Instansi -->
        <div class="mb-4">
            <label class="font-semibold">Nama Instansi</label>
            <input type="text" name="nama_instansi"
                value="{{ old('nama_instansi', $landingPage->nama_instansi ?? '') }}"
                class="w-full border border-blue-300 rounded-md p-2">
        </div>

        <!-- Slogan -->
        <div class="mb-4">
            <label class="font-semibold">Slogan</label>
            <input type="text" name="slogan"
                value="{{ old('slogan', $landingPage->slogan ?? '') }}"
                class="w-full border border-blue-300 rounded-md p-2">
        </div>

        <!-- 📸 Gambar Utama -->
        <div class="mb-6">
            <label class="font-semibold block mb-2">Gambar Utama Landing Page</label>

            <!-- Preview gambar saat ini -->
            @if (!empty($landingPage->gambar_utama))
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $landingPage->gambar_utama) }}" 
                         alt="Gambar Utama" 
                         class="w-full max-h-64 object-cover rounded-md border border-blue-200 shadow-sm">
                </div>
            @endif

            <!-- Input file -->
            <input type="file" name="gambar_utama" 
                   class="w-full border border-blue-300 rounded-md p-2 bg-white cursor-pointer">

            <p class="text-sm text-gray-500 mt-2">
                Format gambar: JPG, PNG, JPEG | Maksimal 2 MB
            </p>
        </div>

        <!-- Deskripsi / Sejarah -->
        <div class="mb-4">
            <label class="font-semibold">Deskripsi / Sejarah</label>
            <textarea id="editorDeskripsi" name="deskripsi" rows="10"
            class="w-full border border-blue-300 rounded-md p-2">{{ old('deskripsi', $landingPage->deskripsi ?? '') }}</textarea>
        </div>

        <!-- Visi -->
        <div class="mb-4">
            <label class="font-semibold">Visi</label>
            <textarea id="editorVisi" name="visi" rows="6"
            class="w-full border border-blue-300 rounded-md p-2">{{ old('visi', $landingPage->visi ?? '') }}</textarea>
        </div>

        <!-- Misi -->
        <div class="mb-4">
            <label class="font-semibold">Misi</label>
            <textarea id="editorMisi" name="misi" rows="6"
            class="w-full border border-blue-300 rounded-md p-2">{{ old('misi', $landingPage->misi ?? '') }}</textarea>
        </div>

        <!-- Kontak & Alamat -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">Alamat</label>
                <input type="text" name="alamat"
                value="{{ old('alamat', $landingPage->alamat ?? '') }}"
                class="w-full border border-blue-300 rounded-md p-2">
            </div>
            
            <div>
                <label class="font-semibold">Koordinat (Maps)</label>
                <input type="text" name="koordinat"
                value="{{ old('koordinat', $landingPage->koordinat ?? '') }}"
                class="w-full border border-blue-300 rounded-md p-2">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
           <div>
                <label class="font-semibold">Telepon</label>
                <input 
                    type="text" 
                    name="telpon"
                    value="{{ old('telpon', $landingPage->telpon ?? '') }}"
                    class="w-full border border-blue-300 rounded-md p-2"
                    maxlength="12" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    placeholder="Maksimal 12 digit angka"
                >
            </div>
 
            <div>
                <label class="font-semibold">Waktu Pelayanan</label>
                <input type="text" name="waktu_pelayanan"
                value="{{ old('waktu_pelayanan', $landingPage->waktu_pelayanan ?? '') }}"
                class="w-full border border-blue-300 rounded-md p-2">
            </div>
        </div>
        
        <!-- email -->
        <div class="mb-4">
            <label class="font-semibold">Email</label>
            <input type="text" name="email"
                value="{{ old('email', $landingPage->email ?? '') }}"
                class="w-full border border-blue-300 rounded-md p-2">
        </div>

        <!-- Tombol Simpan -->
        <div class="mt-6 text-center">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>

<!-- TinyMCE -->
<script src="/assets/js/tinymce.min.js"></script>

<script>
    function initTiny(selector) {
        tinymce.init({
            selector: selector,
            height: 300,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic forecolor backcolor | ' +
                'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            skin: 'oxide',
            content_css: 'default',
            language: 'id',
            branding: false
        });
    }

    // Inisialisasi untuk semua editor
    initTiny('#editorDeskripsi');
    initTiny('#editorVisi');
    initTiny('#editorMisi');
</script>
@endsection
