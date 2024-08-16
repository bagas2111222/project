<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class UserController extends Controller
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
        $pegawai = User::all();
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        // Pass both projects and companies to the view
        return view('admin.pegawai', compact('pegawai'));
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
            'username' => ['required', 'unique:users,email'],
            'struktur' => 'required|string',
            'password' => 'required|string',
        ]);

        // Create a new project instance and fill it with validated data
        $user = new User();
        $user->name = $validatedData['nama'];
        $user->email = $validatedData['username'];
        $user->struktur = $validatedData['struktur'];
        $user->password = Hash::make($validatedData['password']); // Hash the password

        // Save the user to the database
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'user added successfully!');
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
        // Find the user by ID

        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required',
            'nama' => 'required|string|max:255',
            'username' => ['required', Rule::unique('users', 'email')->ignore($request->id)],
            'struktur' => 'required|string',
            'password' => 'nullable|string', // Make password nullable
        ]);
        $user = User::findOrFail($validatedData['id']);

        // Update the user instance with validated data
        $user->name = $validatedData['nama'];
        $user->email = $validatedData['username'];
        $user->struktur = $validatedData['struktur'];

        // Check if the password is provided, if so, hash it and update
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Save the updated user to the database
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User updated successfully!');
    }
    public function destroy(User $user)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }

    // Check if the authenticated user's struktur is 'admin'
    if (auth()->user()->struktur !== 'admin') {
        abort(403, 'Unauthorized access.');
    }
    $user->delete();
    alert()->success('Hore!','user Deleted Successfully');
    return back();
    }
     public function adminProfile()
{
    $userId = auth()->user()->id;
    $pegawai = User::where('id', $userId)->first(); // Atau firstOrFail() jika ingin memastikan bahwa pengguna pasti ditemukan
    return view('admin.profile', compact('pegawai'));
}
//pegawai
    public function profile()
{
    $userId = auth()->user()->id;
    $pegawai = User::where('id', $userId)->first(); // Atau firstOrFail() jika ingin memastikan bahwa pengguna pasti ditemukan
    return view('pegawai.profile', compact('pegawai'));
}
public function editProfile(Request $request)
    {
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
    }
        // Find the user by ID

        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required',
            'nama' => 'required|string|max:255',
            'username' => ['required', Rule::unique('users', 'email')->ignore($request->id)],
            'password' => 'nullable|string', // Make password nullable
        ]);
        $user = User::findOrFail($validatedData['id']);

        // Update the user instance with validated data
        $user->name = $validatedData['nama'];
        $user->email = $validatedData['username'];

        // Check if the password is provided, if so, hash it and update
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Save the updated user to the database
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User updated successfully!');
    }

}
