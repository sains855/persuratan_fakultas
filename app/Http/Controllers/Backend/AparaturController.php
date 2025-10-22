<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Aparatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AparaturController extends Controller
{
    public function index()
    {
        $title = "Aparatur";

        $aparatur = Aparatur::orderBy('posisi', 'asc')->get();

        return view('backend.aparatur.index', compact('title', 'aparatur'));
    }

    public function edit($id)
    {
        $title = "Edit Aparatur";
        $aparatur = Aparatur::find($id);

        return view('backend.aparatur.edit', compact('title', 'aparatur'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'required|unique:aparaturs,nip',
            'nama' => 'required',
            'jabatan' => 'required',
            'pangkat/gol' => 'required',
        ]);

        try {

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                $filename = time() . '-foto-aparatur.' . $file->getClientOriginalExtension();

                // simpan di storage/app/public/aparatur
                $file->storeAs('public/aparatur', $filename);

                // simpan path untuk ditampilkan
                $data['foto'] = 'storage/aparatur/' . $filename;
            }

            Aparatur::create($data);

            return back()->with('success', 'Berhasil menambah data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data');
        }
    }

    public function update(Request $request, $id)
    {
        $aparatur = Aparatur::findOrFail($id);

        $data = $request->validate([
            'nip' => 'required|unique:aparaturs,nip,' . $id . ',id',
            'nama' => 'required',
            'jabatan' => 'required',
            'posisi' => 'required',
            'foto' => 'nullable|mimes:jpg,png,webp,jpeg',
        ]);

        try {
            if ($request->hasFile('foto')) {
                // hapus file lama (langsung, tanpa cek exists)
                Storage::delete(str_replace('storage/', 'public/', $aparatur->foto));

                // upload file baru
                $file = $request->file('foto');
                $filename = time() . '-foto-aparatur.' . $file->getClientOriginalExtension();
                $file->storeAs('public/aparatur', $filename);

                $data['foto'] = 'storage/aparatur/' . $filename;
            } else {
                // tetap gunakan thumbnail lama
                $data['foto'] = $aparatur->foto;
            }

            $aparatur->update($data);

            return redirect('/aparatur')->with('success', 'Berhasil memperbaruhi data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data. ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $aparatur = Aparatur::find($id);

        Storage::delete(str_replace('storage/', 'public/', $aparatur->foto));

        try {
            $aparatur->delete();

            return back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}
