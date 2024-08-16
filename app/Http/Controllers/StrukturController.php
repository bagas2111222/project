<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Struktur;
use App\Models\User;

class StrukturController extends Controller
{
    public function index($id_project)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
        // Get all projects
        $project = Project::find($id_project);
        $projectName = $project ? $project->name : 'Project Not Found';
        $projects = Project::with($id_project);
        $pegawai = Struktur::where('id_project', $id_project)->get();
        $user = User::all();
        // Pass both projects and companies to the view
        return view('admin.struktur', compact('projects','pegawai','projectName','user','id_project'));
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
            'name' => 'required',
            'id_pegawai' => 'required',
            'id_project' => 'required',
        ]);

        // Create a new project instance and fill it with validated data
        $Struktur = new Struktur();
        $Struktur->name = $validatedData['name'];
        $Struktur->id_user = $validatedData['id_pegawai'];
        $Struktur->id_project = $validatedData['id_project'];

        // Save the Struktur to the database
        $Struktur->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Struktur added successfully!');
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
            'name' => 'required',
            'id_project' => 'required',
            // Make 'id_pegawai' optional
            'id_pegawai' => 'nullable',
        ]);

        // Find the Struktur instance by ID
        $Struktur = Struktur::findOrFail($validatedData['id']);
        $Struktur->name = $validatedData['name'];
        $Struktur->id_project = $validatedData['id_project'];

        // Only update 'id_user' if 'id_pegawai' is provided
        if (!empty($validatedData['id_pegawai'])) {
            $Struktur->id_user = $validatedData['id_pegawai'];
        }

        // Save the Struktur to the database
        $Struktur->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Struktur updated successfully!');
    }
    public function destroy(Struktur $struktur)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
    $struktur->delete();
    alert()->success('Hore!','struktur Deleted Successfully');
    return back();
    }

}
