<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Surat;
use App\Models\Syarat;

class SyaratController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (request()->method() === 'POST') {
            $syarat = new Syarat();
            $syarat->nama = $this->postField('nama');
            $syarat->save();
            return redirect()->back()->with('success', 'IT WORKS!');
        }
        $data = Syarat::all();
        return view('admin.syarat')->with(['data' => $data]);
    }

    public function patch()
    {
        $syarat = Syarat::find($this->postField('id-edit'));
        $syarat->update([
            'nama' => $this->postField('nama-edit')
        ]);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            Syarat::destroy($this->postField('id'));
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
