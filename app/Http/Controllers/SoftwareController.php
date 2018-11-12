<?php

namespace App\Http\Controllers;

use App\Software;
use App\SystemOperative;
use App\Product;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    private function rules($optional = []) {
        $rules = [
            'product_id' => 'required',
            'system_operatives_id' => 'required',
            'information' => 'required|string',
            'part_number' => 'required',
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
        $softwares = Software::withTrashed()->with(['product','system_operative'])->get();
        $system_operatives = SystemOperative::orderBy('name')->pluck('name','id');
        $system_operatives->prepend('', 0);  //Esto es para agregar un item en blanco a la lista de sistemas operativos
        $products = Product::orderBy('model')->pluck('model','id');
        $products->prepend('', 0);  //Esto es para agregar un item en blanco a la lista de productos

        return view('softwares',compact('softwares','system_operatives','products','isEdit','open'));
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

        $optional['file_software'] = 'required|file|max:5000000';
        $v = \Validator::make($request->all(), $this->rules($optional));
        if ($v->fails()) {
            return redirect()->back()->with('error', $v->errors())->withInput($request->all());
        }

        $data = [
            'product_id' => ($request->get('product_id')) ? : null,
            'system_operatives_id' => ($request->get('system_operatives_id')) ? : null,
            'information' => ($request->get('information')) ? : null,
            'part_number' => ($request->get('part_number')) ? : null,
            'hardware_version' => ($request->get('hardware_version')) ? : null, 
        ];

        $software = Software::create($data);
        if ($request->file('file_software')) {
            $software->addMedia($request->file('file_software'))->toMediaCollection('softwares', env('FILESYSTEM'));
        }
        
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
        $softwares = Software::withTrashed()->with(['product','system_operative'])->get();
        $software = $softwares->where('id',$id)->first();
        $system_operatives = SystemOperative::orderBy('name')->pluck('name','id');
        $system_operatives->prepend('', 0);  //Esto es para agregar un item en blanco a la lista de sistemas operativos
        $products = Product::orderBy('model')->pluck('model','id');
        $products->prepend('', 0);  //Esto es para agregar un item en blanco a la lista de productos

        return view('softwares',compact('softwares','software','system_operatives','products','isEdit','open'));
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

        $optional['file_software'] = 'file|max:5000000';
        $v = \Validator::make($request->all(), $this->rules($optional));
        if ($v->fails()) {
            return redirect()->back()->with('error', $v->errors())->withInput($request->all());
        }

        $software = Software::withTrashed()->where('id', $id)->first();
        $data = [
            'product_id' => ($request->get('product_id')) ? : null,
            'system_operatives_id' => ($request->get('system_operatives_id')) ? : null,
            'information' => ($request->get('information')) ? : null,
            'part_number' => ($request->get('part_number')) ? : null,
            'hardware_version' => ($request->get('hardware_version')) ? : null, 
        ];

        $software->update($data);
        if ($request->file('file_software')) {
            $media = $software->getFirstMedia('softwares');
            if ($media) {
                $media->delete();
            }
            $software->addMedia($request->file('file_software'))->toMediaCollection('softwares', env('FILESYSTEM'));
        }
        return redirect()->route('softwares.index')->with('msg', trans('message.updated_ok'));
    }

    /**
     * Soft Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $software = Software::find($id);
        if ($software) {
            $software->delete();
        }
        return redirect()->route('softwares.index');
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
            $software = Software::withTrashed()->where('id', $id)->first();
            if ($software) {
                $software->clearMediaCollection('softwares');
                $software->forceDelete();
            }
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
        $software = Software::onlyTrashed()->where('id',$id);
        $software->restore();
        return redirect()->route('softwares.index');
    }

    /**
     * Return view Authorized Service Center
     * @param  string $language language frontend
     * @return blade       View Blade
     */
    public function authorizedService($lang_country = 'en') {

        \App::setlocale($lang_country);
        $softwares = Software::with(['system_operative','product'])->get();

        return view('public.services.service_authorized', compact('softwares','lang_country'));
    }

    public function download($id) {

        $software = Software::find($id);
        $media = $software->getFirstMedia('softwares');

        return redirect($media->getUrl());
    }
}
