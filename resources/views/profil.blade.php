@extends('layouts.app')

@section('title', 'Profil - Biara Loresa SCJ')

@section('content')

{{-- Page Header --}}
<div class="bg-gradient-to-br from-primary-900 to-primary-700 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-primary-300 font-semibold tracking-widest uppercase text-sm mb-2">Siapa Kami</p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold">Profil Komunitas</h1>
        <p class="text-primary-200 mt-4 max-w-2xl mx-auto">Mengenal lebih dekat Biara Loresa SCJ dan misi pelayanannya</p>
    </div>
</div>

{{-- Sejarah --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-primary-600 font-semibold tracking-widest uppercase text-sm mb-2">Sejarah</p>
                <h2 class="section-title">Berdirinya Biara Loresa SCJ</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>
                        Biara Loresa SCJ didirikan pada tahun 1999 sebagai bagian dari ekspansi misi 
                        Serikat Imam-imam Hati Kudus Yesus (SCJ) di Kalimantan. Nama "Loresa" diambil 
                        dari salah satu tokoh setempat yang berjasa dalam perkembangan Gereja Katolik 
                        di wilayah ini.
                    </p>
                    <p>
                        Kongregasi SCJ sendiri didirikan oleh Pater Leon Dehon pada tahun 1878 di 
                        Saint-Quentin, Perancis. Spiritualitas kongregasi berpusat pada Hati Kudus 
                        Yesus yang menjadi simbol kasih Allah yang tak terbatas bagi umat manusia.
                    </p>
                    <p>
                        Sejak berdiri, Biara Loresa SCJ telah menjadi pusat pembinaan calon-calon 
                        imam dan bruder SCJ, serta pusat pelayanan pastoral bagi umat Katolik 
                        di wilayah Kalimantan Timur dan sekitarnya.
                    </p>
                </div>
            </div>
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=700&h=500&fit=crop" 
                     alt="Sejarah Biara" class="w-full rounded-2xl shadow-xl">
                <div class="absolute top-4 left-4 bg-primary-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Sejak 1999
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Visi Misi --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-primary-600 font-semibold tracking-widest uppercase text-sm mb-2">Arah Pelayanan</p>
            <h2 class="section-title">Visi & Misi</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-md border-l-4 border-primary-600">
                <div class="flex items-center mb-5">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-gray-800">Visi</h3>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi komunitas religius yang hidup sungguh-sungguh dari kasih Hati Kudus Yesus, 
                    menjadi tanda kasih Allah yang nyata di tengah masyarakat, dan mewartakan keselamatan 
                    Kristus kepada semua orang tanpa terkecuali.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-md border-l-4 border-gold-500">
                <div class="flex items-center mb-5">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-gray-800">Misi</h3>
                </div>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                        <span class="text-primary-600 mr-2 mt-1">✦</span>
                        Membina calon imam dan bruder SCJ yang berkualitas dan bersemangat misionaris
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary-600 mr-2 mt-1">✦</span>
                        Melayani umat melalui karya pastoral di paroki-paroki dan wilayah terpencil
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary-600 mr-2 mt-1">✦</span>
                        Menjalankan karya sosial untuk membantu masyarakat yang membutuhkan
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary-600 mr-2 mt-1">✦</span>
                        Membangun dialog dan kerjasama antar umat beragama
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- Pimpinan --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-primary-600 font-semibold tracking-widest uppercase text-sm mb-2">Kepemimpinan</p>
            <h2 class="section-title">Pimpinan Komunitas</h2>
            <p class="section-subtitle">Para imam yang memimpin dan melayani komunitas Biara Loresa SCJ</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            @foreach($pimpinan as $person)
            <div class="text-center group">
                <div class="relative inline-block mb-4">
                    <img src="{{ $person['foto'] }}" alt="{{ $person['nama'] }}" 
                         class="w-32 h-32 rounded-full mx-auto object-cover shadow-lg group-hover:shadow-xl transition-shadow border-4 border-primary-100">
                    <div class="absolute bottom-0 right-0 w-8 h-8 bg-primary-700 rounded-full flex items-center justify-center border-2 border-white">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11 2v6H5v2h6v12h2V10h6V8h-6V2z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-serif font-bold text-gray-800 text-lg">{{ $person['nama'] }}</h3>
                <p class="text-primary-600 text-sm font-medium mt-1">{{ $person['jabatan'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Fasilitas --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-primary-600 font-semibold tracking-widest uppercase text-sm mb-2">Sarana & Prasarana</p>
            <h2 class="section-title">Fasilitas Biara</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
            $fasilitas = [
                ['nama' => 'Kapel', 'ikon' => '⛪'],
                ['nama' => 'Perpustakaan', 'ikon' => '📚'],
                ['nama' => 'Taman Meditasi', 'ikon' => '🌿'],
                ['nama' => 'Aula Serbaguna', 'ikon' => '🏛️'],
                ['nama' => 'Asrama', 'ikon' => '🏠'],
                ['nama' => 'Lapangan Olahraga', 'ikon' => '⚽'],
            ];
            @endphp
            @foreach($fasilitas as $item)
            <div class="bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="text-4xl mb-3">{{ $item['ikon'] }}</div>
                <div class="text-sm font-semibold text-gray-700">{{ $item['nama'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
