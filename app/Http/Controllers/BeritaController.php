<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Berita;

class BeritaController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $data = [
                'judul' => $this->postField('judul'),
                'deskripsi' => $this->postField('deskripsi'),
                'gambar' => null,
            ];

            if ($gambar = $this->request->file('gambar')) {
                $extFoto = $gambar->getClientOriginalExtension();
                $photoTarget = uniqid('berita-') . '.' . $extFoto;
                $data['gambar'] = '/berita/' . $photoTarget;
                $this->uploadImage('gambar', $photoTarget, 'berita');
            }

            Berita::create($data);
            return redirect()->back()->with('success');
        }
        $berita = Berita::all();
        return view('admin.berita')->with(['data' => $berita]);
    }
}
