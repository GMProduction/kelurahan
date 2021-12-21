<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Pengurusan;
use Illuminate\Support\Facades\Auth;

class PengurusanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $pengurusan = Pengurusan::with(['syarat'])->where('user_id', '=', Auth::id())
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
            $pengurusan = Pengurusan::with(['syarat'])->where('user_id', '=', Auth::id())
                ->where('id', '=', $id)
                ->first();
            return $this->jsonResponse('success', 200, $pengurusan);
        } catch (\Exception $e) {
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }
}
