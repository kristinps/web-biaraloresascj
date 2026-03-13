@extends('layouts.app')

@section('title', 'Galeri - Biara Loresa SCJ')

@section('content')

{{-- Page Header --}}
<div class="py-20 home-enter" data-home-animate data-delay="1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <p class="text-primary-300 font-semibold tracking-widest uppercase text-sm mb-2">Foto & Dokumentasi</p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold">Galeri</h1>
        <p class="text-primary-200 mt-4 max-w-2xl mx-auto">Kilas balik momen-momen berharga kehidupan dan pelayanan komunitas</p>
    </div>
</div>

{{-- Filter --}}
<div class="home-enter" data-home-animate data-delay="2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-wrap gap-2 justify-center home-glass-card rounded-full px-4 py-3" id="filter-buttons">
            <button onclick="filterGaleri('semua')" class="filter-btn active px-4 py-2 rounded-full text-sm font-semibold transition-colors bg-white/20 text-white">
                Semua
            </button>
            <button onclick="filterGaleri('Bangunan')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold transition-colors bg-white/5 text-primary-100 hover:bg-white/10 hover:text-white">
                Bangunan
            </button>
            <button onclick="filterGaleri('Liturgi')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold transition-colors bg-white/5 text-primary-100 hover:bg-white/10 hover:text-white">
                Liturgi
            </button>
            <button onclick="filterGaleri('Komunitas')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold transition-colors bg-white/5 text-primary-100 hover:bg-white/10 hover:text-white">
                Komunitas
            </button>
            <button onclick="filterGaleri('Fasilitas')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold transition-colors bg-white/5 text-primary-100 hover:bg-white/10 hover:text-white">
                Fasilitas
            </button>
            <button onclick="filterGaleri('Taman')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold transition-colors bg-white/5 text-primary-100 hover:bg-white/10 hover:text-white">
                Taman
            </button>
            <button onclick="filterGaleri('Pembinaan')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold transition-colors bg-white/5 text-primary-100 hover:bg-white/10 hover:text-white">
                Pembinaan
            </button>
        </div>
    </div>
</div>

{{-- Galeri Grid --}}
<section class="py-12 home-enter" data-home-animate data-delay="3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="galeri-grid">
            @foreach($galeri as $foto)
            <div class="galeri-item group relative overflow-hidden rounded-xl cursor-pointer shadow-md hover:shadow-xl transition-shadow" 
                 data-kategori="{{ $foto['kategori'] }}"
                 onclick="bukaLightbox('{{ $foto['gambar'] }}', '{{ $foto['judul'] }}', '{{ $foto['kategori'] }}')">
                <img src="{{ $foto['gambar'] }}" alt="{{ $foto['judul'] }}" 
                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-3 left-3 right-3">
                        <p class="text-white font-semibold text-sm">{{ $foto['judul'] }}</p>
                        <span class="text-xs text-primary-300">{{ $foto['kategori'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 bg-black/90 z-[100] hidden items-center justify-center p-4" onclick="tutupLightbox()">
    <button class="absolute top-4 right-4 text-white/80 hover:text-white text-4xl leading-none z-10">&times;</button>
    <div class="max-w-4xl w-full" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" class="w-full max-h-[75vh] object-contain rounded-lg shadow-2xl">
        <div class="mt-4 text-center">
            <p id="lightbox-title" class="text-white font-semibold text-lg"></p>
            <p id="lightbox-kategori" class="text-primary-300 text-sm mt-1"></p>
        </div>
    </div>
</div>

<script>
function filterGaleri(kategori) {
    const items = document.querySelectorAll('.galeri-item');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => {
        btn.classList.remove('bg-white/20', 'text-white');
        btn.classList.add('bg-white/5', 'text-primary-100');
    });
    event.target.classList.remove('bg-white/5', 'text-primary-100');
    event.target.classList.add('bg-white/20', 'text-white');
    
    items.forEach(item => {
        if (kategori === 'semua' || item.dataset.kategori === kategori) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function bukaLightbox(gambar, judul, kategori) {
    document.getElementById('lightbox-img').src = gambar;
    document.getElementById('lightbox-title').textContent = judul;
    document.getElementById('lightbox-kategori').textContent = kategori;
    const lb = document.getElementById('lightbox');
    lb.classList.remove('hidden');
    lb.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function tutupLightbox() {
    const lb = document.getElementById('lightbox');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupLightbox();
});
</script>

@endsection
