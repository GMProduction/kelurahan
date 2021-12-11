<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Surat;

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


}
