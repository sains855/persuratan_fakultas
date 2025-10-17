<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $title = "Berita";


        $berita = Berita::get();

        return view('backend.berita.index', compact('title', 'berita'));
    }

    public function edit($id)
    {
        $title = "Edit Berita";
        $berita = Berita::find($id);

        return view('backend.berita.edit', compact('title', 'berita'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'required|mimes:jpg,png,webp,jpeg',
        ]);

        try {

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');

                $filename = time() . '-thumbnail.' . $file->getClientOriginalExtension();

                // simpan di storage/app/public/berita
                $file->storeAs('public/berita', $filename);

                // simpan path untuk ditampilkan
                $data['thumbnail'] = 'storage/berita/' . $filename;
            }

            $data['tgl_posting'] = Carbon::now();

            Berita::create($data);

            return back()->with('success', 'Berhasil menambah data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data');
        }
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            if ($request->hasFile('thumbnail')) {
                // hapus file lama (langsung, tanpa cek exists)
                Storage::delete(str_replace('storage/', 'public/', $berita->thumbnail));

                // upload file baru
                $file = $request->file('thumbnail');
                $filename = time() . '-thumbnail.' . $file->getClientOriginalExtension();
                $file->storeAs('public/berita', $filename);

                $data['thumbnail'] = 'storage/berita/' . $filename;
            } else {
                // tetap gunakan thumbnail lama
                $data['thumbnail'] = $berita->thumbnail;
            }

            $data['tgl_posting'] = Carbon::now();

            $berita->update($data);

            return redirect('/berita')->with('success', 'Berhasil memperbaruhi data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data. ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $berita = Berita::find($id);

        Storage::delete(str_replace('storage/', 'public/', $berita->thumbnail));

        try {
            $berita->delete();

            return back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}
