<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $title = "Mahasiswa";
        $query = Mahasiswa::query();
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('nim', 'like', '%' . $request->q . '%')
                  ->orWhere('Prodi_jurusan', 'like', '%' . $request->q . '%');
        }
        $mahasiswa = $query->orderBy('nama', 'asc')->paginate(10);
        // Simpan parameter pencarian agar tetap ada saat berpindah halaman
        $mahasiswa->appends(['q' => $request->q]);
        return view('backend.mahasiswa.index', compact('title', 'mahasiswa'))
               ->with('q', $request->q);
    }

    public function edit($id)
    {
        $title = "Edit Mahasiswa";
        $mahasiswa = Mahasiswa::where('nim', $id)->first();
        return view('backend.mahasiswa.edit', compact('title', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'Fakultas' => 'required',
            'Prodi_jurusan' => 'required',
            'alamat' => 'required',
            'No_Hp' => 'nullable',
            'email' => 'required|email|unique:mahasiswas,email'
        ], [
            'nim.unique' => 'NIM sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);
        try {
            Mahasiswa::create($data);
            return back()->with('success', 'Berhasil menambah data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $id . ',nim',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'Fakultas' => 'required',
            'Prodi_jurusan' => 'required',
            'alamat' => 'required',
            'No_Hp' => 'nullable',
            'email' => 'required|email|unique:mahasiswas,email,' . $id . ',nim'
        ], [
            'nim.unique' => 'NIM sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);
        $mahasiswa = Mahasiswa::where('nim', $id);
        try {
            $mahasiswa->update($data);
            return redirect('/mahasiswa')->with('success', 'Berhasil update data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update data');
        }
    }

    public function delete($id)
    {
        $mahasiswa = Mahasiswa::where('nim', $id);
        try {
            $mahasiswa->delete();
            return back()->with('success', 'Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}
