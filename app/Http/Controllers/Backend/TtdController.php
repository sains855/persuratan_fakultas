<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ttd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TtdController extends Controller
{
    /**
     * Menampilkan semua data TTD.
     */
    public function index()
    {
        $title = "Ttd";
        $Ttd = Ttd::orderBy('posisi', 'asc')->get();

        return view('backend.Ttd.index', compact('title', 'Ttd'));
    }

    /**
     * Menampilkan form edit TTD.
     */
    public function edit($id)
    {
        $title = "Edit Ttd";
        $Ttd = Ttd::findOrFail($id);

        return view('backend.Ttd.edit', compact('title', 'Ttd'));
    }

    /**
     * Menyimpan data TTD baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'required|unique:ttds,nip',
            'nama' => 'required',
            'jabatan' => 'required',
            'pangkat_golruang' => 'required',
            'fakultas' => 'required',
            'posisi' => 'required|unique:ttds,posisi',
            'foto' => 'nullable|mimes:jpg,png,webp,jpeg',
        ]);

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '-foto-Ttd.' . $file->getClientOriginalExtension();

                // Simpan di storage/app/public/Ttd
                $file->storeAs('public/Ttd', $filename);

                // Simpan path untuk ditampilkan di view
                $data['foto'] = 'storage/Ttd/' . $filename;
            }

            Ttd::create($data);

            return back()->with('success', 'Berhasil menambah data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data. ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data TTD.
     */
    public function update(Request $request, $id)
    {
        $Ttd = Ttd::findOrFail($id);

        $data = $request->validate([
            'nip' => 'required|unique:ttds,nip,' . $id . ',id',
            'nama' => 'required',
            'jabatan' => 'required',
            'pangkat_golruang' => 'required',
            'fakultas' => 'required',
            'posisi' => 'required|unique:ttds,posisi,' . $id . ',id',
            'foto' => 'nullable|mimes:jpg,png,webp,jpeg',
        ]);

        try {
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($Ttd->foto) {
                    Storage::delete(str_replace('storage/', 'public/', $Ttd->foto));
                }

                // Upload foto baru
                $file = $request->file('foto');
                $filename = time() . '-foto-Ttd.' . $file->getClientOriginalExtension();
                $file->storeAs('public/Ttd', $filename);

                $data['foto'] = 'storage/Ttd/' . $filename;
            } else {
                // Gunakan foto lama jika tidak ada upload baru
                $data['foto'] = $Ttd->foto;
            }

            $Ttd->update($data);

            return redirect('/Ttd')->with('success', 'Berhasil memperbarui data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data. ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data TTD.
     */
    public function delete($id)
    {
        $Ttd = Ttd::findOrFail($id);

        try {
            // Hapus file foto dari storage
            if ($Ttd->foto) {
                Storage::delete(str_replace('storage/', 'public/', $Ttd->foto));
            }

            $Ttd->delete();

            return back()->with('success', 'Berhasil menghapus data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data. ' . $e->getMessage());
        }
    }
}
