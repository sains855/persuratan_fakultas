@extends('layouts.main_frontend')

@section('content')
    <div style="min-height: 50vh" class="flex flex-col bg-gray-50 pt-6 pb-12">
        <main class="flex-grow flex items-center justify-center">
            <div class="w-full max-w-lg bg-white p-8 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">
                    Edit Data IPK Mahasiswa
                </h2>

                {{-- Flash error & Validation Errors (Anda bisa copy dari view detail Anda) --}}
                @if (session('error'))
                    <div
                        class="auto-hide mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                        <button type="button" onclick="this.closest('.auto-hide').remove()"
                            class="ml-4 text-red-600">✕</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="font-medium text-red-600 mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- End of Flash error & Validation Errors --}}

                <form action="{{ route('pengajuan.updateMahasiswa', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}" method="POST" class="space-y-5">
                    @csrf
                    {{-- Gunakan method POST biasa, karena route updateMahasiswa menggunakan POST --}}

                    <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">
                    <input type="hidden" name="pelayanan_id" value="{{ $pelayanan->id }}">

                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Data Mahasiswa</h3>

                        {{-- Nama Mahasiswa (Readonly) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                            <input type="text" value="{{ $mahasiswa->nama }}" readonly
                                class="mt-2 w-full px-4 py-2 border rounded-lg bg-gray-100">
                        </div>

                        {{-- NIM (Readonly) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600">NIM</label>
                            <input type="text" value="{{ $mahasiswa->nim }}" readonly
                                class="mt-2 w-full px-4 py-2 border rounded-lg bg-gray-100">
                        </div>

                        {{-- IPK --}}
                        <div class="mb-4">
                            <label for="ipk" class="block text-sm font-medium text-gray-600">IPK <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="ipk" id="ipk"
                                value="{{ old('ipk', $mahasiswa->ipk) }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('ipk') border-red-500 @enderror"
                                placeholder="Masukkan IPK (contoh: 3.50)">
                            @error('ipk')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- IPK Terbilang --}}
                        <div class="mb-4">
                            <label for="ipk_terbilang" class="block text-sm font-medium text-gray-600">IPK Terbilang <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="ipk_terbilang" id="ipk_terbilang"
                                value="{{ old('ipk_terbilang', $mahasiswa->ipk_terbilang) }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('ipk_terbilang') border-red-500 @enderror"
                                placeholder="Masukkan IPK Terbilang (contoh: tiga koma lima nol)">
                            @error('ipk_terbilang')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                            <label for="semester" class="block text-sm font-medium text-gray-600">Semester <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="semester" id="semester"
                                value="{{ old('semester', $mahasiswa->semester) }}" required
                                class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('ipk') border-red-500 @enderror"
                                placeholder="Masukkan semester">
                            @error('semester')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                    </div>
                    {{-- Tombol Submit dan Batal --}}
                    <div class="pt-4 flex justify-between space-x-4">
                        <a href="{{ route('pengajuan.detail', ['id' => $pelayanan->id, 'nim' => $mahasiswa->nim]) }}"
                            class="flex-1 text-center bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
