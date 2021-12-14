<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Surat;
use App\Models\Syarat;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class SuratController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (request()->method() === 'POST') {
            $syarats = $this->postField('syarats') === null ? [] : $this->postField('syarats');
            $surat = new Surat();
            $surat->nama = $this->postField('nama');
            $surat->save();
            $surat->syarat()->attach($syarats);
            return redirect()->back()->with('success');
        }
        $data = Surat::with('syarat')->get();
        $syarats = Syarat::all();
        return view('admin.surat')->with(['data' => $data, 'syarats' => $syarats]);
    }

    public function store()
    {
        try {
            $syarats = $this->postField('syarats') === null ? [] : $this->postField('syarats');
            $surat = new Surat();
            $surat->nama = $this->postField('nama');
            $surat->save();
            $surat->syarat()->attach($syarats);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan ' . $e->getMessage(), 500);
        }
    }

    public function getSyarats()
    {
        try {
            $surat = Surat::with('syarat')->where('id', '=', $this->field('id'))
                ->first();
            if (!$surat) {
                return $this->jsonResponse('Terjadi Kesalahan ', 500);
            }
            return $this->jsonResponse('success', 200, $surat);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan ' . $e->getMessage(), 500);
        }
    }

    public function patch()
    {
        $surat = Surat::find($this->postField('id-edit'));

        $surat->update([
            'nama' => $this->postField('nama-edit')
        ]);
        $syarat = $this->postField('syarats-edit') === null ? [] : $this->postField('syarats-edit');
        $surat->syarat()->sync($syarat);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            Surat::destroy($this->postField('id'));
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
