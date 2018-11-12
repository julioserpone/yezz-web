<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private function rules($optional = []) {
        $rules = [
            'name' => 'required',
            'position' => 'required',
            'anchor' => 'required|string',
            'description_en' => 'required',
            'description_es' => 'required',
        ];
        if ($optional) $rules = $rules + $optional;
        return $rules;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isEdit = false; 
        $open = 0;
        $categories = Category::withTrashed()->get();

        return view('categories',compact('categories','isEdit','open'));
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
        $v = \Validator::make($request->all(), $this->rules());
        if ($v->fails()) {
            return redirect()->back()->with('error', $v->errors())->withInput($request->all());
        }

        $data = [
            'name' => $request->get('name'),
            'position' => $request->get('position'),
            'anchor' => $request->get('anchor'),
        ];

        $category = Category::create($data);
        $category->setTranslation('description', 'en', $request->get('description_en'));
        $category->setTranslation('description', 'es', $request->get('description_es'));
        $category->save();
        
        return redirect()->back()->with('msg', trans('message.created_ok'));
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
    public function edit($id)
    {
        $isEdit = true; 
        $open = 1;
        $categories = Category::withTrashed()->get();
        $category = $categories->where('id',$id)->first();

        return view('categories',compact('categories','category','isEdit','open'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $v = \Validator::make($request->all(), $this->rules());
        if ($v->fails()) {
            return redirect()->back()->with('error', $v->errors())->withInput($request->all());
        }

        $category = Category::withTrashed()->where('id', $id)->first();
        $data = [
            'name' => $request->get('name'),
            'position' => $request->get('position'),
            'anchor' => $request->get('anchor'), 
        ];
        $category->update($data);
        $category->setTranslation('description', 'en', $request->get('description_en'));
        $category->setTranslation('description', 'es', $request->get('description_es'));
        $category->save();

        return redirect()->route('categories.index')->with('msg', trans('message.updated_ok'));
    }

    /**
     * Soft Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
        }
        return redirect()->route('categories.index');
    }

    /**
     * Force Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $category = Category::withTrashed()->where('id', $id)->first();
            return response()->json(['code'=> 200, 'data'=>$id]);
        } catch (Exception $e) {
            return response()->json(['code'=> 500]);
        }
    }

    /**
     * Active the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $category = Category::onlyTrashed()->where('id',$id);
        $category->restore();
        return redirect()->route('categories.index');
    }
}
