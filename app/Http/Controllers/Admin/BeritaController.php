<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Berita::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.berita.index', compact('data'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('uploads', 'public');
        }
        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Data created successfully');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->all();
        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($berita->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('uploads', 'public');
        } elseif ($request->input('remove_image') == '1') {
            if ($berita->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($berita->thumbnail);
            }
            $data['thumbnail'] = null;
        } else {
            unset($data['thumbnail']);
        }
        unset($data['remove_image']);
        
        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->thumbnail) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($berita->thumbnail);
        }
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Data deleted successfully');
    }
}
