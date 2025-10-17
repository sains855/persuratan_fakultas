<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat</title>

    <style>
        @page {
            font-family: 'Times New Roman', Times, serif, Helvetica, sans-serif;
            margin-left: 2.86cm;
            margin-right: 1.59cm;
            margin-top: 0.75cm;
            margin-bottom: 2.54cm;
            line-height: 1.5    ;
            width: 21.59cm;
            height: 35.56cm;
        }

        p {
            margin: 0;
            font-size: 14px
        }

        th,
        td {
            font-size: 14px
        }

        table {
            width: 100%
        }

        .blok-ttd {
            text-align: left;
            padding-left: 120px;
            font-family: "Times New Roman", serif;

        }
        .ttd-wrapper {
            display: inline-block;
            text-align: left;
            line-height: 1.0;
            text-transform: uppercase;
        }
        .ttd-nama {
            display: block;
            border-bottom: 1px solid black;
            padding-bottom: 2px;
            margin-bottom: 4px;
            width: max-content; /* mengikuti panjang isi */
            font-weight: bold;
        }
        .ttd-nip {
            display: block;
        }
    </style>
</head>

<body>
    <table style="border-bottom:2px solid black">
        <tr>
            {{-- Kolom kiri: logo --}}
            <td style="width: 25%; text-align: center; vertical-align: middle;">
                <img src="data:image/webp;base64,{{ base64_encode(file_get_contents(public_path('assets/img/kendari.webp'))) }}"
                    alt="Logo" width="80" height="80">
            </td>

            {{-- Kolom tengah: teks --}}
            <td style="width: 70%; text-align: center; vertical-align: middle;">
                <p style="font-size: 20px; margin: 2px 0; font-weight: bold;">PEMERINTAH KOTA KENDARI</p>
                <p style="font-size: 16px; margin: 2px 0;"><b>KECAMATAN KENDARI BARAT</b></p>
                <p style="font-size: 16px; margin: 2px 0;"><b>KELURAHAN TIPULU</b></p>
                <p style="font-size: 13px; margin: 2px 0;">JL. SERIGALA NO.2 TLP. {{ $telepon }} KODE POS 93122</p>
            </td>

            {{-- Kolom kanan: kosong --}}
            <td style="width: 25%;"></td>
        </tr>
    </table>

    <div style="text-align:center;margin:20px 0">
        @if($judul == "Surat Keterangan Kelakuan Baik (Pengantar SKCK)")

            <p><span style="text-transform: uppercase;"><b style="border-bottom:2px solid black; ">SURAT PENGANTAR</b></span></p>
        @else
            <p><span style="text-transform: uppercase;"><b style="border-bottom:2px solid black">{{ $judul }}</b></span></p>
        @endif
        <p>Nomor : <span style="padding-left:25px">/</span>
            <span style="padding-left:25px">/</span>
            <span style="padding-left:25px">/ {{ $tahun }}</span>
        </p>
    </div>

    <p style="text-align: justify; text-indent: 27px;">
        Yang bertanda tangan di bawah ini, Lurah Tipulu Kecamatan Kendari Barat Kota Kendari, dengan ini menerangkan
        bahwa :
    </p>
    <br>


    @if ($judul == 'Surat Keterangan Kematian')

        <table style="margin-left:27px">
            <tr>
                <td style="width: 30%">Nama</td>
                <td style="width: 2%">:</td>
                <td>{{ $nama_md }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $jenis_kelamin_md }}</td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>:</td>
                <td>{{ $umur }} Tahun</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $alamat_md }}</td>
            </tr>
            <div style='padding-bottom: 3px;'></div>
            <tr>
                <td>Telah Meninggal Dunia Pada</td>
                <td>:</td>
                <td></td>
            </tr>

            {{-- FIXED: Changed <tdr> to a valid <tr> tag --}}
            <tr>
                <td style="padding-left: 15px;">Hari</td>
                <td>:</td>
                <td>{{ $hari_meninggal }}</td>
            </tr>

            <tr>
                <td style="padding-left: 15px;">Tanggal</td>
                <td>:</td>
                <td>{{ $tanggal_meninggal }}</td>
            </tr>

            <tr>
                <td style="padding-left: 15px;">Di</td>
                <td>:</td>
                <td>{{ $tempat_meninggal }}</td>
            </tr>

            <tr>
                <td>Disebabkan Karena</td>
                <td>:</td>
                <td>{{ $penyebab_md }}</td>
            </tr>

            <tr>
                <td>Yang Melaporkan</td>
                <td>:</td>
                <td>{{ $nama_pengaju }}</td>
            </tr>
        </table>


    @elseif ($judul == 'Surat Keterangan Pindah Penduduk')
        {{-- FIXED: Restructured this entire table to be valid HTML --}}
        <table style="margin-left:27px">
            <tr>
                <td style="width: 27%">NIK</td>
                <td style="width: 2%">:</td>
                <td>{{ $nik }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $nama_pengaju }}</td>
            </tr>
            <tr>
                <td>Tempat / Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $agama }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pekerjaan }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td>{{ $status }}</td>
            </tr>
            <tr>
                <td>Alamat Asal</td>
                <td>:</td>
                <td>{{ $alamat }}</td>
            </tr>
        </table>


        <p style="text-align: justify; text-indent: 27px; margin-top:13px">
            Nama yang tersebut diatas adalah benar - benar penduduk di RT {{ $rt }} / RW {{ $rw }} Kelurahan Tipulu Kecamatan
            Kendari
            Barat {!!$keterangan_surat !!}
        </p>



        <table style="margin-left:27px; margin-top:13px">

            <tr>
                <td style="width: 27%">Desa/Kelurahan</td>
                <td style="width: 2%">:</td>
                <td>{{ $desa_kelurahan }}</td>
            </tr>
            <tr>
                <td style=>Kecamatan</td>
                <td>:</td>
                <td>{{ $kecamatan }}</td>
            </tr>
            <tr>
                <td >Kab/Kota</td>
                <td>:</td>
                <td>{{ $kab_kota }}</td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>:</td>
                <td>{{ $provinsi }}</td>
            </tr>
            <tr>
                <td>Tanggal Pindah</td>
                <td>:</td>
                <td>{{ $tgl_pindah }}</td>
            </tr>
            <tr>
                <td>Alasan Pindah</td>
                <td>:</td>
                <td>{{ $alasan_pindah }}</td>
            </tr>
            <tr>
                <td>Pengikut</td>
                <td>:</td>
                <td>{{ $pengikut }} Orang</td>
            </tr>
        </table>
    @else
        <table style="margin-left:27px">

            @if ($judul == 'Pengurusan Kartu Keluarga (KK)')
                <tr>
                    <td style="width: 27%">Nama Kepala Keluarga</td>
                    <td style="width: 2%">:</td>
                    {{-- <td>{{ $nama_kepala_keluarga }}</td> --}}
                </tr>
            @endif

            <tr>
                <td style="width: 27%">NIK</td>
                <td style="width: 2%">:</td>
                <td>{{ $nik }}</td>
            </tr>

            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $nama_pengaju }}</td>
            </tr>
            <tr>
                <td>Tempat / Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $agama }}</td>
            </tr>

            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td>{{ $status }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pekerjaan }}</td>
            </tr>



            @if($judul != 'Surat Keterangan Tempat Tinggal Sementara')

            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $alamat }}</td>
            </tr>
            @endif

            @if ($judul == 'Surat Keterangan Memiliki Usaha (SKU)')
                <tr>
                    <td>Nama Usaha / Yayasan</td>
                    <td>:</td>
                    <td>{{ $nama_usaha_pengaju }}</td>
                </tr>
            @elseif ($judul == 'Surat Izin Keramaian')
                <tr>
                    <td>Nama Kegiatan</td>
                    <td>:</td>
                    <td>{{ $acara }}</td>
                </tr>
            @elseif ($judul == 'Pengurusan Kartu Keluarga (KK)')
                <tr>
                    <td>Kode Pos</td>
                    <td>:</td>
                    <td>93122</td>
                </tr>

                <tr>
                    <td>Golongan Darah</td>
                    <td>:</td>
                    {{-- <td>{{ $golongan_darah }}</td> --}}
                </tr>
            @endif
        </table>

    @endif

    <br>

    @if ($judul == 'Surat Izin Keramaian')
        <p style="text-align: justify; text-indent: 27px;">
                {!! $keterangan_surat !!}
            </p>
            <table style="margin-left:27px">
                <tr>
                    <td style="width: 27%">Tanggal</td>
                    <td style="width: 2%">:</td>
                    <td>{{ $tanggal_acara }}</td>
                </tr>
                    <tr>
                    <td>Tempat</td>
                    <td>:</td>
                    <td>{{ $tempat_acara }}</td>
                </tr>
                <tr>
                    <td>Pukul</td>
                    <td>:</td>
                    <td>{{ $waktu_acara }}</td>
                </tr>

                <tr>
                    <td>Penyelenggara</td>
                    <td>:</td>
                    <td>{{ $penyelenggara_acara }}</td>
            </table>
    @elseif($judul == "Surat Keterangan Tempat Tinggal Sementara")
        <p style="text-align: justify; text-indent: 27px;">
             {!!$keterangan_surat !!}
        </p>
    @elseif($judul == "Surat Keterangan Pindah Penduduk" || $judul == "Surat Keterangan Kematian")

    @else
        <p style="text-align: justify; text-indent: 27px;">
            Nama yang tersebut diatas adalah benar - benar penduduk di RT {{ $rt }} / RW {{ $rw }} Kelurahan Tipulu Kecamatan
            Kendari
            Barat {!!$keterangan_surat !!}

            {{-- @if ($judul == 'Surat Keterangan Domisili Usaha dan Yayasan' ||
    $judul ==
        'Surat Keterangan Domisili
                Usaha')
                {{ $tahun_berdiri }} sampai dengan sekarang.
                @endif --}}

        </p>
    @endif
        @if ($judul == "Surat Keterangan Domisili Usaha dan Yayasan")
            <table style="margin-left:27px; margin-top:10px">
                <tr>
                    <td style="width: 27%">Nama Usaha / Yayasan</td>
                    <td style="width: 2%">:</td>
                    <td>{{ $nama_usaha }}</td>
                </tr>

                <tr>
                    <td>Penanggung Jawab</td>
                    <td>:</td>
                    <td>{{ $penanggung_jawab }}</td>
                </tr>

                <tr>
                    <td>Jenis Kegiatan</td>
                    <td>:</td>
                    <td>{{ $jenis_kegiatan_usaha }}</td>
                </tr>

                <tr>
                    <td>Alamat Usaha / Yayasan</td>
                    <td>:</td>
                    <td>{{ $alamat_usaha }}</td>
                </tr>
            </table>
            <br>
        @endif


        @if ($judul == 'Surat Keterangan Tempat Tinggal Sementara')
            <p style="text-align: justify; text-indent: 27px;margin-top: 10px;">
                Demikian Surat Keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya dan berlaku selama 3
                (tiga) bulan sejak tanggal dikeluarkan.
            </p>
        @elseif($judul == 'Surat Keterangan Kematian')
            <p style="text-align: justify; text-indent: 27px;">
                Demikian Surat Keterangan ini diberikan kepada keluarga Almarhum untuk dipergunakan seperlunya.
            </p>
        @else
            <p style="text-align: justify; text-indent: 27px; padding : 5px">
                Demikian Surat Keterangan ini dibuat dengan sebenar-benarnya untuk dipergunakan seperlunya.
            </p>
        @endif

    <table style="margin-top:30px; width:100%;">
    <tr>
        <td style="width:50%;"></td>
        <td class="blok-ttd">
        Kendari, 8 Oktober 2025<br>
        <span style="text-transform: uppercase;">
        <b>LURAH TIPULU</span><br>
        @if($jabatan != "Lurah")
            <span style="text-transform: uppercase;">
            <b>AN. {{ $jabatan }}
            </span>
        @endif
        <br><br><br><br><br>
        <div class="ttd-wrapper">
            <span class="ttd-nama">{{ $aparatur }}</span>
            <span class="ttd-nip">NIP: {{ $aparatur_nip }}</span>
        </div>
        </td>
    </tr>
    </table>
</body>

</html>
