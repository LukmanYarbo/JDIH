<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnggotaDprd;
use Illuminate\Http\Request;

class AnggotaDprdController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaDprd::query();

        if ($request->filled('search')) {
            $query->where(function ($sub) use ($request) {
                $sub->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('fraksi', 'like', "%{$request->search}%")
                    ->orWhere('dapil', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        $items = $query->ordered()->paginate(15);

        return view('admin.anggota.index', compact('items'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:ketua,wakil_ketua,anggota',
            'fraksi' => 'nullable|string|max:255',
            'dapil' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
            'no_urut' => 'nullable|integer|min:0',
            'aktif' => 'nullable|boolean',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/anggota'), $filename);
            $data['foto'] = 'uploads/anggota/'.$filename;
        }

        $data['aktif'] = $request->boolean('aktif');

        AnggotaDprd::create($data);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota DPRD berhasil ditambahkan.');
    }

    public function show(AnggotaDprd $anggota_dprd)
    {
        return redirect()->route('admin.anggota.index');
    }

    public function edit(AnggotaDprd $anggota_dprd)
    {
        return view('admin.anggota.edit', compact('anggota_dprd'));
    }

    public function update(Request $request, AnggotaDprd $anggota_dprd)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:ketua,wakil_ketua,anggota',
            'fraksi' => 'nullable|string|max:255',
            'dapil' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
            'no_urut' => 'nullable|integer|min:0',
            'aktif' => 'nullable|boolean',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($anggota_dprd->foto && file_exists(public_path($anggota_dprd->foto))) {
                @unlink(public_path($anggota_dprd->foto));
            }

            $file = $request->file('foto');
            $filename = time().'_'.preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/anggota'), $filename);
            $data['foto'] = 'uploads/anggota/'.$filename;
        }

        $data['aktif'] = $request->boolean('aktif');

        $anggota_dprd->update($data);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota DPRD berhasil diperbarui.');
    }

    public function destroy(AnggotaDprd $anggota_dprd)
    {
        if ($anggota_dprd->foto && file_exists(public_path($anggota_dprd->foto))) {
            @unlink(public_path($anggota_dprd->foto));
        }

        $anggota_dprd->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota DPRD berhasil dihapus.');
    }
}
