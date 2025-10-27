<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ttd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TtdController extends Controller
{
    public function index()
    {
        $title = "Ttd";

        $Ttd = Ttd::orderBy('posisi', 'asc')->get();

        return view('backend.Ttd.index', compact('title', 'Ttd'));
    }

    public function edit($id)
    {
        $title = "Edit Ttd";
        $Ttd = Ttd::find($id);

        return view('backend.Ttd.edit', compact('title', 'Ttd'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'required|unique:Ttds,nip',
            'nama' => 'required',
            'jabatan' => 'required',
            'pangkat/gol' => 'required',
        ]);

        try {

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                $filename = time() . '-foto-Ttd.' . $file->getClientOriginalExtension();

                // simpan di storage/app/public/Ttd
                $file->storeAs('public/Ttd', $filename);

                // simpan path untuk ditampilkan
                $data['foto'] = 'storage/Ttd/' . $filename;
            }

            Ttd::create($data);

            return back()->with('success', 'Berhasil menambah data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data');
        }
    }

    public function update(Request $request, $id)
    {
        $Ttd = Ttd::findOrFail($id);

        $data = $request->validate([
            'nip' => 'required|unique:Ttds,nip,' . $id . ',id',
            'nama' => 'required',
            'jabatan' => 'required',
            'posisi' => 'required',
            'foto' => 'nullable|mimes:jpg,png,webp,jpeg',
        ]);

        try {
            if ($request->hasFile('foto')) {
                // hapus file lama (langsung, tanpa cek exists)
                Storage::delete(str_replace('storage/', 'public/', $Ttd->foto));

                // upload file baru
                $file = $request->file('foto');
                $filename = time() . '-foto-Ttd.' . $file->getClientOriginalExtension();
                $file->storeAs('public/Ttd', $filename);

                $data['foto'] = 'storage/Ttd/' . $filename;
            } else {
                // tetap gunakan thumbnail lama
                $data['foto'] = $Ttd->foto;
            }

            $Ttd->update($data);

            return redirect('/Ttd')->with('success', 'Berhasil memperbaruhi data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data. ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $Ttd = Ttd::find($id);

        Storage::delete(str_replace('storage/', 'public/', $Ttd->foto));

        try {
            $Ttd->delete();

            return back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}
