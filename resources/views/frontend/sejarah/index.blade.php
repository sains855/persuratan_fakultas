{{-- @extends('layouts.main_frontend')

@section('content')
<main class="container mx-auto px-4 py-16">
    <div class="bg-white shadow-lg rounded-2xl p-8 prose prose-blue max-w-none">
        <h1 class="text-3xl md:text-4xl font-extrabold text-black-700 mb-6 text-center">
            Sejarah Kelurahan Tipulu
        </h1>

        <!-- 1️⃣ Asal Usul Nama -->
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Asal Usul Nama Tipulu</h2>
            <p class="text-gray-700 leading-relaxed">
                Nama <strong>Tipulu</strong> berasal dari sebuah pohon besar bernama “Tipulu” yang dahulu tumbuh di wilayah RT 10.
                Dari pohon inilah nama kelurahan ini diambil. Masyarakat percaya bahwa penamaan tersebut diberikan oleh pemerintah pada masa itu,
                meskipun tokoh pencetusnya tidak diketahui secara pasti.
            </p>
        </section>

        <!-- 2️⃣ Perkembangan Sejarah -->
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Perkembangan Sejarah</h2>

            <h3 class="text-xl font-semibold text-blue-700 mt-4 mb-2">Masa Kerajaan dan Leluhur</h3>
            <p class="text-gray-700 leading-relaxed">
                Secara historis, Kelurahan Tipulu telah ada sejak sekitar tahun 1800-an. Berdasarkan cerita turun-temurun,
                wilayah ini diakui oleh <strong>Kerajaan Tolaki</strong> pada masa itu. Pohon Tipulu dikenal sebagai pohon raksasa yang sakral,
                dan di sekitarnya dahulu terdapat kuburan para leluhur. Kuburan tersebut kemudian dipindahkan ke sekitar
                kantor Bank Indonesia, dan setelah Indonesia merdeka, dipindahkan lagi ke area SPBU yang kini berdiri di wilayah tersebut.
            </p>

            <h3 class="text-xl font-semibold text-blue-700 mt-4 mb-2">Masa Kolonial dan Kemerdekaan</h3>
            <p class="text-gray-700 leading-relaxed">
                Dalam catatan lisan, Tipulu berawal dari masa <strong>Kerajaan Laiwoi (Leuwoi)</strong>.
                Saat itu, suku Muna datang dan diterima oleh suku Tolaki. Mereka berperan penting dalam penyebaran agama,
                kegiatan politik, dan membantu penyerangan terhadap Tidore di wilayah Kendari (TKK).
                Tipulu dikenal sebagai wilayah yang menolak penjajahan Belanda, meskipun perjuangan para leluhur tidak banyak
                tercatat dalam sejarah resmi.
            </p>

            <h3 class="text-xl font-semibold text-blue-700 mt-4 mb-2">Masa Pemerintahan Modern</h3>
            <p class="text-gray-700 leading-relaxed">
                Setelah kemerdekaan, <strong>Abu Raera</strong> menjadi tokoh penting dalam pembentukan distrik di wilayah ini.
                Pada masa pemerintahan <strong>Hasmin</strong> (sekitar tahun 1980-an), Tipulu resmi menjadi kelurahan setelah proses pemekaran dari desa.
                Dahulu Tipulu terdiri atas lima lingkungan yang kemudian menjadi lima Rukun Warga (RW) seperti saat ini.
            </p>
        </section>

        <!-- 3️⃣ Kondisi Sosial Budaya -->
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Kondisi Sosial dan Budaya</h2>
            <p class="text-gray-700 leading-relaxed">
                Selain sejarah perjuangannya, Tipulu juga dikenal sebagai kampung pertama yang menjadi pusat distrik
                dan kini menjadi wilayah strategis dengan banyak kantor pemerintahan, termasuk <strong>Kantor PTSP</strong>.
                Masyarakat Tipulu bersifat <strong>multietnis</strong>, dengan mayoritas suku Muna dan Bugis, serta suku Tolaki sebagai penduduk asli penerima.
                Tipulu juga pernah dikenal dengan nama “Kemang Raya”, dan banyak keluarga Bugis dari Kajuara
                serta Muna dari Tiworo dan Liluka menetap di sini.
            </p>
        </section>

        <!-- 4️⃣ Identitas Tipulu Saat Ini -->
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">Kelurahan Tipulu Saat Ini</h2>
            <p class="text-gray-700 leading-relaxed">
                Seiring waktu, Tipulu terus berkembang hingga kini menjadi salah satu kelurahan penting di Kota Kendari.
                Jejak sejarahnya yang panjang — dari masa kerajaan, kolonial, hingga era kemerdekaan — membentuk identitas
                Tipulu sebagai kelurahan yang kaya nilai budaya dan sejarah.
            </p>
        </section>

        <!-- 5️⃣ Sumber Informasi -->
        <section class="border-t pt-4 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Sumber Informasi</h2>
            <p class="text-gray-600 text-sm">
                Narasumber: <strong>Pak Azis Darise dan Pak Hasan Darise</strong> — Cucu dari Pak Darise Kepala Desa Tipulu tahun 1973–1976.
            </p>
        </section>

        <div class="text-center mt-8">
            <a href="{{ url('/#profil') }}"
                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                ← Kembali
            </a>
        </div>
    </div>
</main>
@endsection --}}

@extends('layouts.main_frontend')

@section('content')
<main class="container mx-auto px-4 py-16">
    <div class="bg-white shadow-lg rounded-2xl p-8 prose prose-blue max-w-none">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 text-center">
            Sejarah Kelurahan Tipulu
        </h1>

        {{-- Render konten dari database (HTML dari TinyMCE) --}}
        {!! $landingPage->deskripsi ?? '<p class="text-gray-500 italic text-center">Belum ada data sejarah yang diinput.</p>' !!}

        <div class="text-center mt-8">
            <a href="{{ url('/#profil') }}"
                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                ← Kembali
            </a>
        </div>
    </div>
</main>
@endsection 

