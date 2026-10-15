<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    public function index(Request $request)
    {
        $query = Ekstrakurikuler::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('pembina', 'like', "%{$search}%")
                  ->orWhere('ketua', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->paginate(10)->withQueryString();
        $kategoriList = Ekstrakurikuler::kategoriList();

        $stats = [
            'total' => Ekstrakurikuler::count(),
            'aktif' => Ekstrakurikuler::where('status', 'aktif')->count(),
            'nonaktif' => Ekstrakurikuler::where('status', 'nonaktif')->count(),
        ];

        return view('admin.ekstrakurikuler.index', compact('data', 'kategoriList', 'stats'));
    }

    public function create()
    {
        $kategoriList = Ekstrakurikuler::kategoriList();
        $hariList = Ekstrakurikuler::hariList();
        return view('admin.ekstrakurikuler.create', compact('kategoriList', 'hariList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'galeri' => 'nullable|array',
            'galeri.*' => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'pembina' => 'nullable|string|max:100',
            'ketua' => 'nullable|string|max:100',
            'hari' => 'nullable|string|max:20',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'tempat' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->except(['logo', 'galeri']);

        // Upload logo utama
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('uploads/ekskul', 'public');
        }

        // Upload galeri multiple
        $galeriPaths = [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $galeriPaths[] = $file->store('uploads/ekskul/galeri', 'public');
            }
        }
        $data['galeri'] = !empty($galeriPaths) ? $galeriPaths : null;

        Ekstrakurikuler::create($data);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Data ekstrakurikuler baru berhasil ditambahkan.');
    }

    public function show(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('admin.ekstrakurikuler.show', compact('ekstrakurikuler'));
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        $kategoriList = Ekstrakurikuler::kategoriList();
        $hariList = Ekstrakurikuler::hariList();
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler', 'kategoriList', 'hariList'));
    }

    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'galeri' => 'nullable|array',
            'galeri.*' => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'deleted_galeri' => 'nullable|array',
            'deleted_galeri.*' => 'string',
            'pembina' => 'nullable|string|max:100',
            'ketua' => 'nullable|string|max:100',
            'hari' => 'nullable|string|max:20',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'tempat' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->except(['logo', 'galeri', 'deleted_galeri', 'remove_logo']);

        // Kelola Logo
        if ($request->hasFile('logo')) {
            if ($ekstrakurikuler->logo) {
                Storage::disk('public')->delete($ekstrakurikuler->logo);
            }
            $data['logo'] = $request->file('logo')->store('uploads/ekskul', 'public');
        } elseif ($request->input('remove_logo') === '1') {
            if ($ekstrakurikuler->logo) {
                Storage::disk('public')->delete($ekstrakurikuler->logo);
            }
            $data['logo'] = null;
        }

        // Kelola Galeri Foto
        $currentGaleri = is_array($ekstrakurikuler->galeri) ? $ekstrakurikuler->galeri : [];

        // Hapus foto yang ditandai untuk dihapus
        if ($request->filled('deleted_galeri')) {
            $deletedFiles = $request->input('deleted_galeri');
            foreach ($deletedFiles as $file) {
                Storage::disk('public')->delete($file);
                $currentGaleri = array_values(array_filter($currentGaleri, fn($item) => $item !== $file));
            }
        }

        // Tambahkan foto-foto baru yang diunggah
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $currentGaleri[] = $file->store('uploads/ekskul/galeri', 'public');
            }
        }

        $data['galeri'] = !empty($currentGaleri) ? array_values($currentGaleri) : null;

        $ekstrakurikuler->update($data);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Data ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        // Hapus file logo
        if ($ekstrakurikuler->logo) {
            Storage::disk('public')->delete($ekstrakurikuler->logo);
        }

        // Hapus semua file foto galeri
        if (is_array($ekstrakurikuler->galeri)) {
            foreach ($ekstrakurikuler->galeri as $item) {
                Storage::disk('public')->delete($item);
            }
        }

        $ekstrakurikuler->delete();

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Data ekstrakurikuler beserta media berhasil dihapus.');
    }
}
