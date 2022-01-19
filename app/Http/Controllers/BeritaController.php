<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Berita;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Facades\Hash;

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

    public function patch()
    {

        $berita = Berita::find($this->postField('id-edit'));

        $data = [
            'judul' => $this->postField('judul-edit'),
            'deskripsi' => $this->postField('deskripsi-edit'),
        ];

        if ($gambar = $this->request->file('gambar-edit')) {
            $extFoto = $gambar->getClientOriginalExtension();
            $photoTarget = uniqid('berita-') . '.' . $extFoto;
            $data['gambar'] = '/berita/' . $photoTarget;
            $this->uploadImage('gambar-edit', $photoTarget, 'berita');
        }
        $berita->update($data);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            Berita::destroy($this->postField('id'));
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
