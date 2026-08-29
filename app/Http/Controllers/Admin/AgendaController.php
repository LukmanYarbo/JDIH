<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('pelaksana', 'like', "%{$search}%")
                    ->orWhere('mitra_kerja', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ticker')) {
            $query->where('is_active_ticker', $request->ticker === '1');
        }

        // Urutkan dari tanggal terbaru
        $agendas = $query->orderBy('waktu_mulai', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
            'lokasi' => 'nullable|string|max:255',
            'pelaksana' => 'nullable|string|max:100',
            'mitra_kerja' => 'nullable|string|max:255',
            'status' => 'required|string|in:Akan Datang,Sedang Berlangsung,Selesai,Ditunda,Dibatalkan',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_active_ticker'] = $request->has('is_active_ticker');

        Agenda::create($data);

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda kegiatan DPRD berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
            'lokasi' => 'nullable|string|max:255',
            'pelaksana' => 'nullable|string|max:100',
            'mitra_kerja' => 'nullable|string|max:255',
            'status' => 'required|string|in:Akan Datang,Sedang Berlangsung,Selesai,Ditunda,Dibatalkan',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_active_ticker'] = $request->has('is_active_ticker');

        $agenda->update($data);

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda kegiatan DPRD berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.agendas.index')->with('success', 'Agenda kegiatan DPRD berhasil dihapus.');
    }

    public function toggleTicker(Agenda $agenda)
    {
        $agenda->update([
            'is_active_ticker' => !$agenda->is_active_ticker,
        ]);

        $statusMsg = $agenda->is_active_ticker ? 'ditampilkan pada running ticker bar' : 'disembunyikan dari ticker bar';
        return redirect()->back()->with('success', "Agenda '{$agenda->judul}' kini {$statusMsg}.");
    }
}
