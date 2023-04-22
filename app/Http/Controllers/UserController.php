<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Method untuk Menambah User Baru
    public function store(Request $request)
    {
        $user = new User;

        $user->username = $request->username;
        $user->firstname = $request->first;
        $user->lastname = $request->last;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        if ($user) {
            return('Menambah User Berhasil');
        }  
    }

}
