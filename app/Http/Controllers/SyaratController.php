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
}
