<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Pengurusan;
use App\Models\Surat;
use App\Models\Syarat;

class PengurusanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (request()->method() === 'POST') {
//            $syarats = $this->postField('syarats') === null ? [] : $this->postField('syarats');
//            $surat = new Surat();
//            $surat->nama = $this->postField('nama');
//            $surat->save();
//            $surat->syarat()->attach($syarats);
//            return redirect()->back()->with('success');
        }
        $data = Pengurusan::with(['syarat', 'user.warga', 'surat'])->get();
        $syarats = Syarat::all();
        return view('admin.pengurusan')->with(['data' => $data, 'syarats' => $syarats]);
    }

    public function getSyarats()
    {
        try {
            $pengurusan = Pengurusan::with(['surat.syarat', 'syarat'])->where('id', '=', $this->field('id'))
                ->first();
            if (!$pengurusan) {
                return $this->jsonResponse('gagal', 500);
            }
            return $this->jsonResponse('success', 200, $pengurusan);
        } catch (\Exception $e) {
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }

    public function patch()
    {
        try {
            $status = $this->postField('status');
            $id = $this->postField('id');
            $pengurusan = Pengurusan::find($id);
            if(!$pengurusan) {
                return $this->jsonResponse('gagal', 500);
            }
            $pengurusan->update([
                'status' => $status
            ]);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }
}
