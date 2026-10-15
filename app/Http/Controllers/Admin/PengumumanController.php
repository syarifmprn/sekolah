<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Pengumuman::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.pengumuman.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('uploads', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('uploads', 'public');
        }
        Pengumuman::create($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Data created successfully');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->all();
        if ($request->hasFile('dokumen')) {
            if ($pengumuman->dokumen) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->dokumen);
            }
            $data['dokumen'] = $request->file('dokumen')->store('uploads', 'public');
        } else {
            unset($data['dokumen']);
        }

        if ($request->hasFile('thumbnail')) {
            if ($pengumuman->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('uploads', 'public');
        } elseif ($request->input('remove_image') == '1') {
            if ($pengumuman->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->thumbnail);
            }
            $data['thumbnail'] = null;
        } else {
            unset($data['thumbnail']);
        }
        unset($data['remove_image']);
        
        $pengumuman->update($data);
        return redirect()->route('admin.pengumuman.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->dokumen) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->dokumen);
        }
        if ($pengumuman->thumbnail) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pengumuman->thumbnail);
        }
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Data deleted successfully');
    }
}
