<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>

    <style>
        @page {
            font-family: 'Times New Roman', Times, serif;
            margin-left: 2.54cm;
            margin-right: 2.54cm;
            margin-top: 1cm;
            margin-bottom: 2.54cm;
            size: 21.59cm 33.02cm; /* Ukuran F4 */
        }

        body {
            font-size: 12pt;
            line-height: 1.15; /* Sedikit lebih rapat sesuai gambar */
        }

        p {
            margin: 0;
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 2px 0;
        }

        .header-text {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
        }

        .header-univ {
            font-size: 14pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .header-fakultas {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-alamat {
            font-size: 10pt;
            font-style: normal;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            font-size: 12pt;
            margin-top: 20px;
        }

        .nomor-surat {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 20px;
        }

        .data-table {
            margin-left: 30px;
            width: 95%;
        }

        .data-table td:first-child {
            width: 180px;
        }

        .data-table td:nth-child(2) {
            width: 10px;
            text-align: center;
        }

        .ttd-block {
            float: right;
            width: 45%;
            margin-top: 30px;
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <table style="border-bottom: 3px solid black; padding-bottom: 5px;">
        <tr>
            <td style="width: 15%; text-align: center; vertical-align: middle;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo_uho.webp'))) }}"
                     alt="Logo UHO" width="90">
            </td>
            <td style="width: 85%; text-align: center;" class="header-text">
                <span class="header-univ">KEMENTERIAN PENDIDIKAN TINGGI, SAINS<br>DAN TEKNOLOGI</span><br>
                <span class="header-univ" style="font-weight: bold;">UNIVERSITAS HALU OLEO</span><br>
                <span class="header-fakultas">FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM</span><br>
                <span class="header-alamat">
                    Kampus Hijau Bumi Tridharma Anduonohu, Jalan H.E.A Mokodompit Kendari 93232<br>
                    Telp. (0401) 3191929 Fax (0401) 3190496
                </span>
            </td>
        </tr>
    </table>

    <div class="judul-surat">{{ $judul }}</div>
    <div class="nomor-surat">Nomor: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/UN29.9.3/KM/{{ $tahun }}</div>

    @if($judul == 'Surat Keterangan Mahasiswa Prestasi')
        <p>Dekan Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Halu Oleo, dengan ini menerangkan bahwa:</p>
        <br>
    @else
        <p>Yang bertanda tangan di bawah ini:</p>
        <table class="data-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $ttd }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $ttd_nip }}</td>
            </tr>
            <tr>
                <td>Pangkat/Gol. Ruang</td>
                <td>:</td>
                <td>{{ $ttd_pangkat ?? 'Pembina / IV/a' }}</td> </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $jabatan }}</td>
            </tr>
            @if($judul == 'Surat Keterangan Alumni')
                <tr>
                    <td>Fakultas</td>
                    <td>:</td>
                    <td>Matematika dan Ilmu Pengetahuan Alam</td>
                </tr>
            @endif
        </table>

        <br>
        @if($judul == 'Surat Keterangan Aktif Kuliah')
            <p>Menerangkan dengan sesungguhnya bahwa:</p>
        @elseif($judul == 'Surat Keterangan Alumni')
            <p>Dengan ini menyatakan dengan sesungguhnya bahwa:</p>
        @elseif($judul == 'Surat Keterangan Tidak Sedang Menerima Beasiswa')
             <p>Menyatakan bahwa sepanjang pengetahuan/penelitian kami mahasiswa tersebut di atas tidak sedang menerima beasiswa dari sponsor atau pihak lain.</p>
             @else
            <p>Menerangkan bahwa mahasiswa tersebut di bawah ini:</p>
        @endif
        <br>
    @endif

    <table class="data-table">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td style="font-weight: bold;">{{ $nama }}</td>
        </tr>
        <tr>
            <td>{{ $judul == 'Surat Keterangan Alumni' ? 'NIM' : 'NIM' }}</td>
            <td>:</td>
            <td>{{ $nim }}</td>
        </tr>

        @if($judul != 'Surat Keterangan Mahasiswa Prestasi')
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
            </tr>
        @endif

        <tr>
            <td>Fakultas</td>
            <td>:</td>
            <td>Matematika dan Ilmu Pengetahuan Alam</td>
        </tr>
        <tr>
            <td>Jurusan/Prodi</td>
            <td>:</td>
            <td>{{ $prodi }}</td>
        </tr>

        @if($judul == 'Surat Keterangan Mahasiswa Prestasi')
             <tr>
                <td>Jenjang Pendidikan</td>
                <td>:</td>
                <td>S1</td>
             </tr>
             <tr>
                <td>Tahun Masuk</td>
                <td>:</td>
                <td>{{ $tahun_masuk ?? '20..' }}</td>
             </tr>
             <tr>
                <td>Semester</td>
                <td>:</td>
                <td>{{ $semester ?? '...' }}</td>
             </tr>
        @endif

        @if(in_array($judul, ['Surat Keterangan Tidak Sedang Bekerja', 'Surat Keterangan Tidak Sedang Menerima Beasiswa', 'Surat Keterangan Berkelakuan Baik']))
            <tr>
                <td>IPK</td>
                <td>:</td>
                <td>{{ $ipk ?? '...' }}</td>
            </tr>
        @endif

        @if($judul != 'Surat Keterangan Mahasiswa Prestasi' && $judul != 'Surat Keterangan Alumni')
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $alamat }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td>{{ $no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $email ?? '-' }}</td>
            </tr>
        @endif
    </table>

    <br>

    @if($judul == 'Surat Keterangan Aktif Kuliah')
        <p style="text-align: justify;">
            Yang bersangkutan masih tetap mengikuti kegiatan Akademik dan terdaftar sebagai mahasiswa pada Fakultas Matematika dan Ilmu Pengetahuan Alam pada Semester {{ $semester_romawi ?? 'Ganjil/Genap' }} Tahun Akademik {{ $tahun_akademik ?? date('Y').'/'.(date('Y')+1) }}.
        </p>
        <br>
        <table class="data-table">
            <tr>
                <td>Nama Orang Tua</td>
                <td>:</td>
                <td>{{ $nama_ayah ?? '...' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pekerjaan_ayah ?? '...' }}</td>
            </tr>
            <tr>
                <td>NIP/No. Pensiun</td>
                <td>:</td>
                <td>{{ $nip_ayah ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pangkat/Gol. Ruang</td>
                <td>:</td>
                <td>{{ $pangkat_ayah ?? '-' }}</td>
            </tr>
            <tr>
                <td>Instansi</td>
                <td>:</td>
                <td>{{ $instansi_ayah ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $alamat_orangtua ?? $alamat }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td>{{ $nohp_ayah ?? '-' }}</td>
            </tr>
        </table>
        <br>
        <p>Demikian surat keterangan ini di buat dengan sesungguhnya, apabila di kemudian hari ternyata tidak benar sehingga mengakibatkan kerugian Negara Republik Indonesia, maka saya bersedia menanggung segala kerugian tersebut.</p>

    @elseif($judul == 'Surat Keterangan Alumni')
        <p style="text-align: justify; text-indent: 30px;">
            Adalah benar alumni Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Halu Oleo Kendari, yang bersangkutan terdaftar sebagai mahasiswa Reguler pada tahun akademik {{ $tahun_masuk ?? '....' }} dan menyelesaikan studi pada tahun {{ $tahun_lulus ?? date('Y') }}. Telah diyudisium pada tanggal {{ $tgl_yudisium ?? '...' }} serta memperoleh ijazah dengan Nomor {{ $no_ijazah ?? '...' }}.
        </p>
        <br>
        <p>Demikian surat keterangan ini diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya.</p>

    @elseif($judul == 'Surat Keterangan Mahasiswa Prestasi')
        <p style="text-align: justify; text-indent: 30px;">
            Benar yang bersangkutan adalah mahasiswa Universitas Halu Oleo yang selama mengikuti aktivitas perkuliahan telah menunjukan prestasi yang baik dengan Indeks Prestasi Kumulatif {{ $ipk ?? '...' }} ({{ $ipk_terbilang ?? '...' }}).
        </p>
        <br>
        <p>Demikian surat keterangan ini kami buat, untuk digunakan sebagaimana mestinya.</p>

    @elseif($judul == 'Surat Keterangan Berkelakuan Baik')
        <p style="text-align: justify; text-indent: 30px;">
            Bahwa mahasiswa tersebut di atas selama mengikuti kegiatan intra kurikuler, kokurikuler, dan ekstra kurikuler dalam lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Halu Oleo, selama pemantauan, pengamatan, dan pengetahuan kami yang bersangkutan adalah berkelakuan baik.
        </p>
        <br>
        <p>Demikian surat keterangan ini diberikan pada yang bersangkutan untuk dipergunakan seperlunya.</p>

    @elseif($judul == 'Surat Keterangan Tidak Sedang Bekerja')
        <p style="text-align: justify; text-indent: 30px;">
            Menyatakan bahwa, mahasiswa yang tercantum namanya di atas tidak sedang bekerja pada suatu instansi atau yayasan tertentu.
        </p>
        <br>
        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    @elseif($judul == 'Surat Keterangan Tidak Sedang Menerima Beasiswa')
        <p style="text-align: justify;">
            Menyatakan bahwa sepanjang pengetahuan/penelitian kami mahasiswa tersebut diatas tidak sedang menerima beasiswa dari sponsor atau pihak lain.
        </p>
        <br>
        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    @endif

    <div class="ttd-block">
        <p>Kendari, {{ $tanggal }}</p>
        @if($judul == 'Surat Keterangan Mahasiswa Prestasi')
            <p>Dekan,</p>
            <br><br><br><br>
            <span class="ttd-nama">{{ $ttd }}</span><br>
            <span>NIP. {{ $ttd_nip }}</span>
        @elseif($judul == 'Surat Keterangan Berkelakuan Baik')
             <p>a.n. Dekan<br>Wakil Dekan Bid. Kemahasiswaan dan Alumni,<br>Sub. Koordinator Kemahasiswaan dan Alumni,</p>
             <br><br><br><br>
             <span class="ttd-nama">{{ $ttd }}</span><br>
             <span>NIP. {{ $ttd_nip }}</span>
        @else
            <p>a.n. Dekan<br>Wakil Dekan Bidang Kemahasiswaan dan Alumni</p>
            <br><br><br><br>
            <span class="ttd-nama">{{ $ttd }}</span><br>
            <span>NIP. {{ $ttd_nip }}</span>
        @endif
    </div>

    @if(in_array($judul, ['Surat Keterangan Tidak Sedang Bekerja', 'Surat Keterangan Berkelakuan Baik']))
    @endif

</body>
</html>
