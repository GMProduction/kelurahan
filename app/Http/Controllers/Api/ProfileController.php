<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $id = Auth::id();
            $user = User::with('warga')->where('id', '=', $id)
                ->first();
            if ($this->request->method() === 'POST') {
                DB::beginTransaction();
                $user->username = $this->postField('username');
                if ($this->postField('password') !== '') {
                    $user->password = Hash::make($this->postField('password'));
                }
                $user->save();
                $data_warga = [
                    'nama' => $this->postField('nama'),
                    'alamat' => $this->postField('alamat'),
                    'no_hp' => $this->postField('no_hp'),
                ];
                if ($fotoFile = $this->request->file('foto')) {
                    $extFoto = $fotoFile->getClientOriginalExtension();
                    $photoTarget = $user->username . '.' . $extFoto;
                    $data_warga['foto'] = '/foto/' . $photoTarget;
                    $this->uploadImage('foto', $photoTarget, 'foto');
                }

                if ($ktpFile = $this->request->file('ktp')) {
                    $extKtp = $ktpFile->getClientOriginalExtension();
                    $ktpTarget = $user->username . '.' . $extKtp;
                    $data_warga['ktp'] = '/ktp/' . $ktpTarget;
                    $this->uploadImage('ktp', $ktpTarget, 'ktp');
                }
                $user->warga()->update($data_warga);
                DB::commit();
                return $this->jsonResponse('success', 200);
            }
            return $this->jsonResponse('success', 200, $user);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }
}
