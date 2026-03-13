@extends('layouts.app')

@section('title', $berita['judul'] . ' - Biara Loresa SCJ')

@section('content')

{{-- Breadcrumb --}}
<div class="py-4 bg-gradient-to-r from-primary-900/80 via-slate-900/80 to-primary-700/80 border-b border-white/10 home-enter"
     data-home-animate>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm text-primary-200">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('berita') }}" class="hover:text-white transition-colors">Berita</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white/80 truncate max-w-xs">{{ $berita['judul'] }}</span>
        </nav>
    </div>
</div>

<section class="py-16 home-enter" data-home-animate>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Artikel Utama --}}
            <div class="lg:col-span-2">
                <article class="home-glass-card rounded-2xl overflow-hidden home-enter" data-delay="1" data-home-animate>
                    <img src="{{ $berita['gambar'] }}" alt="{{ $berita['judul'] }}" 
                         class="w-full h-80 object-cover">
                    <div class="p-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $berita['kategori'] }}
                            </span>
                            <span class="text-primary-300 text-sm">{{ $berita['tanggal'] }}</span>
                            <span class="text-primary-300 text-sm">•</span>
                            <span class="text-primary-200 text-sm">{{ $berita['penulis'] }}</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-serif font-bold text-white mb-6 leading-snug">
                            {{ $berita['judul'] }}
                        </h1>
                        <div class="text-primary-100 leading-relaxed space-y-4">
                            <p>{{ $berita['isi'] }}</p>
                        </div>
                        <div class="border-t border-white/10 mt-8 pt-6">
                            <a href="{{ route('berita') }}" class="inline-flex items-center text-white font-semibold hover:text-primary-200 transition-colors">
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
                <div class="sticky top-24 space-y-4">
                    <h3 class="font-serif font-bold text-xl text-white mb-5 home-enter" data-delay="2" data-home-animate>
                        Berita Lainnya
                    </h3>
                    <div class="space-y-4">
                        @foreach($beritaLainnya as $item)
                        <a href="{{ route('berita.show', $item['id']) }}"
                           class="group flex space-x-4 home-glass-card rounded-xl p-4 hover:shadow-lg transition-shadow home-enter"
                           data-delay="{{ min($loop->iteration + 2, 8) }}" data-home-animate>
                            <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}" 
                                 class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                            <div>
                                <span class="text-xs text-primary-300 font-semibold">{{ $item['kategori'] }}</span>
                                <h4 class="text-sm font-semibold text-white mt-1 group-hover:text-primary-200 transition-colors leading-snug">
                                    {{ $item['judul'] }}
                                </h4>
                                <p class="text-xs text-primary-300 mt-1">{{ $item['tanggal'] }}</p>
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
