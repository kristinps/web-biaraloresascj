<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = [
            ['judul' => 'Kapel Biara', 'gambar' => 'https://images.unsplash.com/photo-1438032005730-c779502df39b?w=600&h=400&fit=crop', 'kategori' => 'Bangunan'],
            ['judul' => 'Taman Meditasi', 'gambar' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=600&h=400&fit=crop', 'kategori' => 'Taman'],
            ['judul' => 'Misa Komunitas', 'gambar' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=600&h=400&fit=crop', 'kategori' => 'Liturgi'],
            ['judul' => 'Perpustakaan', 'gambar' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop', 'kategori' => 'Fasilitas'],
            ['judul' => 'Aula Pertemuan', 'gambar' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop', 'kategori' => 'Fasilitas'],
            ['judul' => 'Perayaan Paskah', 'gambar' => 'https://images.unsplash.com/photo-1508739773434-c26b3d09e071?w=600&h=400&fit=crop', 'kategori' => 'Liturgi'],
            ['judul' => 'Kebun Biara', 'gambar' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=600&h=400&fit=crop', 'kategori' => 'Taman'],
            ['judul' => 'Aktivitas Komunitas', 'gambar' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&h=400&fit=crop', 'kategori' => 'Komunitas'],
            ['judul' => 'Momen Doa Bersama', 'gambar' => 'https://images.unsplash.com/photo-1507692049790-de58290a4334?w=600&h=400&fit=crop', 'kategori' => 'Komunitas'],
            ['judul' => 'Gerbang Biara', 'gambar' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=600&h=400&fit=crop', 'kategori' => 'Bangunan'],
            ['judul' => 'Ruang Refektori', 'gambar' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop', 'kategori' => 'Fasilitas'],
            ['judul' => 'Momen Pelantikan', 'gambar' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=600&h=400&fit=crop', 'kategori' => 'Pembinaan'],
        ];

        return view('galeri', compact('galeri'));
    }
}
