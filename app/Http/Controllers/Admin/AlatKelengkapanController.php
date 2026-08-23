<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlatKelengkapan;
use App\Models\AnggotaDprd;
use App\Models\KeanggotaanAlatKelengkapan;
use Illuminate\Http\Request;

class AlatKelengkapanController extends Controller
{
    public function index(Request $request)
    {
        $query = AlatKelengkapan::withCount('keanggotaans');

        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%");
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $items = $query->ordered()->paginate(15);

        return view('admin.alat-kelengkapan.index', compact('items'));
    }

    public function create()
    {
        return view('admin.alat-kelengkapan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:'.implode(',', array_keys(AlatKelengkapan::TIPE_LABELS)),
            'keterangan' => 'nullable|string',
            'no_urut' => 'nullable|integer|min:0',
        ]);

        AlatKelengkapan::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'keterangan' => $request->keterangan,
            'no_urut' => $request->input('no_urut', 0),
            'aktif' => true,
        ]);

        return redirect()->route('admin.alat-kelengkapan.index')->with('success', 'Alat kelengkapan DPRD berhasil ditambahkan.');
    }

    public function show(AlatKelengkapan $alat_kelengkapan)
    {
        $alat_kelengkapan->load(['keanggotaans.anggotaDprd']);

        // Anggota DPRD aktif yang belum terdaftar di alat kelengkapan ini
        $anggotaOptions = AnggotaDprd::active()
            ->whereNotIn('id', $alat_kelengkapan->keanggotaans->pluck('anggota_dprd_id'))
            ->ordered()
            ->get();

        $pengurus = [
            'ketua' => $alat_kelengkapan->keanggotaans->firstWhere('jabatan', 'ketua'),
            'wakil' => $alat_kelengkapan->keanggotaans->where('jabatan', 'wakil')->values(),
            'sekretaris' => $alat_kelengkapan->keanggotaans->firstWhere('jabatan', 'sekretaris'),
            'anggota' => $alat_kelengkapan->keanggotaans->where('jabatan', 'anggota')->values(),
        ];

        return view('admin.alat-kelengkapan.show', compact('alat_kelengkapan', 'anggotaOptions', 'pengurus'));
    }

    public function edit(AlatKelengkapan $alat_kelengkapan)
    {
        return view('admin.alat-kelengkapan.edit', compact('alat_kelengkapan'));
    }

    public function update(Request $request, AlatKelengkapan $alat_kelengkapan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:'.implode(',', array_keys(AlatKelengkapan::TIPE_LABELS)),
            'keterangan' => 'nullable|string',
            'no_urut' => 'nullable|integer|min:0',
            'aktif' => 'nullable|boolean',
        ]);

        $alat_kelengkapan->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'keterangan' => $request->keterangan,
            'no_urut' => $request->input('no_urut', 0),
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()->route('admin.alat-kelengkapan.index')->with('success', 'Alat kelengkapan DPRD berhasil diperbarui.');
    }

    public function destroy(AlatKelengkapan $alat_kelengkapan)
    {
        $alat_kelengkapan->delete();

        return redirect()->route('admin.alat-kelengkapan.index')->with('success', 'Alat kelengkapan DPRD beserta seluruh keanggotaannya berhasil dihapus.');
    }

    public function storeAnggota(Request $request, AlatKelengkapan $alat_kelengkapan)
    {
        $request->validate([
            'anggota_dprd_id' => 'required|exists:anggota_dprds,id',
            'jabatan' => 'required|in:ketua,wakil,sekretaris,anggota',
            'no_urut' => 'nullable|integer|min:0',
        ]);

        if ($error = $this->cekJabatanTunggal($alat_kelengkapan, $request->jabatan)) {
            return back()->withErrors(['jabatan' => $error])->withInput();
        }

        $sudahTerdaftar = KeanggotaanAlatKelengkapan::where('alat_kelengkapan_id', $alat_kelengkapan->id)
            ->where('anggota_dprd_id', $request->anggota_dprd_id)
            ->exists();

        if ($sudahTerdaftar) {
            return back()->withErrors(['anggota_dprd_id' => 'Anggota tersebut sudah terdaftar di '.$alat_kelengkapan->nama.'.'])->withInput();
        }

        KeanggotaanAlatKelengkapan::create([
            'alat_kelengkapan_id' => $alat_kelengkapan->id,
            'anggota_dprd_id' => $request->anggota_dprd_id,
            'jabatan' => $request->jabatan,
            'no_urut' => $request->input('no_urut', 0),
        ]);

        return back()->with('success', 'Pengurus berhasil ditambahkan ke '.$alat_kelengkapan->nama.'.');
    }

    public function updateAnggota(Request $request, AlatKelengkapan $alat_kelengkapan, KeanggotaanAlatKelengkapan $keanggotaan)
    {
        $request->validate([
            'jabatan' => 'required|in:ketua,wakil,sekretaris,anggota',
            'no_urut' => 'nullable|integer|min:0',
        ]);

        if ($error = $this->cekJabatanTunggal($alat_kelengkapan, $request->jabatan, $keanggotaan->id)) {
            return back()->withErrors(['jabatan_'.$keanggotaan->id => $error]);
        }

        $keanggotaan->update([
            'jabatan' => $request->jabatan,
            'no_urut' => $request->input('no_urut', $keanggotaan->no_urut),
        ]);

        return back()->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroyAnggota(AlatKelengkapan $alat_kelengkapan, KeanggotaanAlatKelengkapan $keanggotaan)
    {
        $keanggotaan->delete();

        return back()->with('success', 'Pengurus berhasil dihapus dari '.$alat_kelengkapan->nama.'.');
    }

    private function cekJabatanTunggal(AlatKelengkapan $alatKelengkapan, string $jabatan, ?int $ignoreId = null): ?string
    {
        // Ketua dan Sekretaris hanya boleh satu orang per alat kelengkapan
        if (! in_array($jabatan, ['ketua', 'sekretaris'])) {
            return null;
        }

        $ada = KeanggotaanAlatKelengkapan::where('alat_kelengkapan_id', $alatKelengkapan->id)
            ->where('jabatan', $jabatan)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($ada) {
            return 'Jabatan '.KeanggotaanAlatKelengkapan::JABATAN_LABELS[$jabatan].' sudah diisi. Hanya boleh satu '.$jabatan.' per '.$alatKelengkapan->labelTipe().'.';
        }

        return null;
    }
}
