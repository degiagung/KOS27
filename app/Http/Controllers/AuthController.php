<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\MenusAccess;
use App\Helpers\Master;


class AuthController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan halaman indeks pengguna
        return view('auth.login');
    }

    public function signup()
    {
        return view('auth.signup');
    }

    // Fungsi untuk melakukan proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // $credentials = [
        //     $field => $login,
        //     'password' => $password
        // ];

        if (Auth::attempt($credentials)) {
           
            if ( Auth::user()->roles->first()->role_name == "guest" ) {

                return redirect(route('/'));

            } else {
                Session::put('user_id', Auth::user()->id);
                Session::put('name', Auth::user()->name);
                Session::put('role_id', Auth::user()->role_id);
                Session::put('role_name',  strtolower(Auth::user()->roles->first()->role_name));
                
                
                // dd(Session::get('menu'));
                return redirect()->intended('/dashboard');
            }
            
            // return redirect()->intended('/dashboard');

        } else {
            // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        Session::forget('user_id');
        Session::forget('name');
        Session::forget('role_id');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
