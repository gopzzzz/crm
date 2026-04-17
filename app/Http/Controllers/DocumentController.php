<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
  public function index()
{
    $role = Auth::user()->role;

    $documents = DB::table('documents')
        ->leftJoin('folders', 'documents.folder_id', '=', 'folders.id')
        ->select(
            'documents.*',
            'folders.name as folder_name'
        )
        ->orderBy('documents.id', 'desc')
        ->get();

    $folders = DB::table('folders')->get();

    return view('admin.documents', compact('documents', 'folders', 'role'));
}

public function storedocument(Request $request)
{
    $request->validate([
        'folder_id' => 'required|exists:folders,id',
        'document_name' => 'required|string|max:255',
        'file' => 'required|file',
    ]);

    $fileName = null;

    if ($request->hasFile('file')) {
        $fileName = uniqid() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads/documents'), $fileName);
    }

    DB::table('documents')->insert([
        'folder_id' => $request->folder_id,
        'document_name' => $request->document_name,
        'file' => $fileName,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Document added Successfully!');
}

public function documentedit(Request $request)
{
    $request->validate([
        'id' => 'required|exists:documents,id',
        'folder_id' => 'required|exists:folders,id',
        'document_name' => 'required|string|max:255',
        'file' => 'nullable|file',
    ]);

    $doc = DB::table('documents')->where('id', $request->id)->first();

    if ($request->hasFile('file')) {
        $fileName = uniqid() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads/documents'), $fileName);
    } else {
        $fileName = $doc->file;
    }

    DB::table('documents')
        ->where('id', $request->id)
        ->update([
            'folder_id' => $request->folder_id,
            'document_name' => $request->document_name,
            'file' => $fileName,
            'updated_at' => now(),
        ]);

    return redirect()->back()->with('success', 'Document Updated Successfully!');
}
}
