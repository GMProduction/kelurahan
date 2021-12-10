<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Surat;
use App\Models\Syarat;

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
            $syarats = $this->postField('syaratss') === null ? [] : $this->postField('syaratss');
            $surat = new Surat();
            $surat->nama = $this->postField('nama');
            $surat->save();
            $surat->syarat()->attach($syarats);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan ' . $e->getMessage(), 500);
        }
    }

}
