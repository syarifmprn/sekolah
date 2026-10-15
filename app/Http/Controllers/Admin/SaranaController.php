<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prasarana;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaranaController extends Controller
{
    public function index(Request $request)
    {
        $query = Sarana::query()->with('prasarana')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('prasarana', function ($pq) use ($search) {
                      $pq->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('prasarana_id')) {
            $query->where('prasarana_id', $request->prasarana_id);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_pengadaan', $request->tahun);
        }

        $data = $query->paginate(10)->withQueryString();
        $kondisiList = Sarana::kondisiList();
        $prasaranasList = Prasarana::orderBy('nama')->get();

        $stats = [
            'total_barang' => Sarana::count(),
            'total_unit' => Sarana::sum('jumlah'),
            'kondisi_baik' => Sarana::where('kondisi', 'baik')->sum('jumlah'),
            'kondisi_rusak' => Sarana::whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->sum('jumlah'),
        ];

        return view('admin.sarana.index', compact('data', 'kondisiList', 'prasaranasList', 'stats'));
    }

    public function create()
    {
        $kondisiList = Sarana::kondisiList();
        $prasaranasList = Prasarana::orderBy('nama')->get();
        return view('admin.sarana.create', compact('kondisiList', 'prasaranasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'prasarana_id' => 'nullable|exists:prasaranas,id',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tahun_pengadaan' => 'nullable|integer|min:1950|max:' . (date('Y') + 5),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/sarana', 'public');
        }

        Sarana::create($data);

        return redirect()->route('admin.sarana.index')
            ->with('success', 'Data sarana/barang baru berhasil ditambahkan.');
    }

    public function show(Sarana $sarana)
    {
        $sarana->load('prasarana');
        return view('admin.sarana.show', compact('sarana'));
    }

    public function edit(Sarana $sarana)
    {
        $kondisiList = Sarana::kondisiList();
        $prasaranasList = Prasarana::orderBy('nama')->get();
        return view('admin.sarana.edit', compact('sarana', 'kondisiList', 'prasaranasList'));
    }

    public function update(Request $request, Sarana $sarana)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'prasarana_id' => 'nullable|exists:prasaranas,id',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tahun_pengadaan' => 'nullable|integer|min:1950|max:' . (date('Y') + 5),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except(['foto', 'remove_foto']);

        if ($request->hasFile('foto')) {
            if ($sarana->foto) {
                Storage::disk('public')->delete($sarana->foto);
            }
            $data['foto'] = $request->file('foto')->store('uploads/sarana', 'public');
        } elseif ($request->input('remove_foto') === '1') {
            if ($sarana->foto) {
                Storage::disk('public')->delete($sarana->foto);
            }
            $data['foto'] = null;
        }

        $sarana->update($data);

        return redirect()->route('admin.sarana.index')
            ->with('success', 'Data sarana/barang berhasil diperbarui.');
    }

    public function destroy(Sarana $sarana)
    {
        if ($sarana->foto) {
            Storage::disk('public')->delete($sarana->foto);
        }

        $sarana->delete();

        return redirect()->route('admin.sarana.index')
            ->with('success', 'Data sarana/barang berhasil dihapus.');
    }
}
