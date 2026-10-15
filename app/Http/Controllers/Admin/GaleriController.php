<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Galeri::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.galeri.index', compact('data'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        Galeri::create($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Data created successfully');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->all();
        if ($request->hasFile('foto')) {
            if ($galeri->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($galeri->foto);
            }
            $data['foto'] = $request->file('foto')->store('uploads', 'public');
        } else {
            unset($data['foto']);
        }
        $galeri->update($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Galeri $galeri)
    {
        
        if ($galeri->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($galeri->foto);
        }
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Data deleted successfully');
    }
}
