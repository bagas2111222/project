<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vendor;


class VendorController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
        $vendor = Vendor::all();
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        // Pass both projects and companies to the view
        return view('admin.vendor', compact('vendor'));
    }
    public function add(Request $request)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
        // Validate the incoming request data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'alamat' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);

        // Create a new project instance and fill it with validated data
        $perusahaan = new Vendor();
        $perusahaan->name = $validatedData['nama'];
        $perusahaan->jenis = $validatedData['jenis'];
        $perusahaan->alamat = $validatedData['alamat'];
        $perusahaan->kontak = $validatedData['phone'];

        // Save the perusahaan to the database
        $perusahaan->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Perusahaan added successfully!');
    }
    public function edit(Request $request)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'alamat' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);

        // Create a new project instance and fill it with validated data
        $perusahaan = Vendor::findOrFail($validatedData['id']);
        $perusahaan->name = $validatedData['nama'];
        $perusahaan->jenis = $validatedData['jenis'];
        $perusahaan->alamat = $validatedData['alamat'];
        $perusahaan->kontak = $validatedData['phone'];

        // Save the perusahaan to the database
        $perusahaan->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Perusahaan added successfully!');
    }
    public function destroy(Vendor $vendor)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
    $vendor->delete();
    alert()->success('Hore!','vendor Deleted Successfully');
    return back();
    }
}
