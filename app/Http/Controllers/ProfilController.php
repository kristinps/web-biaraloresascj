<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $pimpinan = [
            [
                'nama' => 'Rm. Antonius Budi, SCJ',
                'jabatan' => 'Superior Komunitas',
                'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face',
            ],
            [
                'nama' => 'Rm. Yohanes Kristanto, SCJ',
                'jabatan' => 'Wakil Superior',
                'foto' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop&crop=face',
            ],
            [
                'nama' => 'Rm. Petrus Sugiarto, SCJ',
                'jabatan' => 'Ekonom Komunitas',
                'foto' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face',
            ],
        ];

        return view('profil', compact('pimpinan'));
    }
}
