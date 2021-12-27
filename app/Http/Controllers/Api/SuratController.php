<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Pengurusan;
use App\Models\PengurusanSyarat;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SuratController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList()
    {
        try {
            $surat = Surat::with('syarat:id,nama')->get(['id', 'nama']);
            return $this->jsonResponse('success', 200, $surat);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan ' . $e->getMessage(), 500);
        }
    }

    public function getDetail($id)
    {
        try {
            $user = Auth::id();
            $surat = Surat::with('syarat:id,nama')->first(['id', 'nama']);
            if (!$surat) {
                return $this->jsonResponse('Surat Tidak Di Temukan', 202);
            }
            if ($this->request->method() === 'POST') {
                $syarats = $this->postField('syarat') !== null ? $this->postField('syarat') : [];
                $gambars = $this->request->file('gambar') !== null ? $this->request->file('gambar') : [];
                if (count($syarats) <= 0 ) {
                    return $this->jsonResponse('harap mengisi syarat dengan lengkap!', 202);
                }
                $data = [
                    'syarat' => $syarats,
                    'gambar' => $gambars
                ];
                DB::beginTransaction();
                $pengurusan = Pengurusan::create([
                    'surat_id' => $surat->id,
                    'user_id' => $user,
                    'status' => 'menunggu'
                ]);

                foreach ($syarats as $key => $value) {
                    $data_syarat = [
                        'pengurusan_id' => $pengurusan->id,
                        'syarat_id' => $value,
                        'foto' => null
                    ];
                    if ($this->request->file('gambar')[$key]) {
                        $foto = $this->request->file('gambar')[$key];
                        $ext = $foto->getClientOriginalExtension();
                        $photoTarget = uniqid('image-syarat-') . '.' . $ext;
                        $data_syarat['foto'] = '/syarat/' . $photoTarget;
                        $file = $this->request->file('gambar')[$key];
                        Storage::disk('syarat')->put($photoTarget, File::get($file));
                    }
                    PengurusanSyarat::create($data_syarat);
                }
                DB::commit();
                return $this->jsonResponse('success', 200, $data);
            }

            return $this->jsonResponse('success', 200, $surat);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('Terjadi Kesalahan ' . $e->getMessage(), 500);
        }
    }



}
