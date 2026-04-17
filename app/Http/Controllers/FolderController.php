<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use Illuminate\Support\Facades\DB;


class FolderController extends Controller
{
    public function index()
{
    $role = Auth::user()->role; // ✅ ADD THIS

    $folders = DB::table('folders')->get();

    return view('admin.folder', compact('folders', 'role')); // ✅ PASS IT
}

public function storefolder(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    DB::table('folders')->insert([
        'name' => $request->name,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Folder created successfully!');
}

public function update(Request $request)
{
    $request->validate([
        'id' => 'required',
        'name' => 'required|string|max:255'
    ]);

    $folder = Folder::findOrFail($request->id);
    $folder->name = $request->name;
    $folder->save();

    return back()->with('success', 'Folder updated');
}

}
