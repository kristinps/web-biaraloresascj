@extends('layouts.app')

@section('title', $berita['judul'] . ' - Biara Loresa SCJ')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-100 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-primary-700 transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('berita') }}" class="hover:text-primary-700 transition-colors">Berita</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-700 truncate max-w-xs">{{ $berita['judul'] }}</span>
        </nav>
    </div>
</div>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Artikel Utama --}}
            <div class="lg:col-span-2">
                <article class="bg-white rounded-2xl shadow-md overflow-hidden">
                    <img src="{{ $berita['gambar'] }}" alt="{{ $berita['judul'] }}" 
                         class="w-full h-80 object-cover">
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="bg-primary-100 text-primary-700 text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $berita['kategori'] }}
                            </span>
                            <span class="text-gray-400 text-sm">{{ $berita['tanggal'] }}</span>
                            <span class="text-gray-400 text-sm">•</span>
                            <span class="text-gray-500 text-sm">{{ $berita['penulis'] }}</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-serif font-bold text-gray-800 mb-6 leading-snug">
                            {{ $berita['judul'] }}
                        </h1>
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                            <p>{{ $berita['isi'] }}</p>
                        </div>
                        <div class="border-t border-gray-100 mt-8 pt-6">
                            <a href="{{ route('berita') }}" class="inline-flex items-center text-primary-700 font-semibold hover:text-primary-800 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Kembali ke Daftar Berita
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <h3 class="font-serif font-bold text-xl text-gray-800 mb-5">Berita Lainnya</h3>
                    <div class="space-y-4">
                        @foreach($beritaLainnya as $item)
                        <a href="{{ route('berita.show', $item['id']) }}" class="group flex space-x-4 bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                            <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}" 
                                 class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                            <div>
                                <span class="text-xs text-primary-600 font-semibold">{{ $item['kategori'] }}</span>
                                <h4 class="text-sm font-semibold text-gray-800 mt-1 group-hover:text-primary-700 transition-colors leading-snug">
                                    {{ $item['judul'] }}
                                </h4>
                                <p class="text-xs text-gray-400 mt-1">{{ $item['tanggal'] }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
