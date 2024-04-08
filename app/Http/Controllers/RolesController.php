<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class RolesController extends Controller
{
    public function index()
    {
    $users = User::where('role', '!=', 'admin')->get();
    $sellers = $users->where('role', 'seller')->take(4);
    return view('dashboard.roles', compact('sellers' , 'users'));
    }
}
