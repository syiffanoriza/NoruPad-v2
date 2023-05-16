<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotesResource;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $notes = Notes::where('owner', $user)->get();
        return NotesResource::collection($notes);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'notes' => 'required'
        ]);

        $request['owner'] = Auth::user()->id;

        $notes = Notes::create($request->all());
        return new NotesResource($notes);
    }

    public function read($id)
    {
        $notes = Notes::findOrFail($id);
        return new NotesResource($notes);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'notes' => 'required'
        ]);

        $notes = Notes::findOrFail($id);
        $notes->update($request->all());

        return new NotesResource($notes);
    }

    public function delete($id)
    {
        $notes = Notes::findOrFail($id);
        $notes->delete();

        return response()->json(['message' => 'Note deleted successfully!']);
    }
}
