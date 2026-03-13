@extends('layouts.app')

@section('title', 'Berita & Kegiatan - Biara Loresa SCJ')

@section('content')

{{-- Page Header --}}
<section class="py-20 home-enter" data-home-animate>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <p class="text-primary-300 font-semibold tracking-widest uppercase text-sm mb-3 home-enter"
           data-delay="1" data-home-animate>
            Informasi Terkini
        </p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4 home-enter"
            data-delay="2" data-home-animate>
            Berita & Kegiatan
        </h1>
        <p class="text-primary-200 mt-2 max-w-2xl mx-auto leading-relaxed home-enter"
           data-delay="3" data-home-animate>
            Ikuti perkembangan dan kegiatan terbaru Komunitas Biara Loresa SCJ.
        </p>
    </div>
</section>

{{-- Berita Grid --}}
<section class="py-16 home-enter" data-home-animate>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($berita as $item)
            <article class="home-glass-card group overflow-hidden rounded-2xl hover:shadow-lg transition-shadow home-enter"
                     data-delay="{{ min($loop->iteration, 8) }}" data-home-animate>
                <div class="overflow-hidden">
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}" 
                         class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $item['kategori'] }}
                        </span>
                        <span class="text-primary-300 text-xs">{{ $item['tanggal'] }}</span>
                    </div>
                    <h2 class="font-serif font-bold text-xl text-white mb-3 group-hover:text-primary-200 transition-colors leading-snug">
                        {{ $item['judul'] }}
                    </h2>
                    <p class="text-primary-100 text-sm mb-5 leading-relaxed line-clamp-3">
                        {{ $item['ringkasan'] }}
                    </p>
                    <a href="{{ route('berita.show', $item['id']) }}" 
                       class="inline-flex items-center text-white font-semibold text-sm hover:text-primary-200 transition-colors">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

@endsection
