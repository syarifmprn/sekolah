<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanWebsiteController extends Controller
{
    public function index()
    {
        // Get the first record, or create a new instance if none exists
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        return view('admin.pengaturan-website.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        
        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo) {
                Storage::disk('public')->delete('uploads/' . $pengaturan->logo);
            }
            $file = $request->file('logo');
            $filename = time() . '_logo.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $data['logo'] = $filename;
        } elseif ($request->input('remove_logo') == '1') {
            if ($pengaturan->logo) {
                Storage::disk('public')->delete('uploads/' . $pengaturan->logo);
            }
            $data['logo'] = null;
        }

        if ($request->hasFile('foto_kepala_sekolah')) {
            if ($pengaturan->foto_kepala_sekolah) {
                Storage::disk('public')->delete('uploads/' . $pengaturan->foto_kepala_sekolah);
            }
            $file = $request->file('foto_kepala_sekolah');
            $filename = time() . '_foto_kepala_sekolah.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $data['foto_kepala_sekolah'] = $filename;
        } elseif ($request->input('remove_foto_kepala_sekolah') == '1') {
            if ($pengaturan->foto_kepala_sekolah) {
                Storage::disk('public')->delete('uploads/' . $pengaturan->foto_kepala_sekolah);
            }
            $data['foto_kepala_sekolah'] = null;
        }

        // Jangan masukkan input remove_ ke database
        unset($data['remove_logo']);
        unset($data['remove_foto_kepala_sekolah']);

        $existingSliders = $pengaturan->slider_hero ?? [];
        $newSliders = [];

        for ($i = 1; $i <= 3; $i++) {
            $inputName = 'slider_hero_' . $i;
            $removeName = 'remove_slider_hero_' . $i;

            if ($request->hasFile($inputName)) {
                // Hapus slider lama jika ada di indeks ini
                if (isset($existingSliders[$i - 1])) {
                    Storage::disk('public')->delete('uploads/' . $existingSliders[$i - 1]);
                }
                $file = $request->file($inputName);
                $filename = time() . "_slider_{$i}." . $file->getClientOriginalExtension();
                $file->storeAs('uploads', $filename, 'public');
                $newSliders[$i - 1] = $filename;
            } elseif ($request->input($removeName) == '1') {
                // Hapus slider lama
                if (isset($existingSliders[$i - 1])) {
                    Storage::disk('public')->delete('uploads/' . $existingSliders[$i - 1]);
                }
                // tidak dimasukkan ke $newSliders
            } else {
                // Pertahankan slider lama jika ada
                if (isset($existingSliders[$i - 1])) {
                    $newSliders[$i - 1] = $existingSliders[$i - 1];
                }
            }
        }
        
        // Re-index array agar selalu berurutan (0, 1, 2) walau ada yang kosong di tengah
        $data['slider_hero'] = array_values($newSliders);
        
        // Buang data dummy
        unset($data['slider_hero_1'], $data['slider_hero_2'], $data['slider_hero_3']);
        unset($data['remove_slider_hero_1'], $data['remove_slider_hero_2'], $data['remove_slider_hero_3']);

        if ($pengaturan->exists) {
            $pengaturan->update($data);
        } else {
            PengaturanWebsite::create($data);
        }

        return redirect()->back()->with('success', 'Pengaturan Website berhasil diperbarui.');
    }
}
