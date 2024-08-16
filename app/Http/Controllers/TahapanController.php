<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahapan;
use App\Models\Detail;
use App\Models\Project;

class TahapanController extends Controller
{
    // public function index()
    // {
    //     $tahapan = Tahapan::all();
    //     $title = 'Delete Data!';
    //     $text = "Are you sure you want to delete?";
    //     confirmDelete($title, $text);
    //     // Pass both projects and companies to the view
    //     return view('admin.tahapan', compact('tahapan'));
    // }
    public function index($id_project)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
        // Ambil semua tahapan berdasarkan id_project
        $tahapan = Tahapan::where('id_project', $id_project)->get();
        $detail = Detail::all();
        // Ambil nama proyek
        $project = Project::find($id_project);
        $projectName = $project ? $project->name : 'Project Not Found';
        $projectPo = $project ? $project->no_po : 'Project Not Found';
        $projectStatus = $project ? $project->status : 'Project Not Found';
        $projectRFS = $project ? $project->deadline : 'Project Not Found';
        // Confirm delete variables
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        // Kembalikan view dengan data yang diperlukan
        return view('admin.tahapan', compact('tahapan', 'id_project', 'projectName','projectPo','projectStatus','projectRFS','detail'));
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
            'id' => 'required',
            'name' => 'required|string|max:255',
            'tanggal_start' => 'required|date',
            'deadline' => 'required|date',
        ]);

        // Create a new project instance and fill it with validated data
        $Tahapan = new Tahapan();
        $Tahapan->id_project = $validatedData['id'];
        $Tahapan->name = $validatedData['name'];
        $Tahapan->tanggal_start = $validatedData['tanggal_start'];
        $Tahapan->deadline = $validatedData['deadline'];
        $Tahapan->status = 'belum';
        $Tahapan->persen = '0';

        // Save the Tahapan to the database
        $Tahapan->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Tahapan added successfully!');
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
            'name' => 'required|string|max:255',
            'tanggal_start' => 'required|date',
            'deadline' => 'required|date',
        ]);

        // Create a new project instance and fill it with validated data
        $Tahapan = Tahapan::find($validatedData['id']);
        $Tahapan->name = $validatedData['name'];
        $Tahapan->tanggal_start = $validatedData['tanggal_start'];
        $Tahapan->deadline = $validatedData['deadline'];

        // Save the Tahapan to the database
        $Tahapan->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Perusahaan added successfully!');
    }
    public function destroy(Tahapan $tahapan)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
    $tahapan->delete();
    alert()->success('Hore!','tahapan Deleted Successfully');
    return back();
    }

    
    public function uploadFile(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required|', // Make sure the id exists in the tahapan table
            'file' => 'required|', // Adjust file types and size as needed
            'tgl_actual' => 'required|date',
        ]);

        // Find the Tahapan instance by id
        $Tahapan = Tahapan::find($validatedData['id']);

        if ($Tahapan) {
            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension(); // Get the original file extension
                $fileName = uniqid() . '.' . $extension; // Generate a unique file name

                $file->move(public_path('file/upload'), $fileName); // Move the file to the specified directory

                // Update the Tahapan instance
                $Tahapan->hasil_tahapan = $fileName; // Store the file name in the database
                $Tahapan->tgl_actual = $validatedData['tgl_actual']; // Update tgl_actual
                $Tahapan->save(); // Save changes to the database

                // Redirect back with a success message
                return redirect()->back()->with('success', 'File uploaded successfully!');
            } else {
                return redirect()->back()->with('error', 'No file was uploaded!');
            }
        } else {
            // If the Tahapan instance was not found, redirect back with an error message
            return redirect()->back()->with('error', 'Tahapan not found!');
        }
    }




    //pegawai

    public function indexPegawai($id_project)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'pegawai') {
        abort(403, 'Unauthorized access.');
    }
        // Ambil semua tahapan berdasarkan id_project
        $tahapan = Tahapan::where('id_project', $id_project)->get();
        $detail = Detail::all();
        // Ambil nama proyek
        $project = Project::find($id_project);
        $projectName = $project ? $project->name : 'Project Not Found';
        $projectPo = $project ? $project->no_po : 'Project Not Found';
        $projectStatus = $project ? $project->status : 'Project Not Found';
        $projectRFS = $project ? $project->deadline : 'Project Not Found';
        // Confirm delete variables
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        // Kembalikan view dengan data yang diperlukan
        return view('pegawai.tahapan', compact('tahapan', 'id_project', 'projectName','projectPo','projectStatus','projectRFS','detail'));
    }



}
