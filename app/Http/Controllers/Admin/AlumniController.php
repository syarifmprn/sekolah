<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%")
                  ->orWhere('testimoni', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        if ($request->filled('tampil')) {
            $query->where('tampil', $request->tampil);
        }

        $data = $query->paginate(10)->withQueryString();

        $tahunList = Alumni::whereNotNull('tahun_lulus')
            ->select('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus', 'desc')
            ->pluck('tahun_lulus');

        $jurusanList = Alumni::whereNotNull('jurusan')
            ->where('jurusan', '!=', '')
            ->select('jurusan')
            ->distinct()
            ->orderBy('jurusan')
            ->pluck('jurusan');

        $stats = [
            'total_alumni' => Alumni::count(),
            'total_tampil' => Alumni::where('tampil', 'ya')->count(),
            'total_angkatan' => Alumni::whereNotNull('tahun_lulus')->distinct()->count('tahun_lulus'),
            'total_testimoni' => Alumni::whereNotNull('testimoni')->where('testimoni', '!=', '')->count(),
        ];

        return view('admin.alumni.index', compact('data', 'tahunList', 'jurusanList', 'stats'));
    }

    public function create()
    {
        return view('admin.alumni.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|digits:4|min:1970|max:2099',
            'jurusan' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pekerjaan' => 'required|string|max:100',
            'instansi' => 'required|string|max:150',
            'alamat' => 'nullable|string|max:150',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'testimoni' => 'required|string',
            'tampil' => 'required|in:ya,tidak',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/alumni', 'public');
        }

        Alumni::create($data);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Data alumni berhasil ditambahkan.');
    }

    public function show(Alumni $alumni)
    {
        return view('admin.alumni.show', compact('alumni'));
    }

    public function edit(Alumni $alumni)
    {
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|digits:4|min:1970|max:2099',
            'jurusan' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pekerjaan' => 'required|string|max:100',
            'instansi' => 'required|string|max:150',
            'alamat' => 'nullable|string|max:150',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'testimoni' => 'required|string',
            'tampil' => 'required|in:ya,tidak',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
                Storage::disk('public')->delete($alumni->foto);
            }
            $data['foto'] = $request->file('foto')->store('uploads/alumni', 'public');
        }

        $alumni->update($data);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Data alumni berhasil diperbarui.');
    }

    public function destroy(Alumni $alumni)
    {
        if ($alumni->foto && Storage::disk('public')->exists($alumni->foto)) {
            Storage::disk('public')->delete($alumni->foto);
        }

        $alumni->delete();

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Data alumni berhasil dihapus.');
    }
}
