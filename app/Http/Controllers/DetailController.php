<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahapan;
use App\Models\Detail;

class DetailController extends Controller
{
    public function index($id_tahapan)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
        // Ambil semua tahapan berdasarkan id_project
        $detail = Detail::where('id_tahapan', $id_tahapan)->get();
        // Ambil nama proyek
        $tahapan = Tahapan::find($id_tahapan);
        $tahapanName = $tahapan ? $tahapan->name : 'tahapan Not Found';
        $projectName = $tahapan ? $tahapan->project->name : 'tahapan Not Found';
        $id_project = $tahapan ? $tahapan->project->id : 'tahapan Not Found';
        // $projectPo = $project ? $project->no_po : 'Project Not Found';
        // $projectStatus = $project ? $project->status : 'Project Not Found';
        // $projectRFS = $project ? $project->deadline : 'Project Not Found';
        // // Confirm delete variables
        // $title = 'Delete Data!';
        // $text = "Are you sure you want to delete?";
        // confirmDelete($title, $text);

        // Kembalikan view dengan data yang diperlukan
        return view('admin.detail', compact('detail', 'id_tahapan','tahapanName','projectName','id_project'));
    }
    public function show($id)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
        // Retrieve the detail by ID
        $detail = Detail::where('id', $id)->first();

        // Check if detail exists and is not empty
        if (!$detail) {
            return redirect()->route('admin.dashboard')->with('error', 'Detail not found.');
        }

        // Pass the detail data to the view
        return view('admin.hasil', compact('detail'));
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
            'name' => 'required',
            'desc' => 'required',
            'deadline' => 'required|date',
        ]);

        // Create a new project instance and fill it with validated data
        $Detail = new Detail();
        $Detail->id_tahapan = $validatedData['id'];
        $Detail->name = $validatedData['name'];
        $Detail->desc = $validatedData['desc'];
        $Detail->deadline = $validatedData['deadline'];
        $Detail->status = 'belum';

        // Save the Detail to the database
        $Detail->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Detail added successfully!');
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
            'desc' => 'required',
            'deadline' => 'required|date',
        ]);

        // Create a new project instance and fill it with validated data
        $Detail = Detail::find($validatedData['id']);
        $Detail->name = $validatedData['name'];
        $Detail->desc = $validatedData['desc'];
        $Detail->deadline = $validatedData['deadline'];

        // Save the Detail to the database
        $Detail->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Detail added successfully!');
    }
    public function destroy(Detail $detail)
    {
    $detail->delete();
    alert()->success('Hore!','detail Deleted Successfully');
    return back();
    }




    //pegawai
    public function indexPegawai($id_tahapan)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'pegawai') {
        abort(403, 'Unauthorized access.');
    }
        // Ambil semua tahapan berdasarkan id_project
        $detail = Detail::where('id_tahapan', $id_tahapan)->get();
        // Ambil nama proyek
        $tahapan = Tahapan::find($id_tahapan);
        $tahapanName = $tahapan ? $tahapan->name : 'tahapan Not Found';
        $projectName = $tahapan ? $tahapan->project->name : 'tahapan Not Found';
        $id_project = $tahapan ? $tahapan->project->id : 'tahapan Not Found';
        // $projectPo = $project ? $project->no_po : 'Project Not Found';
        // $projectStatus = $project ? $project->status : 'Project Not Found';
        // $projectRFS = $project ? $project->deadline : 'Project Not Found';
        // // Confirm delete variables
        // $title = 'Delete Data!';
        // $text = "Are you sure you want to delete?";
        // confirmDelete($title, $text);

        // Kembalikan view dengan data yang diperlukan
        return view('pegawai.detail', compact('detail', 'id_tahapan','tahapanName','projectName','id_project'));
    }
}
