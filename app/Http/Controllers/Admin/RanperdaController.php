<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ranperda;
use Illuminate\Http\Request;

class RanperdaController extends Controller
{
    public function index(Request $request)
    {
        $query = Ranperda::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nomor_propemperda', 'like', "%{$search}%")
                    ->orWhere('pemrakarsa', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ranperdas = $query->orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        $years = Ranperda::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $tahapanLabels = Ranperda::getTahapanLabels();

        return view('admin.ranperda.index', compact('ranperdas', 'years', 'tahapanLabels'));
    }

    public function create()
    {
        $tahapanLabels = Ranperda::getTahapanLabels();
        return view('admin.ranperda.create', compact('tahapanLabels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 2),
            'nomor_propemperda' => 'nullable|string|max:100',
            'judul' => 'required|string',
            'pemrakarsa' => 'required|string|max:100',
            'tahap_terakhir' => 'required|integer|between:1,7',
            'tanggal_mulai_pembahasan' => 'nullable|date',
            'tanggal_akhir_pembahasan' => 'nullable|date|after_or_equal:tanggal_mulai_pembahasan',
            'tanggal_penetapan' => 'nullable|date',
            'status' => 'required|string|in:Dalam Pembahasan,Disetujui,Ditetapkan,Ditolak',
            'keterangan' => 'nullable|string',
            'file_naskah_akademik' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'file_rancangan' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'file_evaluasi' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
        ]);

        $data = $request->except(['file_naskah_akademik', 'file_rancangan', 'file_evaluasi']);

        // Upload files
        if ($request->hasFile('file_naskah_akademik')) {
            $file = $request->file('file_naskah_akademik');
            $filename = 'na_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ranperda'), $filename);
            $data['file_naskah_akademik'] = 'uploads/ranperda/' . $filename;
        }

        if ($request->hasFile('file_rancangan')) {
            $file = $request->file('file_rancangan');
            $filename = 'draf_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ranperda'), $filename);
            $data['file_rancangan'] = 'uploads/ranperda/' . $filename;
        }

        if ($request->hasFile('file_evaluasi')) {
            $file = $request->file('file_evaluasi');
            $filename = 'eval_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ranperda'), $filename);
            $data['file_evaluasi'] = 'uploads/ranperda/' . $filename;
        }

        Ranperda::create($data);

        return redirect()->route('admin.ranperda.index')->with('success', 'Data Alur Ranperda berhasil ditambahkan.');
    }

    public function edit(Ranperda $ranperda)
    {
        $tahapanLabels = Ranperda::getTahapanLabels();
        return view('admin.ranperda.edit', compact('ranperda', 'tahapanLabels'));
    }

    public function update(Request $request, Ranperda $ranperda)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 2),
            'nomor_propemperda' => 'nullable|string|max:100',
            'judul' => 'required|string',
            'pemrakarsa' => 'required|string|max:100',
            'tahap_terakhir' => 'required|integer|between:1,7',
            'tanggal_mulai_pembahasan' => 'nullable|date',
            'tanggal_akhir_pembahasan' => 'nullable|date|after_or_equal:tanggal_mulai_pembahasan',
            'tanggal_penetapan' => 'nullable|date',
            'status' => 'required|string|in:Dalam Pembahasan,Disetujui,Ditetapkan,Ditolak',
            'keterangan' => 'nullable|string',
            'file_naskah_akademik' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'file_rancangan' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'file_evaluasi' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
        ]);

        $data = $request->except(['file_naskah_akademik', 'file_rancangan', 'file_evaluasi']);

        if ($request->hasFile('file_naskah_akademik')) {
            if ($ranperda->file_naskah_akademik && file_exists(public_path($ranperda->file_naskah_akademik))) {
                @unlink(public_path($ranperda->file_naskah_akademik));
            }
            $file = $request->file('file_naskah_akademik');
            $filename = 'na_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ranperda'), $filename);
            $data['file_naskah_akademik'] = 'uploads/ranperda/' . $filename;
        }

        if ($request->hasFile('file_rancangan')) {
            if ($ranperda->file_rancangan && file_exists(public_path($ranperda->file_rancangan))) {
                @unlink(public_path($ranperda->file_rancangan));
            }
            $file = $request->file('file_rancangan');
            $filename = 'draf_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ranperda'), $filename);
            $data['file_rancangan'] = 'uploads/ranperda/' . $filename;
        }

        if ($request->hasFile('file_evaluasi')) {
            if ($ranperda->file_evaluasi && file_exists(public_path($ranperda->file_evaluasi))) {
                @unlink(public_path($ranperda->file_evaluasi));
            }
            $file = $request->file('file_evaluasi');
            $filename = 'eval_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ranperda'), $filename);
            $data['file_evaluasi'] = 'uploads/ranperda/' . $filename;
        }

        $ranperda->update($data);

        return redirect()->route('admin.ranperda.index')->with('success', 'Data Alur Ranperda berhasil diperbarui.');
    }

    public function destroy(Ranperda $ranperda)
    {
        if ($ranperda->file_naskah_akademik && file_exists(public_path($ranperda->file_naskah_akademik))) {
            @unlink(public_path($ranperda->file_naskah_akademik));
        }
        if ($ranperda->file_rancangan && file_exists(public_path($ranperda->file_rancangan))) {
            @unlink(public_path($ranperda->file_rancangan));
        }
        if ($ranperda->file_evaluasi && file_exists(public_path($ranperda->file_evaluasi))) {
            @unlink(public_path($ranperda->file_evaluasi));
        }

        $ranperda->delete();

        return redirect()->route('admin.ranperda.index')->with('success', 'Data Alur Ranperda berhasil dihapus.');
    }
}
