<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Guru;
use App\Models\Halaman;
use App\Models\PengaturanWebsite;
use App\Models\Pengumuman;
use App\Models\Prestasi;
use App\Models\Statistik;
use App\Models\Menu;
use App\Models\Ekstrakurikuler;
use App\Models\Prasarana;
use App\Models\Sarana;
use App\Models\Alumni;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $statistik = Statistik::all();
        $guru = Guru::where('aktif', 1)->take(4)->get();
        $berita = Berita::latest('tanggal')->take(3)->get();
        $prestasi = Prestasi::latest()->take(3)->get();
        $menus = Menu::with('subMenus')->get();
        $testimoni_alumni = Alumni::tampil()->latest()->take(3)->get();

        return view('welcome', compact('pengaturan', 'statistik', 'guru', 'berita', 'prestasi', 'menus', 'testimoni_alumni'));
    }

    public function berita()
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();
        $berita = Berita::latest('tanggal')->paginate(9);

        return view('frontend.berita.index', compact('pengaturan', 'menus', 'berita'));
    }

    public function beritaDetail($id)
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();
        $berita = Berita::findOrFail($id);
        $berita_lainnya = Berita::where('id', '!=', $berita->id)->latest('tanggal')->take(4)->get();

        return view('frontend.berita.show', compact('pengaturan', 'menus', 'berita', 'berita_lainnya'));
    }

    public function prestasi()
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();
        $prestasi = Prestasi::latest('tahun')->paginate(12);

        return view('frontend.prestasi.index', compact('pengaturan', 'menus', 'prestasi'));
    }

    public function guru()
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();
        $guru = Guru::where('aktif', 1)->paginate(12);

        return view('frontend.guru.index', compact('pengaturan', 'menus', 'guru'));
    }

    public function halaman($id)
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();
        $halaman = Halaman::findOrFail($id);

        return view('frontend.halaman.show', compact('pengaturan', 'menus', 'halaman'));
    }

    public function pengumuman()
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();
        $pengumuman = Pengumuman::latest()->paginate(10);

        return view('frontend.pengumuman.index', compact('pengaturan', 'menus', 'pengumuman'));
    }

    public function ekstrakurikuler(Request $request)
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();

        $query = Ekstrakurikuler::aktif()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('pembina', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $ekstrakurikulers = $query->paginate(9)->withQueryString();
        $kategoriList = Ekstrakurikuler::kategoriList();

        return view('frontend.ekstrakurikuler.index', compact('pengaturan', 'menus', 'ekstrakurikulers', 'kategoriList'));
    }

    public function ekstrakurikulerDetail($id)
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();
        $ekskul = Ekstrakurikuler::aktif()->findOrFail($id);
        $ekskul_lainnya = Ekstrakurikuler::aktif()->where('id', '!=', $id)->take(3)->get();

        return view('frontend.ekstrakurikuler.show', compact('pengaturan', 'menus', 'ekskul', 'ekskul_lainnya'));
    }

    public function sarpras(Request $request)
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();

        $query = Prasarana::query()->with(['saranas' => function ($q) {
            $q->take(5);
        }])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $prasaranas = $query->paginate(8)->withQueryString();

        $stats = [
            'total_ruang' => Prasarana::sum('jumlah'),
            'total_luas' => Prasarana::sum('luas'),
            'total_sarana' => Sarana::sum('jumlah'),
        ];

        return view('frontend.sarpras.index', compact('pengaturan', 'menus', 'prasaranas', 'stats'));
    }

    public function alumni(Request $request)
    {
        $pengaturan = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $menus = Menu::with('subMenus')->get();

        $query = Alumni::tampil()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%")
                  ->orWhere('testimoni', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        $alumnis = $query->paginate(9)->withQueryString();

        $featured_testimoni = Alumni::tampil()
            ->whereNotNull('foto')
            ->latest()
            ->take(6)
            ->get();

        if ($featured_testimoni->count() < 3) {
            $featured_testimoni = Alumni::tampil()->latest()->take(6)->get();
        }

        $tahunList = Alumni::tampil()
            ->select('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus', 'desc')
            ->pluck('tahun_lulus');

        $jurusanList = Alumni::tampil()
            ->whereNotNull('jurusan')
            ->where('jurusan', '!=', '')
            ->select('jurusan')
            ->distinct()
            ->orderBy('jurusan')
            ->pluck('jurusan');

        $stats = [
            'total_alumni' => Alumni::count(),
            'total_tampil' => Alumni::tampil()->count(),
            'total_angkatan' => Alumni::distinct('tahun_lulus')->count('tahun_lulus'),
        ];

        return view('frontend.alumni.index', compact(
            'pengaturan',
            'menus',
            'alumnis',
            'featured_testimoni',
            'tahunList',
            'jurusanList',
            'stats'
        ));
    }

    public function storeAlumni(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|digits:4|min:1970|max:' . (date('Y') + 1),
            'jurusan' => 'nullable|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'instansi' => 'required|string|max:150',
            'alamat' => 'nullable|string|max:150',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'testimoni' => 'required|string|max:2000',
        ];

        if ($request->hasFile('foto')) {
            if (extension_loaded('fileinfo')) {
                $rules['foto'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
            } else {
                $rules['foto'] = 'nullable|file|max:2048';
                $ext = strtolower($request->file('foto')->getClientOriginalExtension());
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    return back()->withInput()->withErrors(['foto' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.']);
                }
            }
        }

        $request->validate($rules, [
            'foto.max' => 'Ukuran foto maksimal adalah 2MB (2048 KB).',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
        ]);

        $data = $request->except(['foto']);
        $data['tampil'] = 'tidak'; // Membutuhkan persetujuan admin

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/alumni', 'public');
        }

        Alumni::create($data);

        return redirect()->route('frontend.alumni')
            ->with('success', 'Terima kasih! Cerita dan profil Anda telah dikirim dan akan diverifikasi oleh admin sebelum ditampilkan.');
    }
}
