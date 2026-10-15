<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prasarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrasaranaController extends Controller
{
    public function index(Request $request)
    {
        $query = Prasarana::query()->withCount('saranas')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $data = $query->paginate(10)->withQueryString();
        $kondisiList = Prasarana::kondisiList();

        $stats = [
            'total_ruang' => Prasarana::sum('jumlah'),
            'total_luas' => Prasarana::sum('luas'),
            'kondisi_baik' => Prasarana::where('kondisi', 'baik')->count(),
            'kondisi_rusak' => Prasarana::whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->count(),
        ];

        return view('admin.prasarana.index', compact('data', 'kondisiList', 'stats'));
    }

    public function create()
    {
        $kondisiList = Prasarana::kondisiList();
        return view('admin.prasarana.create', compact('kondisiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'luas' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/prasarana', 'public');
        }

        Prasarana::create($data);

        return redirect()->route('admin.prasarana.index')
            ->with('success', 'Data prasarana baru berhasil ditambahkan.');
    }

    public function show(Prasarana $prasarana)
    {
        $prasarana->load(['saranas' => function ($query) {
            $query->latest();
        }]);

        return view('admin.prasarana.show', compact('prasarana'));
    }

    public function edit(Prasarana $prasarana)
    {
        $kondisiList = Prasarana::kondisiList();
        return view('admin.prasarana.edit', compact('prasarana', 'kondisiList'));
    }

    public function update(Request $request, Prasarana $prasarana)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'luas' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except(['foto', 'remove_foto']);

        if ($request->hasFile('foto')) {
            if ($prasarana->foto) {
                Storage::disk('public')->delete($prasarana->foto);
            }
            $data['foto'] = $request->file('foto')->store('uploads/prasarana', 'public');
        } elseif ($request->input('remove_foto') === '1') {
            if ($prasarana->foto) {
                Storage::disk('public')->delete($prasarana->foto);
            }
            $data['foto'] = null;
        }

        $prasarana->update($data);

        return redirect()->route('admin.prasarana.index')
            ->with('success', 'Data prasarana berhasil diperbarui.');
    }

    public function destroy(Prasarana $prasarana)
    {
        if ($prasarana->foto) {
            Storage::disk('public')->delete($prasarana->foto);
        }

        $prasarana->delete();

        return redirect()->route('admin.prasarana.index')
            ->with('success', 'Data prasarana berhasil dihapus.');
    }
}
