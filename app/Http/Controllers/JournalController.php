<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Journal;
use App\Language;
use Image;

class JournalController extends Controller
{

 public function __construct()
 {
    $this->middleware('auth');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journal  = new Journal;
        $isEdit   = false; 
        $open     = 0;
        $journals = Journal::select('ext_id','journals.name','languages.name as language','position','url','image_url')
        ->join('languages','language_id','=','languages.id')
        ->get();

        $languages = Language::DropdownList();

        return view('journal',compact('journal','journals','languages','isEdit','open'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lang = $request->get('languages');
        $language = Language::where('code',$lang)->first();
        $imageName = '';

        $journal = Journal::create([
            'language_id' => $language->id,
            'ext_id'      => str_random(20),
            'name'        => $request->get('name'),
            'position'    => $request->get('position'),
            'url'         => $request->get('url'),
            'image_url'   => $imageName
            ]);
        
        /*save uploaded image file*/
        if($journal!=null)
        {
            $imageName = $journal->ext_id . '.' . 
            $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(
                base_path() . '/public/img/page/journal/', $imageName
                );
             
             $journal->image_url = $imageName;
             $journal->save();    
            
        }

        return redirect('/admin/journal');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ext_id)
    {
        $isEdit = true; 
        $open   = 1;
        $journal = Journal::select('ext_id','ext_id as id','journals.name','languages.code as lang_code','position','url','image_url')
        ->where('ext_id',$ext_id)
        ->join('languages','language_id','=','languages.id')

        ->first();
        $journals = Journal::select('ext_id','journals.name','languages.name as language','position','url','image_url')
        ->join('languages','language_id','=','languages.id')
        ->get();

        $languages = Language::DropdownList();

        return view('journal',compact('journal','journals','languages','isEdit','open'));

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ext_id)
    {
        $image_file = $request->file('image');

        $journal = Journal::where('ext_id',$ext_id)->first();
        
        if($image_file!=null)
        {

            $imageName = $journal->ext_id . '.' . 
            $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(
                base_path() . '/public/img/page/journal/', $imageName
                );
            $journal->image_url = $imageName;
        }

        $journal->name = $request->get('name');
        $journal->url  = $request->get('url');
        $journal->position  = $request->get('position');
        $journal->save();

        return redirect('/admin/journal');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ext_id)
    {
        try {
            $journal = Journal::where('ext_id',$ext_id)->first();
            $journal->delete();
            return response()->json(['code'=> 200, 'data'=>$ext_id]);
        } catch (Exception $e) {
            return response()->json(['code'=> 500]);
        }
    }
}
