<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->away('https://admin.biaraloresa.my.id/dashboard');
        }

        $pendaftaranList = PendaftaranPernikahan::where('email', $user->email)
            ->with('periode')
            ->orderByDesc('created_at')
            ->get();

        return view('user.dashboard', [
            'user' => $user,
            'pendaftaranList' => $pendaftaranList,
        ]);
    }
}
