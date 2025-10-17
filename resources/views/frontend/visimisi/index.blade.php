{{-- @extends('layouts.main_frontend')

@section('content')
<main class="container mx-auto px-4 py-16">
    <div class="bg-white shadow-lg rounded-2xl p-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">
            Visi & Misi Kelurahan Tipulu
        </h2>

        {{-- Visi --}}
        {{-- <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Visi</h3>
            <p class="text-lg text-gray-700 italic border-l-4 border-blue-500 pl-4">
                “Mewujudkan Kawasan Permukiman Tipulu yang Layak Huni, Humanis, dan Produktif”
            </p>
        </div> --}}

        {{-- Misi --}}
        {{-- <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Misi</h3>
            <ol class="list-decimal list-inside space-y-4 text-gray-700 leading-relaxed">
                <li>
                    <span class="font-semibold">Mewujudkan Kawasan Permukiman Layak Huni:</span>
                    <ul class="list-disc list-inside ml-6 space-y-2">
                        <li>Terwujudnya pemukiman yang sehat dan ramah lingkungan</li>
                        <li>Meningkatkan kapasitas dan kualitas infrastruktur</li>
                        <li>Menjadi bagian dalam mewujudkan Kota Kendari sebagai kota hijau</li>
                    </ul>
                </li>
                <li>
                    <span class="font-semibold">Wujudkan Kelurahan Tipulu yang Humanis dan Produktif:</span>
                    <ul class="list-disc list-inside ml-6 space-y-2">
                        <li>Mewujudkan SDM yang berkualitas dan berkarakter pada budaya kearifan lokal</li>
                        <li>Mewujudkan pengembangan masyarakat yang produktif</li>
                    </ul>
                </li>
            </ol>
        </div>

        Kebijakan --}}
        {{-- <div class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Kebijakan</h3>
            <ol class="list-decimal list-inside space-y-2 text-gray-700 leading-relaxed">
                <li>Penguatan regulasi pemanfaatan ruang bagi peruntukan permukiman</li>
                <li>Pemgembangan permukiman layak huni</li>
                <li>Mengintegrasikan infrastruktur jaringan jalan antar perumahan dan dengan lingkungan sekitarnya</li>
                <li>Pembangunan dan peningkatan kualitas jaringan drainase perkotaan</li>
                <li>Peningkatan kuantitas (debit air) dan kualitas air baku sistem perpipaan dan non perpipaan</li>
                <li>Peningkatan cakupan pelayanan pengelolaan air limbah</li>
                <li>Peningkatan pelayanan sistem persampahan</li>
                <li>Meningkatkan aksesibilitas kawasan untuk sistem proteksi kebakaran dan keadaan darurat</li>
                <li>Penyediaan RTH (Ruang Terbuka Hijau)</li>
                <li>Penguatan kapasitas kelembagaan masyarakat dalam pengelolaan permukiman dan infrastruktur</li>
            </ol>
        </div>

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
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 text-center">
            Visi & Misi Kelurahan Tipulu
        </h1>

        {{-- Visi --}}
        <section class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Visi</h3>
            {!! $landingPage->visi ?? '<p class="text-gray-500 italic">Belum ada data visi yang diinput.</p>' !!}
        </section>

        {{-- Misi --}}
        <section class="mb-10">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Misi</h3>
            {!! $landingPage->misi ?? '<p class="text-gray-500 italic">Belum ada data misi yang diinput.</p>' !!}
        </section>

        <div class="text-center mt-8">
            <a href="{{ url('/#profil') }}"
                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                ← Kembali
            </a>
        </div>
    </div>
</main>
@endsection 
