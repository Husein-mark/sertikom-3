<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageCrudController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_per_student' => ['required', 'integer', 'min:0'],
            'min_students' => ['required', 'integer', 'min:1'],
            'duration' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket kunjungan sekolah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_per_student' => ['required', 'integer', 'min:0'],
            'min_students' => ['required', 'integer', 'min:1'],
            'duration' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket kunjungan sekolah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Paket kunjungan sekolah berhasil dihapus.');
    }
}
