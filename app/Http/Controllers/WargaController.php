<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Facades\Hash;

class WargaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if($this->request->method() === 'POST') {
            $user = User::create([
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'roles' => 'warga',
            ]);
            $foto = null;
            $ktp = null;
            if ($fotoFile = $this->request->file('foto')) {
                $extFoto = $fotoFile->getClientOriginalExtension();
                $photoTarget = $user->username .'.'. $extFoto;
                $foto = '/foto/' . $photoTarget;
                $this->uploadImage('foto', $photoTarget, 'foto');
            }

            if ($ktpFile = $this->request->file('ktp')) {
                $extKtp = $ktpFile->getClientOriginalExtension();
                $ktpTarget = $user->username .'.'. $extKtp;
                $ktp = '/ktp/' . $ktpTarget;
                $this->uploadImage('ktp', $ktpTarget, 'ktp');
            }


            Warga::create([
                'user_id' => $user->id,
                'nama' => $this->postField('nama'),
                'alamat' => $this->postField('alamat'),
                'no_hp' => $this->postField('no_hp'),
                'foto' => $foto,
                'ktp' => $ktp,
            ]);
            return redirect()->back()->with('success');
        }
        $data = Warga::with('user')->get();
        return view('admin.warga')->with(['data' => $data]);
    }
}
