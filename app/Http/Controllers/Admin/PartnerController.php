<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::latest();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $partners = $query->paginate(10)->appends($request->only('search'));
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        // Menerapkan validasi data request dari pengguna
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|string|max:255',
        ]);

        // Menyimpan data yang telah divalidasi ke dalam tabel menggunakan Model
        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Data Partner berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        // Menerapkan validasi data request dari pengguna
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|string|max:255',
        ]);

        // Update data yang telah divalidasi
        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Data Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Data Partner berhasil dihapus.');
    }
}

