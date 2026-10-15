<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistik;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $query = Statistik::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('value', 'like', "%{$search}%");
        }
        
        $data = $query->paginate(10)->withQueryString();
        return view('admin.statistik.index', compact('data'));
    }

    public function create()
    {
        return view('admin.statistik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255'
        ]);

        Statistik::create($request->all());
        return redirect()->route('admin.statistik.index')->with('success', 'Data statistik berhasil ditambahkan');
    }

    public function edit(Statistik $statistik)
    {
        return view('admin.statistik.edit', compact('statistik'));
    }

    public function update(Request $request, Statistik $statistik)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255'
        ]);

        $statistik->update($request->all());
        return redirect()->route('admin.statistik.index')->with('success', 'Data statistik berhasil diperbarui');
    }

    public function destroy(Statistik $statistik)
    {
        $statistik->delete();
        return redirect()->route('admin.statistik.index')->with('success', 'Data statistik berhasil dihapus');
    }
}
