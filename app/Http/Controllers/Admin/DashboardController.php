<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        $users = User::where('role', 'user')->latest()->paginate(10);
        $transactions = Transaction::latest()->paginate(10);
        
        return view('admin.dashboard', compact('videos', 'users', 'transactions'));
    }
}
