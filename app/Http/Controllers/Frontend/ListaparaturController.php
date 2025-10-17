<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Aparatur;
use Illuminate\Http\Request;

class ListaparaturController extends Controller
{
    public function index()
    {
        $aparatur = Aparatur::all();
        return view('frontend.aparatur.index', compact('aparatur'));
    }
}
