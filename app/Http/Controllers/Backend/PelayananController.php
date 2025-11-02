<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use App\Models\PelayananPersyaratan;
use App\Models\Persyaratan;
use Illuminate\Http\Request;

class PelayananController extends Controller
{
    public function index(Request $request)
    {
        $title = "Pelayanan";

        $query = Pelayanan::with('pelayananPersyaratan.persyaratan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama', 'like', "%{$q}%")
                ->orWhereHas('pelayananPersyaratan.persyaratan', function ($subQuery) use ($q) {
                    $subQuery->where('nama', 'like', "%{$q}%");
                });
        }

        $pelayanan = $query->get();
        $pelayanan = $query->orderBy('nama', 'asc')->paginate(10);
        $persyaratan = Persyaratan::get(['id', 'nama']);

        // Simpan parameter pencarian agar tetap ada saat berpindah halaman
        $pelayanan->appends(['q' => $request->q]);

        return view('backend.pelayanan.index', compact('title', 'pelayanan','persyaratan'))
               ->with('q', $request->q);

    }



    public function edit($id)
    {
        $title = "Edit Pelayanan";
        $pelayanan = Pelayanan::find($id);

        $persyaratan = Persyaratan::get(['id', 'nama']);

        return view('backend.pelayanan.edit', compact('title', 'pelayanan', 'persyaratan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'icon' => 'required',
            'deskripsi' => 'required',
            'persyaratan_id' => 'required',
            'keterangan_surat' => 'nullable', // <-- CHANGED THIS LINE
        ]);
        try {
            $pelayanan_id = Pelayanan::create($data)->id;

            foreach ($data['persyaratan_id'] as $persyaratan_id) {
                PelayananPersyaratan::create([
                    'pelayanan_id' => $pelayanan_id,
                    'persyaratan_id' => $persyaratan_id,
                ]);
            }

            return back()->with('success', 'Berhasil menambah data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data');
        }
    }

    public function update(Request $request, $id)
    {
        $pelayanan = Pelayanan::find($id);

        $data = $request->validate([
            'nama' => 'nullable',
            'icon' => 'required',
            'deskripsi' => 'required',
            'persyaratan_id' => 'required',
            'keterangan_surat' => 'nullable',
        ]);

        try {
            $pelayanan->update($data);

            $pelayanan->pelayananPersyaratan()->delete();

            foreach ($data['persyaratan_id'] as $persyaratan_id) {
                PelayananPersyaratan::create([
                    'pelayanan_id'   => $pelayanan->id,
                    'persyaratan_id' => $persyaratan_id,
                ]);
            }

            return redirect('/pelayanan')->with('success', 'Berhasil update data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update data');
        }
    }


    public function delete($id)
    {
        $pelayanan = Pelayanan::find($id);

        try {
            $pelayanan->delete();

            PelayananPersyaratan::where('pelayanan_id', $id)->delete();

            return back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}
