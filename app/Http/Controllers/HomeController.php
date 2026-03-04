<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $beritaTerbaru = [
            [
                'id' => 1,
                'judul' => 'Perayaan Hari Raya Hati Kudus Yesus',
                'tanggal' => '15 Juni 2024',
                'ringkasan' => 'Komunitas Biara Loresa SCJ merayakan Hari Raya Hati Kudus Yesus dengan penuh sukacita dan devosi yang mendalam.',
                'gambar' => 'https://images.unsplash.com/photo-1438232992991-995b671e4b8d?w=600&h=400&fit=crop',
                'kategori' => 'Liturgi',
            ],
            [
                'id' => 2,
                'judul' => 'Retret Tahunan Komunitas SCJ',
                'tanggal' => '5 Juli 2024',
                'ringkasan' => 'Para frater dan imam SCJ mengikuti retret tahunan sebagai sarana pembaruan spiritual dan komunitas.',
                'gambar' => 'https://images.unsplash.com/photo-1507692049790-de58290a4334?w=600&h=400&fit=crop',
                'kategori' => 'Komunitas',
            ],
            [
                'id' => 3,
                'judul' => 'Penerimaan Novisiat Angkatan Baru',
                'tanggal' => '20 Agustus 2024',
                'ringkasan' => 'Biara Loresa SCJ menyambut dengan gembira para calon novis baru yang memulai perjalanan panggilan mereka.',
                'gambar' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=600&h=400&fit=crop',
                'kategori' => 'Pembinaan',
            ],
        ];

        return view('home', compact('beritaTerbaru'));
    }
}
