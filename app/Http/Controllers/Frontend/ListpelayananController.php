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


    return view('frontend.list-pelayanan.index', compact('title', 'pelayanan'));
}

}
