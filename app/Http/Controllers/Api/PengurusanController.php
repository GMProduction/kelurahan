<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Pengurusan;
use App\Models\PengurusanSyarat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PengurusanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $pengurusan = Pengurusan::with(['syarat', 'surat'])->where('user_id', '=', Auth::id())
                ->orderBy('id', 'DESC')
                ->get();
            return $this->jsonResponse('success', 200, $pengurusan);
        } catch (\Exception $e) {
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }

    public function detail($id)
    {
        try {
            $pengurusan = Pengurusan::with(['syarat.syarat:id,nama', 'surat:id,nama'])->where('user_id', '=', Auth::id())
                ->where('id', '=', $id)
                ->first();
            if (!$pengurusan) {
                return $this->jsonResponse('Surat Pengurusan Tidak Di Temukan...', 202);
            }
            if ($this->request->method() === 'POST') {
                $syarats = $this->postField('syarat') !== null ? $this->postField('syarat') : [];
                $gambars = $this->request->file('gambar') !== null ? $this->request->file('gambar') : [];
                if (count($syarats) <= 0) {
                    return $this->jsonResponse('harap mengisi syarat dengan lengkap!', 202);
                }

                DB::beginTransaction();
                $p_syarat = $pengurusan->syarat()->delete();
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
                return $this->jsonResponse('success', 200);
            }
            return $this->jsonResponse('success', 200, $pengurusan);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }
}
