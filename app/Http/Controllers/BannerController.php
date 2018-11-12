<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Language;
use App\Product;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isEdit = false; 
        $open = 0;
        $banners = Banner::withTrashed()->with(['language','product'])->get();
        $products = Product::orderBy('model')->pluck('model','id');
        $products->prepend('', 0);  //Esto es para agregar un item en blanco a la lista de productos
        $languages = Language::DropdownList();

        return view('banners',compact('banners','languages','products','isEdit','open'));
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
        $language = Language::where('code',$request->get('languages'))->first();
        $url = $request->get('url');
        $id = $request->get('product_id');
        //Si la URL esta en blanco, deberia haber asignado el producto. En ese caso, busco el codigo de ese producto (no el ID), para asignarle la ruta
        if ($id) {
            $product = Product::find($id);
            $url = 'products/'.$product->model_id.'/'.$language->code;
        }
        $data = [
            'language_id' => $language->id,
            'product_id' => ($request->get('product_id')) ? : null,
            'position' => ($request->get('position')) ? : 1,
            'url' => $url,
            'description' => ($request->get('description')) ? : (($id) ? $product->model : null), 
        ];

        $banner = Banner::create($data);
        if ($request->file('image')) {
            $banner->addMedia($request->file('image'))->toMediaCollection('banners', env('FILESYSTEM'));
        }
        
        return redirect()->route('banners.index');
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
        $banners = Banner::withTrashed()->with(['language','product'])->get();
        $banner = $banners->where('id',$id)->first();
        $products = Product::orderBy('model')->pluck('model','id');
        $products->prepend('', 0);  //Esto es para agregar un item en blanco a la lista de productos
        $languages = Language::DropdownList();

        return view('banners',compact('banners','banner','languages','products','isEdit','open'));
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
        $banner = Banner::withTrashed()->where('id', $id)->first();
        $language = Language::where('code',$request->get('languages'))->first();
        $url = $request->get('url');
        $id = $request->get('product_id');
        //Si la URL esta en blanco, deberia haber asignado el producto. En ese caso, busco el codigo de ese producto (no el ID), para asignarle la ruta
        if ($id) {
            $product = Product::find($id);
            $url = 'products/'.$product->model_id.'/'.$language->code;
        }
        $data = [
            'language_id' => $language->id,
            'product_id' => ($request->get('product_id')) ? : null,
            'position' => ($request->get('position')) ? : 1,
            'url' => $url,
            'description' => ($request->get('description')) ? : (($id) ? $product->model : null), 
        ];

        $banner->update($data);
        if ($request->file('image')) {
            $media = $banner->getFirstMedia('banners');
            if ($media) {
                $media->delete();
            }
            $banner->addMedia($request->file('image'))->toMediaCollection('banners', env('FILESYSTEM'));
        }
        return redirect()->route('banners.index');
    }

    /**
     * Soft Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();
        }
        return redirect()->route('banners.index');
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
            $banner = Banner::withTrashed()->where('id', $id)->first();
            if ($banner) {
                //$media = $banner->getMedia('banners');
                $banner->clearMediaCollection('banners');
                $banner->forceDelete();
            }
            return response()->json(['code'=> 200, 'data'=>$id]);
        } catch (Exception $e) {
            return response()->json(['code'=> 500]);
        }
    }

    public function active($id)
    {
        $banner = Banner::onlyTrashed()->where('id',$id);
        $banner->restore();
        return redirect()->route('banners.index');
    }
}
