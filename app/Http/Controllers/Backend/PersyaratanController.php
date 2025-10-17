<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Persyaratan;
use Illuminate\Http\Request;

class PersyaratanController extends Controller
{
    public function index(Request $request)
    {
        $title = "Persyaratan";

        $query = Persyaratan::query();

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%')
                ->orWhere('keterangan', 'like', '%' . $request->q . '%');
        }

        $persyaratan = $query->orderBy('nama', 'asc')->paginate(10);

        // Simpan parameter pencarian agar tetap ada saat berpindah halaman
        $persyaratan->appends(['q' => $request->q]);

        return view('backend.persyaratan.index', compact('title', 'persyaratan'))
               ->with('q', $request->q);
    }

    public function edit($id)
    {
        $title = "Edit Persyaratan";
        $persyaratan = Persyaratan::find($id);

        return view('backend.persyaratan.edit', compact('title', 'persyaratan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'keterangan' => 'required'
        ]);

        try {
            Persyaratan::create($data);

            return back()->with('success', 'Berhasil menambah data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data');
        }
    }

    public function update(Request $request, $id)
    {
        $persyaratan = Persyaratan::find($id);
        
        $data = $request->validate([
            'nama' => 'required',
            'keterangan' => 'required'
        ]);

        try {
            $persyaratan->update($data);

            return redirect('/persyaratan')->with('success', 'Berhasil update data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update data');
        }
    }

    public function delete($id)
    {
        $persyaratan = Persyaratan::find($id);

        try {
            $persyaratan->delete();

            return back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}
