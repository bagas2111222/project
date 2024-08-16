<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Struktur;
use App\Models\Vendor;
use App\Models\Perusahaan;
class DashboardrController extends Controller
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
        // Get all projects with their associated tahapan
        $projects = Project::with('tahapan')->get();

        // Calculate the average percentage for each project
        foreach ($projects as $project) {
            $tahapan = $project->tahapan ?? collect(); // Default to an empty collection
            $totalPercentage = $tahapan->sum('persen');
            $stagesCount = $tahapan->count();
            $project->averagePercentage = $stagesCount > 0 ? $totalPercentage / $stagesCount : 0;
        }

        // Pass the projects to the view
        return view('admin.home', compact('projects'));
    }
    public function DataPegawai()
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
foreach ($projects as $project) {
            $tahapan = $project->tahapan ?? collect(); // Default to an empty collection
            $totalPercentage = $tahapan->sum('persen');
            $stagesCount = $tahapan->count();
            $project->averagePercentage = $stagesCount > 0 ? $totalPercentage / $stagesCount : 0;
        }

    // Pass the data to the view
    return view('pegawai.home', compact('projects', 'perusahaan', 'vendor'));
}

}
