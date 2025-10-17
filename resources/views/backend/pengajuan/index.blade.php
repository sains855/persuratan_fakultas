@extends('layouts.main')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Pengajuan Surat Masuk</h2>

        <div class="mb-6 bg-white p-4 rounded-lg shadow">
            <form action="{{ route('permohonan.index') }}" method="GET">
                <label for="id_pelayanan" class="block text-sm font-medium text-gray-700">Filter Berdasarkan Layanan:</label>
                <div class="mt-1 flex items-center gap-2">
                    <select name="id_pelayanan" id="id_pelayanan" class="flex-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">-- Tampilkan Semua --</option>
                        @foreach($semua_pelayanan as $pelayanan)
                            <option value="{{ $pelayanan->id_pelayanan }}" {{ request('id_pelayanan') == $pelayanan->id_pelayanan ? 'selected' : '' }}>
                                {{ $pelayanan->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filter</button>
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($daftar_permohonan as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->masyarakat->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->masyarakat->nik }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->pelayanan->nama_layanan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->created_at->format('d M Y, H:i') }} WITA</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Nanti link ini akan menuju ke halaman detail permohonan --}}
                                        <a href="#" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-sm font-semibold">
                                            Lihat Detail & Proses
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-gray-500">
                                        Tidak ada pengajuan baru yang perlu diverifikasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-6">
            {{ $daftar_permohonan->links() }}
        </div>

    </div>
@endsection
