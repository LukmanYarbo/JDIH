<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimPengelola;
use Illuminate\Http\Request;

class TimPengelolaController extends Controller
{
    public function index(Request $request)
    {
        $query = TimPengelola::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan_tim', 'like', "%{$search}%")
                    ->orWhere('jabatan_struktural', 'like', "%{$search}%")
                    ->orWhere('divisi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_jabatan')) {
            $query->where('kategori_jabatan', $request->kategori_jabatan);
        }

        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif === '1');
        }

        $items = $query->orderedHierarchy()->paginate(20);

        $kategoriJabatanOptions = TimPengelola::KATEGORI_JABATAN;
        $divisiOptions = TimPengelola::DIVISI_STANDAR;

        return view('admin.tim-pengelola.index', compact('items', 'kategoriJabatanOptions', 'divisiOptions'));
    }

    public function create()
    {
        $kategoriJabatanOptions = TimPengelola::KATEGORI_JABATAN;
        $divisiOptions = TimPengelola::DIVISI_STANDAR;
        $peranBidangOptions = TimPengelola::PERAN_BIDANG_OPTIONS;
        return view('admin.tim-pengelola.create', compact('kategoriJabatanOptions', 'divisiOptions', 'peranBidangOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'kategori_jabatan' => 'required|string|in:pembina,penanggung_jawab,ketua,wakil_ketua,sekretaris,bidang',
            'jabatan_tim' => 'required|string|max:150',
            'jabatan_struktural' => 'nullable|string|max:150',
            'divisi' => 'nullable|string|max:150',
            'peran_bidang' => 'nullable|string|max:100',
            'kontak' => 'nullable|string|max:100',
            'tugas' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['foto']);
        $data['aktif'] = $request->has('aktif');
        $data['urutan'] = $request->urutan ?? 0;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'tim_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tim-pengelola'), $filename);
            $data['foto'] = 'uploads/tim-pengelola/' . $filename;
        }

        TimPengelola::create($data);

        return redirect()->route('admin.tim-pengelola.index')->with('success', 'Data personil Tim Pengelola JDIH berhasil ditambahkan.');
    }

    public function edit(TimPengelola $tim_pengelola)
    {
        $kategoriJabatanOptions = TimPengelola::KATEGORI_JABATAN;
        $divisiOptions = TimPengelola::DIVISI_STANDAR;
        $peranBidangOptions = TimPengelola::PERAN_BIDANG_OPTIONS;
        return view('admin.tim-pengelola.edit', compact('tim_pengelola', 'kategoriJabatanOptions', 'divisiOptions', 'peranBidangOptions'));
    }

    public function update(Request $request, TimPengelola $tim_pengelola)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'kategori_jabatan' => 'required|string|in:pembina,penanggung_jawab,ketua,wakil_ketua,sekretaris,bidang',
            'jabatan_tim' => 'required|string|max:150',
            'jabatan_struktural' => 'nullable|string|max:150',
            'divisi' => 'nullable|string|max:150',
            'peran_bidang' => 'nullable|string|max:100',
            'kontak' => 'nullable|string|max:100',
            'tugas' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['foto']);
        $data['aktif'] = $request->has('aktif');
        $data['urutan'] = $request->urutan ?? 0;

        if ($request->hasFile('foto')) {
            if ($tim_pengelola->foto && file_exists(public_path($tim_pengelola->foto))) {
                @unlink(public_path($tim_pengelola->foto));
            }

            $file = $request->file('foto');
            $filename = 'tim_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tim-pengelola'), $filename);
            $data['foto'] = 'uploads/tim-pengelola/' . $filename;
        }

        $tim_pengelola->update($data);

        return redirect()->route('admin.tim-pengelola.index')->with('success', 'Data personil Tim Pengelola JDIH berhasil diperbarui.');
    }

    public function destroy(TimPengelola $tim_pengelola)
    {
        if ($tim_pengelola->foto && file_exists(public_path($tim_pengelola->foto))) {
            @unlink(public_path($tim_pengelola->foto));
        }

        $tim_pengelola->delete();

        return redirect()->route('admin.tim-pengelola.index')->with('success', 'Data personil Tim Pengelola JDIH berhasil dihapus.');
    }

    public function toggleActive(TimPengelola $tim_pengelola)
    {
        $tim_pengelola->update(['aktif' => !$tim_pengelola->aktif]);
        $statusMsg = $tim_pengelola->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Personel {$tim_pengelola->nama} berhasil {$statusMsg}.");
    }
}
