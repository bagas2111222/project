<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\Vendor;
use App\Models\Tahapan;
use App\Models\Struktur;

use Alert;

class ProjectController extends Controller
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
        // Get all projects
        $projects = Project::all();
        
        // Get all companies
        $perusahaan = Perusahaan::all(); // Ensure you import the Perusahaan model at the top
        $vendor = Vendor::all(); // Ensure you import the Perusahaan model at the top
        $tahapan = Tahapan::all(); 
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        // Pass both projects and companies to the view
        return view('admin.projects', compact('projects', 'perusahaan', 'vendor','tahapan'));
    }

    public function addProject(Request $request)
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
            'nama_project' => 'required|string|max:255',
            'no_po' => 'required|numeric',
            'tgl_po' => 'required|date',
            'id_perusahaan' => 'required|exists:perusahaans,id', // Ensure the selected company exists
            'id_vendor' => 'required|exists:vendors,id', // Ensure the selected vendor exists
            'start_project' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_project', // Ensure deadline is after start date
        ]);

        // Create a new project instance and fill it with validated data
        $project = new Project();
        $project->name = $validatedData['nama_project'];
        $project->no_po = $validatedData['no_po'];
        $project->tanggal_po = $validatedData['tgl_po'];
        $project->perusahaan_id = $validatedData['id_perusahaan'];
        $project->vendor_id = $validatedData['id_vendor'];
        $project->start_date = $validatedData['start_project'];
        $project->deadline = $validatedData['deadline'];
        $project->status = 'belum';

        // Save the project to the database
        $project->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Project added successfully!');
    }
    public function editProject(Request $request)
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
            'id' => 'required|exists:projects,id', // Ensure the project exists
            'nama_project' => 'required|string|max:255',
            'no_po' => 'required|numeric',
            'tgl_po' => 'required|date',
            'start_project' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_project', // Ensure deadline is after start date
        ]);

        // Find the project by ID and update it with validated data
        $project = Project::findOrFail($validatedData['id']);
        $project->name = $validatedData['nama_project'];
        $project->no_po = $validatedData['no_po'];
        $project->tanggal_po = $validatedData['tgl_po'];
        $project->start_date = $validatedData['start_project'];
        $project->deadline = $validatedData['deadline'];
        // Conditionally validate and update perusahaan_id if not "null"
        if ($request->has('id_perusahaan') && $request->input('id_perusahaan') !== '121') {
            $request->validate(['id_perusahaan' => 'exists:perusahaans,id']);
            $project->perusahaan_id = $request->input('id_perusahaan');
        }

        // Conditionally validate and update vendor_id if not "null"
        if ($request->has('id_vendor') && $request->input('id_vendor') !== '121') {
            $request->validate(['id_vendor' => 'exists:vendors,id']);
            $project->vendor_id = $request->input('id_vendor');
        }

        // Save the updated project to the database
        $project->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Project updated successfully!');
    }
    // public function destroy($id) 
    // {
    //     $project = Project::findOrFail($id);
    //     $project->delete();
    //     alert()->success('Hore!','Post Deleted Successfully');
    //     return back();
    // }

    public function destroy(Project $project)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
    $project->delete();
    alert()->success('Hore!','project Deleted Successfully');
    return back();
    }




    //pegawai


   public function indexPegawai()
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }
    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'pegawai') {
        abort(403, 'Unauthorized access.');
    }

    // Get the authenticated user's ID
    $userId = auth()->user()->id;

    // Get all project IDs where the current user is part of the struktur
    $projectIds = Struktur::where('id_user', $userId)->pluck('id_project');

    // Get all projects with their related perusahaan, vendor, and struktur, filtered by the project IDs
    $projects = Project::with(['perusahaan', 'vendor', 'struktur.user'])
                       ->whereIn('id', $projectIds)
                       ->get();

    // Get all companies, vendors, and stages (tahapan)
    $perusahaan = Perusahaan::all();
    $vendor = Vendor::all();
    $tahapan = Tahapan::all();

    // Pass the data to the view
    return view('pegawai.projects', compact('projects', 'perusahaan', 'vendor', 'tahapan'));
}
 public function DataPegawai()
{
    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'pegawai') {
        abort(403, 'Unauthorized access.');
    }
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Get the authenticated user's ID
    $userId = auth()->user()->id;

    // Get all project IDs where the current user is part of the struktur
    $projectIds = Struktur::where('id_user', $userId)->pluck('id_project');

    // Get all projects with their related perusahaan, vendor, and struktur, filtered by the project IDs
    $projects = Project::with(['perusahaan', 'vendor', 'struktur.user'])
                       ->whereIn('id', $projectIds)
                       ->get();

    // Get all companies, vendors, and stages (tahapan)
    $perusahaan = Perusahaan::all();
    $vendor = Vendor::all();
    $tahapan = Tahapan::all();

    // Pass the data to the view
    return view('pegawai.data-pegawai', compact('projects', 'perusahaan', 'vendor', 'tahapan'));
}


    






}
