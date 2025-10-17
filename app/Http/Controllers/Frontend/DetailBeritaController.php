<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class DetailBeritaController extends Controller
{
    public function index($id)
    {
        $title = "Detail Berita";

        $model = new Berita();

        $berita = $model->find($id);

        $beritaLain = $model->get();

        return view('frontend.detail-berita.index', compact('title', 'model', 'berita', 'beritaLain'));
    }
}
