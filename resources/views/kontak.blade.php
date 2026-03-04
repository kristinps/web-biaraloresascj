@extends('layouts.app')

@section('title', 'Kontak - Biara Loresa SCJ')

@section('content')

{{-- Page Header --}}
<div class="bg-gradient-to-br from-primary-900 to-primary-700 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-primary-300 font-semibold tracking-widest uppercase text-sm mb-2">Hubungi Kami</p>
        <h1 class="text-4xl md:text-5xl font-serif font-bold">Kontak</h1>
        <p class="text-primary-200 mt-4 max-w-2xl mx-auto">Kami dengan senang hati siap mendengar dan membantu Anda</p>
    </div>
</div>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-200 text-green-800 rounded-xl p-5 flex items-center space-x-3">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Info Kontak --}}
            <div class="lg:col-span-1 space-y-6">
                <div>
                    <h2 class="text-2xl font-serif font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Alamat</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Jl. Biara Loresa No. 1<br>
                                Kecamatan Damai, Kutai Barat<br>
                                Kalimantan Timur 75562
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Telepon</h3>
                            <p class="text-gray-600 text-sm">+62 (0541) 123-456</p>
                            <p class="text-gray-600 text-sm">+62 812-3456-7890 (WhatsApp)</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                            <p class="text-gray-600 text-sm">info@biaraloresa-scj.org</p>
                            <p class="text-gray-600 text-sm">sekretariat@biaraloresa-scj.org</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Jam Sekretariat</h3>
                            <p class="text-gray-600 text-sm">Senin - Jumat: 08.00 - 16.00</p>
                            <p class="text-gray-600 text-sm">Sabtu: 08.00 - 12.00</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Kontak --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-2xl font-serif font-bold text-gray-800 mb-2">Kirim Pesan</h2>
                    <p class="text-gray-500 text-sm mb-8">Isi formulir di bawah ini dan kami akan merespons secepatnya.</p>

                    <form action="{{ route('kontak.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('nama') border-red-400 @enderror"
                                    placeholder="Nama Anda">
                                @error('nama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('email') border-red-400 @enderror"
                                    placeholder="email@contoh.com">
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="subjek" class="block text-sm font-semibold text-gray-700 mb-2">
                                Subjek <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('subjek') border-red-400 @enderror"
                                placeholder="Subjek pesan Anda">
                            @error('subjek')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pesan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="pesan" name="pesan" rows="6"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none @error('pesan') border-red-400 @enderror"
                                placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                            @error('pesan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                            class="w-full bg-primary-700 text-white py-3 rounded-xl font-semibold hover:bg-primary-800 transition-colors flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span>Kirim Pesan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
