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
        if ($this->request->method() === 'POST') {
            $user = User::create([
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'roles' => 'warga',
            ]);
            $foto = null;
            $ktp = null;
            if ($fotoFile = $this->request->file('foto')) {
                $extFoto = $fotoFile->getClientOriginalExtension();
                $photoTarget = $user->username . '.' . $extFoto;
                $foto = '/foto/' . $photoTarget;
                $this->uploadImage('foto', $photoTarget, 'foto');
            }

            if ($ktpFile = $this->request->file('ktp')) {
                $extKtp = $ktpFile->getClientOriginalExtension();
                $ktpTarget = $user->username . '.' . $extKtp;
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

    public function patch()
    {
        $data_user = [
            'username' => $this->postField('username-edit')
        ];
        if ($this->postField('password-edit') !== '') {
            $data_user = [
                'username' => $this->postField('username-edit'),
                'password' => Hash::make($this->postField('password-edit'))
            ];
        }
//        dump($data_user);
//        die();
        $warga = Warga::find($this->postField('id-edit'));

        $user = User::find($warga->user_id);
        $user->update($data_user);

        $data_warga = [
            'nama' => $this->postField('nama-edit'),
            'alamat' => $this->postField('alamat-edit'),
            'no_hp' => $this->postField('no_hp-edit'),
            'foto' => $warga->foto,
            'ktp' => $warga->ktp,
        ];

        if ($fotoFile = $this->request->file('foto-edit')) {
            $extFoto = $fotoFile->getClientOriginalExtension();
            $photoTarget = $user->username . '.' . $extFoto;
            $data_warga['foto'] = '/foto/' . $photoTarget;
            $this->uploadImage('foto-edit', $photoTarget, 'foto');
        }

        if ($ktpFile = $this->request->file('ktp-edit')) {
            $extKtp = $ktpFile->getClientOriginalExtension();
            $ktpTarget = $user->username . '.' . $extKtp;
            $data_warga['ktp'] = '/ktp/' . $ktpTarget;
            $this->uploadImage('ktp-edit', $ktpTarget, 'ktp');
        }
        $warga->update($data_warga);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            $warga = Warga::find($this->postField('id'));
            $user = User::find($warga->user_id);
            $warga->delete();
            $user->delete();
            return response()->json([
                'msg' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'gagal ' . $e
            ], 500);
        }
    }
}
