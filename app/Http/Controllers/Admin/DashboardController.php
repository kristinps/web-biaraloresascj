<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function list(Request $request)
    {
        $query = PendaftaranPernikahan::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pria', 'like', "%{$search}%")
                  ->orWhere('nama_wanita', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendaftaran = $query->paginate(15);
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.pendaftaran.index', compact('pendaftaran', 'routePrefix'));
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        return view('admin.pendaftaran.show', compact('pendaftaran', 'routePrefix'));
    }
}
