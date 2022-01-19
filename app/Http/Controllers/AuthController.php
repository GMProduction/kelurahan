<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        if ($this->request->method() === 'POST') {
            $credentials = [
                'username' => $this->postField('username'),
                'password' => $this->postField('password'),
            ];
            if($this->isAuth($credentials)) {
                return redirect('/admin');
            }
            return Redirect::back()->withErrors(['failed', 'Periksa Kembali Username dan Password Anda']);
        }
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
