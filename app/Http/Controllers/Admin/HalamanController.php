<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Halaman;
use Illuminate\Http\Request;

class HalamanController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Halaman::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.halaman.index', compact('data'));
    }

    public function create()
    {
        return view('admin.halaman.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('uploads', 'public');
        }
        Halaman::create($data);
        return redirect()->route('admin.halaman.index')->with('success', 'Data created successfully');
    }

    public function edit(Halaman $halaman)
    {
        return view('admin.halaman.edit', compact('halaman'));
    }

    public function update(Request $request, Halaman $halaman)
    {
        $data = $request->all();
        if ($request->hasFile('thumbnail')) {
            if ($halaman->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($halaman->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('uploads', 'public');
        } elseif ($request->input('remove_image') == '1') {
            if ($halaman->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($halaman->thumbnail);
            }
            $data['thumbnail'] = null;
        } else {
            unset($data['thumbnail']);
        }
        unset($data['remove_image']);
        
        $halaman->update($data);
        return redirect()->route('admin.halaman.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Halaman $halaman)
    {
        if ($halaman->thumbnail) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($halaman->thumbnail);
        }
        $halaman->delete();
        return redirect()->route('admin.halaman.index')->with('success', 'Data deleted successfully');
    }
}
