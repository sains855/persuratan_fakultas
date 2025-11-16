@extends('layouts.main')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="mx-auto">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl rounded-2xl p-3 sm:p-6 border border-blue-200">
            <div class="flex justify-between items-center mb-4 sm:mb-6">
                <h2 class="text-sm sm:text-xl lg:text-2xl font-extrabold text-blue-800 tracking-wide flex items-center gap-2">
                    <i class="fa fa-list-alt text-blue-600 text-xs sm:text-base"></i>
                    <span class="hidden sm:inline">Daftar {{ $title }}</span>
                    <span class="sm:hidden">{{ $title }}</span>
                </h2>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto rounded-xl border border-blue-200">
                <table class="min-w-full rounded-xl overflow-hidden">
                    <thead class="bg-blue-600 text-white uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Nomor WA</th>
                            <th class="px-4 py-3 text-left">Pelayanan</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm bg-white">
                        @forelse ($pengajuan as $data)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-4 py-3 text-center font-semibold text-blue-600">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ optional($data->mahasiswa)->nama ?? optional($data->tempatTinggalSementara)->nama }}</td>
                                <td class="px-4 py-3">{{ $data->no_hp }}</td>
                                <td class="px-4 py-3">{{ $data->pelayanan->nama }}</td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $verifikasi = $data->verifikasiByAparatur(4)->first();
                                    @endphp
                                    @if($verifikasi)
                                        @if(str_contains($verifikasi->status, 'Terverifikasi'))
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                <i class="fa fa-check-circle mr-1"></i>Terverifikasi
                                            </span>
                                        @elseif(str_contains($verifikasi->status, 'Ditolak'))
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                                <i class="fa fa-times-circle mr-1"></i>Ditolak
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                                {{ $verifikasi->status }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                            <i class="fa fa-clock mr-1"></i>Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center flex justify-center gap-3">
                                    @php
                                        $verifikasi = $data->verifikasiByAparatur(4)->first();
                                        $isDitolak = $verifikasi && str_contains($verifikasi->status, 'Ditolak');
                                        $isTerverifikasi = $verifikasi && str_contains($verifikasi->status, 'Terverifikasi');
                                    @endphp

                                    @if (!$verifikasi || $isDitolak)
                                        {{-- Tombol Verifikasi / Verifikasi Ulang --}}
                                        <button data-id="{{ $data->id }}"
                                            data-nama="{{ optional($data->mahasiswa)->nama ?? optional($data->tempatTinggalSementara)->nama }}"
                                            data-nohp="{{ $data->no_hp }}"
                                            data-pelayanan="{{ $data->pelayanan->nama }}"
                                            onclick="openVerifikasiModal(this)"
                                            class="text-blue-500 hover:text-blue-600 transition transform hover:scale-110"
                                            title="{{ $isDitolak ? 'Verifikasi Ulang' : 'Verifikasi' }}">
                                            <i class="fa-solid fa-hand-pointer text-lg"></i>
                                        </button>
                                    @endif

                                    @if ($isTerverifikasi)
                                        {{-- Tombol WhatsApp --}}
                                        <a href="{{
                                            'https://wa.me/'
                                            . preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $data->no_hp))
                                            . '?text='
                                            . urlencode(
                                                'Assalamualaikum Bapak/Ibu '
                                                . ($data->mahasiswa?->nama ?: $data->tempatTinggalSementara?->nama)
                                                . ',' . "\n\n" .
                                                'Dengan hormat, kami informasikan bahwa pengajuan layanan '
                                                . $data->pelayanan->nama
                                                . ' Anda telah diproses dan sudah bisa diambil.' . "\n\n" .
                                                'Silahkan datang pada jam kerja untuk mengambil dokumen.' . "\n" .
                                                'Terima kasih atas perhatiannya.' . "\n\n" .
                                                'Hormat Kami,' . "\n" .
                                                'Staf Pelayanan Kantor Lurah'
                                            )
                                        }}" target="_blank"
                                            class="text-green-500 hover:text-green-600 transition transform hover:scale-110"
                                            title="Kirim Notifikasi WA">
                                            <i class="fa-brands fa-whatsapp text-lg"></i>
                                        </a>

                                        {{-- Tombol Cetak --}}
                                        <button type="button" onclick="openCetakModal('{{ $data->id }}')"
                                            class="text-yellow-500 hover:text-yellow-600 transition transform hover:scale-110"
                                            title="Cetak Surat">
                                            <i class="fa-solid fa-print text-lg"></i>
                                        </button>
                                    @endif

                                    {{-- Tombol Lihat Detail (selalu ada) --}}
                                    <button type="button" onclick="openDokumenModal('{{ $data->id }}')"
                                        class="text-gray-500 hover:text-gray-600 transition transform hover:scale-110"
                                        title="Detail Dokumen Pengajuan">
                                        <i class="fa-solid fa-eye text-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4 text-gray-500">Tidak Ada data pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-3">
                @forelse ($pengajuan as $data)
                    <div class="bg-white rounded-lg shadow-md border border-blue-200 p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">{{ $loop->iteration }}</span>
                                    <h3 class="font-bold text-gray-800 text-sm">{{ optional($data->mahasiswa)->nama ?? optional($data->tempatTinggalSementara)->nama }}</h3>
                                </div>
                                <div class="space-y-1 text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-brands fa-whatsapp text-green-500"></i>
                                        <span>{{ $data->no_hp }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fa fa-briefcase text-blue-500"></i>
                                        <span>{{ $data->pelayanan->nama }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fa fa-info-circle text-gray-500"></i>
                                        @php
                                            $verifikasi = $data->verifikasiByAparatur(4)->first();
                                        @endphp
                                        @if($verifikasi)
                                            @if(str_contains($verifikasi->status, 'Terverifikasi'))
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                    <i class="fa fa-check-circle mr-1"></i>Terverifikasi
                                                </span>
                                            @elseif(str_contains($verifikasi->status, 'Ditolak'))
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                                    <i class="fa fa-times-circle mr-1"></i>Ditolak
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                                    {{ $verifikasi->status }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                                <i class="fa fa-clock mr-1"></i>Menunggu
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">
                            @php
                                $verifikasi = $data->verifikasiByAparatur(4)->first();
                                $isDitolak = $verifikasi && str_contains($verifikasi->status, 'Ditolak');
                                $isTerverifikasi = $verifikasi && str_contains($verifikasi->status, 'Terverifikasi');
                            @endphp

                            @if (!$verifikasi || $isDitolak)
                                {{-- Tombol Verifikasi / Verifikasi Ulang --}}
                                <button data-id="{{ $data->id }}"
                                    data-nama="{{ optional($data->mahasiswa)->nama ?? optional($data->tempatTinggalSementara)->nama }}"
                                    data-nohp="{{ $data->no_hp }}"
                                    data-pelayanan="{{ $data->pelayanan->nama }}"
                                    onclick="openVerifikasiModal(this)"
                                    class="flex items-center gap-1 px-3 py-2 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition"
                                    title="{{ $isDitolak ? 'Verifikasi Ulang' : 'Verifikasi' }}">
                                    <i class="fa-solid fa-hand-pointer"></i>
                                    <span>{{ $isDitolak ? 'Verifikasi Ulang' : 'Verifikasi' }}</span>
                                </button>
                            @endif

                            @if ($isTerverifikasi)
                                {{-- Tombol WhatsApp --}}
                                <a href="{{
                                    'https://wa.me/'
                                    . preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $data->no_hp))
                                    . '?text='
                                    . urlencode(
                                        'Assalamualaikum Bapak/Ibu '
                                        . ($data->mahasiswa?->nama ?: $data->tempatTinggalSementara?->nama)
                                        . ',' . "\n\n" .
                                        'Dengan hormat, kami informasikan bahwa pengajuan layanan '
                                        . $data->pelayanan->nama
                                        . ' Anda telah diproses dan sudah bisa diambil.' . "\n\n" .
                                        'Silahkan datang pada jam kerja untuk mengambil dokumen.' . "\n" .
                                        'Terima kasih atas perhatiannya.' . "\n\n" .
                                        'Hormat Kami,' . "\n" .
                                        'Staf Pelayanan Kantor Lurah'
                                    )
                                }}" target="_blank"
                                    class="flex items-center gap-1 px-3 py-2 bg-green-500 text-white text-xs rounded-lg hover:bg-green-600 transition"
                                    title="Kirim Notifikasi WA">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>WA</span>
                                </a>

                                {{-- Tombol Cetak --}}
                                <button type="button" onclick="openCetakModal('{{ $data->id }}')"
                                    class="flex items-center gap-1 px-3 py-2 bg-yellow-500 text-white text-xs rounded-lg hover:bg-yellow-600 transition"
                                    title="Cetak Surat">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Cetak</span>
                                </button>
                            @endif

                            {{-- Tombol Lihat Detail (selalu ada) --}}
                            <button type="button" onclick="openDokumenModal('{{ $data->id }}')"
                                class="flex items-center gap-1 px-3 py-2 bg-gray-500 text-white text-xs rounded-lg hover:bg-gray-600 transition"
                                title="Detail Dokumen Pengajuan">
                                <i class="fa-solid fa-eye"></i>
                                <span>Lihat</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-md border border-blue-200 p-6 text-center text-gray-500 text-sm">
                        Tidak Ada data pengajuan.
                    </div>
                @endforelse
            </div>

            {{-- LOOP MODAL UNTUK SETIAP DATA --}}
            @foreach ($pengajuan as $data)
                {{-- Modal Dokumen --}}
                <div id="dokumenModal-{{ $data->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-4 sm:p-6 relative max-h-[90vh] overflow-y-auto">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-600 mr-3">
                                <i class="fa-solid fa-file-pdf text-xl sm:text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-base sm:text-lg font-bold text-gray-800">Detail Dokumen Pengajuan</h2>
                                <p class="text-xs sm:text-sm text-gray-500">Daftar dokumen persyaratan</p>
                            </div>
                            <button onclick="closeDokumenModal('{{ $data->id }}')" class="text-gray-500 hover:text-red-500">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="border-t border-gray-200 pt-4 max-h-[400px] overflow-y-auto">
                            @forelse ($data->dokumenPersyaratan as $i => $doc)
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3 border rounded-lg mb-2 bg-gray-50 gap-2">
                                    <span class="text-gray-700 text-xs sm:text-sm flex-1">{{ $i + 1 }}. {{ $doc->persyaratan->nama }}</span>
                                    <a href="{{ route('list-pengajuan.stream', ['persyaratan_id' => $doc->persyaratan_id, 'pengajuan_id' => $doc->pengajuan_id]) }}"
                                        class="w-full sm:w-auto text-center px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600 transition">
                                        <i class="fa fa-eye mr-1"></i> Lihat
                                    </a>
                                </div>
                            @empty
                                <p class="text-gray-500 text-xs sm:text-sm text-center py-4">Tidak ada dokumen persyaratan yang diunggah.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Modal Cetak --}}
                <div id="cetakModal-{{ $data->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-4 sm:p-6 relative max-h-[90vh] overflow-y-auto">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-yellow-100 text-yellow-600 mr-3">
                                <i class="fa-solid fa-print text-xl sm:text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-base sm:text-lg font-bold text-gray-800">Cetak Surat</h2>
                                <p class="text-xs sm:text-sm text-gray-500">Lengkapi data sebelum memproses</p>
                            </div>
                            <button onclick="closeCetakModal('{{ $data->id }}')" class="text-gray-500 hover:text-red-500">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>

                        <div>
                            <div class="mb-3">
                                <label class="block text-xs sm:text-sm font-semibold text-gray-600 mb-1">Tanggal Cetak</label>
                                <input type="date" id="tgl_cetak-{{ $data->id }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-400">
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs sm:text-sm font-semibold text-gray-600 mb-1">Penanda Tangan</label>
                                <select id="aparatur_id-{{ $data->id }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-400">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($ttds as $ttd)
                                        <option value="{{ $ttd->id }}">{{ $ttd->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 mt-6 border-t pt-4">
                                <button type="button" onclick="closeCetakModal('{{ $data->id }}')" class="w-full sm:w-auto px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">
                                    Batal
                                </button>
                                <button type="button" onclick="handleCetak('{{ $data->id }}', 'download')" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-green-500 text-white hover:bg-green-600 shadow-md text-sm">
                                    <i class="fa fa-download mr-1"></i> Unduh PDF
                                </button>
                                <button type="button" onclick="handleCetak('{{ $data->id }}', 'stream')" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 shadow-md text-sm">
                                    <i class="fa fa-print mr-1"></i> Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Modal Verifikasi (Global) --}}
            <div id="verifikasiModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-4 sm:p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-600 mr-3">
                            <i class="fa-solid fa-circle-check text-xl sm:text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-base sm:text-lg font-bold text-gray-800">Verifikasi Pengajuan</h2>
                            <p class="text-xs sm:text-sm text-gray-500">Konfirmasi pengajuan mahasiswa</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-xs sm:text-sm text-gray-600">
                            Apakah Anda ingin <span class="font-semibold text-green-600">memverifikasi</span> atau
                            <span class="font-semibold text-red-600">menolak</span> pengajuan atas nama
                            <span id="namamahasiswa" class="font-semibold text-blue-600"></span>?
                        </p>
                    </div>
                    <form id="formVerifikasi" method="POST" class="mt-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" id="statusPengajuan">
                        <input type="hidden" name="alasan" id="alasanPenolakan">
                        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                            <button type="button" onclick="closeVerifikasiModal()" class="w-full sm:w-auto px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">
                                Batal
                            </button>
                            <button type="button" onclick="showAlasanModal()" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow-md text-sm">
                                <i class="fa-solid fa-xmark mr-1"></i> Tolak
                            </button>
                            <button type="submit" onclick="setStatus('Terverifikasi')" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-green-500 text-white hover:bg-green-600 shadow-md text-sm">
                                <i class="fa-solid fa-check mr-1"></i> Verifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal Alasan Penolakan --}}
            <div id="alasanModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-4 sm:p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-red-100 text-red-600 mr-3">
                            <i class="fa-solid fa-exclamation-triangle text-xl sm:text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-base sm:text-lg font-bold text-gray-800">Alasan Penolakan</h2>
                            <p class="text-xs sm:text-sm text-gray-500">Berikan alasan penolakan</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-600 mb-2">Alasan Penolakan</label>
                        <textarea id="alasanTextarea" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400"
                            placeholder="Tuliskan alasan penolakan pengajuan..."></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 mt-6">
                        <button type="button" onclick="closeAlasanModal()" class="w-full sm:w-auto px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm">
                            Batal
                        </button>
                        <button type="button" onclick="submitPenolakan()" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow-md text-sm">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Penolakan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    </style>

    <script>
        let currentPengajuanId = null;
        let currentNamaWa = null;
        let currentNoHp = null;
        let currentPelayanan = null;
        let isVerifikasiUlang = false;

        // Verifikasi Modal
        function openVerifikasiModal(button) {
            const id = button.getAttribute("data-id");
            const nama = button.getAttribute("data-nama");
            currentPengajuanId = id;
            currentNamaWa = nama;

            // Ambil data nomor HP dan pelayanan dari baris yang sama
            const row = button.closest('tr') || button.closest('.bg-white');
            if (row) {
                const noHpElement = row.querySelector('td:nth-child(3)') || row.querySelector('.fa-whatsapp').parentElement;
                const pelayananElement = row.querySelector('td:nth-child(4)') || row.querySelector('.fa-briefcase').parentElement;

                if (noHpElement) {
                    currentNoHp = noHpElement.textContent.trim();
                }
                if (pelayananElement) {
                    currentPelayanan = pelayananElement.textContent.trim();
                }
            }

            // Deteksi apakah ini verifikasi ulang berdasarkan title button
            isVerifikasiUlang = button.getAttribute('title') === 'Verifikasi Ulang';

            document.getElementById("namamahasiswa").innerText = nama;
            document.getElementById("formVerifikasi").action = "{{ url('/list-pengajuan/verifikasi') }}/" + id;
            document.getElementById("verifikasiModal").classList.remove("hidden");
        }

        function closeVerifikasiModal() {
            document.getElementById("verifikasiModal").classList.add("hidden");
            document.getElementById("alasanTextarea").value = '';
            document.getElementById("alasanPenolakan").value = '';
            isVerifikasiUlang = false;
        }

        function setStatus(status) {
            document.getElementById("statusPengajuan").value = status;
        }

        // Modal Alasan Penolakan
        function showAlasanModal() {
            document.getElementById("alasanModal").classList.remove("hidden");
        }

        function closeAlasanModal() {
            document.getElementById("alasanModal").classList.add("hidden");
        }

        function submitPenolakan() {
            const alasan = document.getElementById("alasanTextarea").value.trim();

            if (!alasan) {
                alert('Harap isi alasan penolakan terlebih dahulu!');
                return;
            }

            // Set status dan alasan
            document.getElementById("statusPengajuan").value = 'Ditolak';
            document.getElementById("alasanPenolakan").value = alasan;

            // Kirim notifikasi WhatsApp
            if (currentNoHp && currentNamaWa && currentPelayanan) {
                const cleanPhone = currentNoHp.replace(/^0/, '62').replace(/[^0-9]/g, '');
                const message = `Assalamualaikum Bapak/Ibu ${currentNamaWa},\n\n` +
                    `Dengan hormat, kami informasikan bahwa pengajuan layanan ${currentPelayanan} Anda telah ditolak.\n\n` +
                    `Alasan penolakan:\n${alasan}\n\n` +
                    `Untuk informasi lebih lanjut, silakan hubungi kantor lurah pada jam kerja.\n\n` +
                    `Terima kasih atas pengertiannya.\n\n` +
                    `Hormat Kami,\n` +
                    `Staf Pelayanan Kantor Lurah`;

                const waUrl = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(message)}`;
                window.open(waUrl, '_blank');
            }

            // Tutup modal alasan
            closeAlasanModal();

            // Submit form verifikasi
            document.getElementById("formVerifikasi").submit();
        }

        // Dokumen & Cetak Modal
        function openDokumenModal(id) {
            document.getElementById("dokumenModal-" + id).classList.remove("hidden");
        }
        function closeDokumenModal(id) {
            document.getElementById("dokumenModal-" + id).classList.add("hidden");
        }
        function openCetakModal(id) {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tgl_cetak-' + id).value = today;
            document.getElementById("cetakModal-" + id).classList.remove("hidden");
        }
        function closeCetakModal(id) {
            document.getElementById("cetakModal-" + id).classList.add("hidden");
        }

        function handleCetak(id, action) {
            const tglCetak = document.getElementById('tgl_cetak-' + id).value;
            const aparaturId = document.getElementById('aparatur_id-' + id).value;

            if (!tglCetak || !aparaturId) {
                alert('Harap lengkapi Tanggal Cetak dan Penanda Tangan.');
                return;
            }

            const baseUrl = "{{ url('/') }}";
            const url = `${baseUrl}/list-pengajuan/${id}/cetak-${action}`;

            const formData = {
                tgl_cetak: tglCetak,
                aparatur_id: aparaturId,
                _token: "{{ csrf_token() }}"
            };

            // Cek apakah channel Flutter 'flutterCetak' tersedia
            if (window.flutterCetak) {
                // --- JALUR UNTUK APLIKASI MOBILE ---
                console.log('Mode Mobile: Mengirim data ke Flutter...');
                const payload = {
                    type: 'cetakSurat',
                    url: url,
                    formData: formData
                };
                window.flutterCetak.postMessage(JSON.stringify(payload));
                closeCetakModal(id);

            } else {
                // --- JALUR UNTUK BROWSER WEB BIASA ---
                console.log('Mode Web: Membuat form dinamis...');

                // Buat form sementara di dalam memori
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.target = '_blank'; // Buka hasil di tab baru

                // Tambahkan setiap data dari formData sebagai input tersembunyi
                for (const key in formData) {
                    if (formData.hasOwnProperty(key)) {
                        const hiddenField = document.createElement('input');
                        hiddenField.type = 'hidden';
                        hiddenField.name = key;
                        hiddenField.value = formData[key];
                        form.appendChild(hiddenField);
                    }
                }

                // Tambahkan form ke body, submit, lalu hapus lagi
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
                closeCetakModal(id);
            }
        }
    </script>
@endsection
