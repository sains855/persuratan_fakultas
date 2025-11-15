<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use Illuminate\Http\Request;

class ListpelayananController extends Controller
{
    public function index()
    {
        $title = 'List Pelayanan';
        // Perbaikan: Ambil semua data pelayanan tanpa kondisi where yang tidak lengkap
        $pelayanan = Pelayanan::all();

        // Atau jika ingin yang aktif saja (jika ada kolom status):
        // $pelayanan = Pelayanan::where('status', 'aktif')->get();

        return view('frontend.Beranda.index', compact('title', 'pelayanan'));
    }
}
