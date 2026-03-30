<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;

class AdminController extends Controller
{
    public function dashboard()
{
    if (auth()->user()->role !== 'admin') {
        return redirect('/rooms'); // 🔥 đá user về rooms
    }

    return view('admin.dashboard', [
        'totalUsers' => \App\Models\User::count(),
        'totalRooms' => \App\Models\Room::count(),
    ]);
}
}