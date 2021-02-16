<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   $notes = Note::where('user_id' ,Auth::id())
                      ->orderBy('created_at','desc')->get();

        return view('notes.index')->with('notes',$notes);
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' =>  'required|string',
            'content' =>  'required'
        ]);
        $note = Note::create([
            'user_id' =>  Auth::id(),
            'title' =>  $request->title,
            'content' =>   $request->content,
        ]);

        return redirect()->back() ;
    }


    public function show($id)
    {
        // $note = Note::find($id);
        return view('notes.show' ,compact('note'));
    }

    public function notesTrashed()
    {
        $notes = Note::onlyTrashed()->get();

        return view('notes.trashed')->with('notes',$notes);
    }

    public function edit($id)
    {
        //$note=Note::where('user_id',$id)->first();
        $note = Note::findOrFail($id);
       // dd($note);
        return view('notes.edit')->with('note',$note);
    }

    public function update(Request $request, Note $note)
    {
        $this->validate($request,[
            'title'=>'required',
            'content'=> 'required'
        ]);
        $note->title=$request->title;
        $note->content=$request->content;
        $note->save();
        return redirect()->back();
    }


    public function destroy($id)
    {
        $note=Note::findOrFail($id);
        $note->forceDelete();;
        return redirect()->back();
    }

    public function softDelete($id)
    {
        $note=Note::findOrFail($id);

        $note->delete($id);

        return redirect()->back();
    }

    public function deleteSoftDeleted( $id)
    {
        $note = Note::withTrashed()->findOrFail($id ) ;
        $note->forceDelete();
        return redirect()->back() ;
    }

    public function restore( $id)
    {
        // $note = Note::withTrashed()->where('id', $id )->first() ;
        $note=Note::withTrashed()->findOrFail($id);
        $note->restore();
        return redirect()->back() ;
    }
}

