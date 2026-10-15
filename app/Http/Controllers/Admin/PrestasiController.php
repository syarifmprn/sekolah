<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Prestasi::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('hasil', 'like', "%{$search}%")
                  ->orWhere('tahun', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.prestasi.index', compact('data'));
    }

    public function create()
    {
        return view('admin.prestasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('dokumentasi')) {
            $paths = [];
            foreach ($request->file('dokumentasi') as $file) {
                $paths[] = $file->store('uploads', 'public');
            }
            $data['dokumentasi'] = $paths;
        }
        Prestasi::create($data);
        return redirect()->route('admin.prestasi.index')->with('success', 'Data created successfully');
    }

    public function edit(Prestasi $prestasi)
    {
        return view('admin.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $data = $request->all();
        if ($request->hasFile('dokumentasi')) {
            if ($prestasi->dokumentasi && is_array($prestasi->dokumentasi)) {
                foreach ($prestasi->dokumentasi as $old) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
                }
            }
            $paths = [];
            foreach ($request->file('dokumentasi') as $file) {
                $paths[] = $file->store('uploads', 'public');
            }
            $data['dokumentasi'] = $paths;
        } else {
            unset($data['dokumentasi']);
        }
        $prestasi->update($data);
        return redirect()->route('admin.prestasi.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Prestasi $prestasi)
    {
        
        if ($prestasi->dokumentasi && is_array($prestasi->dokumentasi)) {
            foreach ($prestasi->dokumentasi as $old) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($old);
            }
        }
        $prestasi->delete();
        return redirect()->route('admin.prestasi.index')->with('success', 'Data deleted successfully');
    }
}
