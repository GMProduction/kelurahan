<?php


namespace App\Http\Controllers\Api;


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
        try {
            $berita = Berita::all();
            return $this->jsonResponse('success', 200, $berita);
        } catch (\Exception $e) {
            return $this->jsonResponse('Gagal ' . $e->getMessage(), 500);
        }
    }

    public function detail($id)
    {
        try {
            $berita = Berita::where('id', '=', $id)->first();
            if (!$berita) {
                return $this->jsonResponse('Berita Tidak Di Temukan!', 202, $berita);
            }
            return $this->jsonResponse('success', 200, $berita);
        } catch (\Exception $e) {
            return $this->jsonResponse('Gagal ' . $e->getMessage(), 500);
        }
    }
}
