<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query()->latest();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        if ($request->filled('status')) {
            $query->where('aktif', $request->status === 'aktif' ? 1 : 0);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        
        $data = $query->paginate(10)->withQueryString();

        $jabatanList = Guru::select('jabatan')
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        $stats = [
            'total_guru' => Guru::count(),
            'total_aktif' => Guru::where('aktif', true)->count(),
            'total_nonaktif' => Guru::where('aktif', false)->count(),
            'total_jabatan' => Guru::whereNotNull('jabatan')->where('jabatan', '!=', '')->distinct('jabatan')->count('jabatan'),
        ];

        return view('admin.guru.index', compact('data', 'jabatanList', 'stats'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['aktif'] = $request->has('aktif') ? 1 : 0;
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        Guru::create($data);
        return redirect()->route('admin.guru.index')->with('success', 'Data created successfully');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $request->all();
        $data['aktif'] = $request->has('aktif') ? 1 : 0;
        
        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('uploads', 'public');
        } elseif ($request->input('remove_image') == '1') {
            if ($guru->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = null;
        } else {
            unset($data['foto']);
        }
        unset($data['remove_image']);
        
        $guru->update($data);
        return redirect()->route('admin.guru.index')->with('success', 'Data updated successfully');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($guru->foto);
        }
        $guru->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Data deleted successfully');
    }
}
