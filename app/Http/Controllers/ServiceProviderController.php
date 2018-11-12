<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Country;
use App\ServiceProvider;

class ServiceProviderController extends Controller
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
        $isEdit = false;
        $open = 0;
        $service_provider = new ServiceProvider;
        $countries = Country::pluck('name','code as id');
        $service_providers = ServiceProvider::select('countries.name as country','ext_id','address','email','phone_number','attention','service_providers.name')
        ->join('countries','country','=','countries.code')
        ->get();

        return view('service_providers',compact('countries','service_provider','isEdit','service_providers','open'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isEdit = false;
        $open = 1;
        $service_provider = new ServiceProvider;
        $countries = Country::pluck('name','code as id');
        $service_providers = ServiceProvider::select('countries.name as country','ext_id','address','email','phone_number','attention','service_providers.name')
        ->join('countries','country','=','countries.code')
        ->get();

        return view('service_providers',compact('countries','service_provider','isEdit','service_providers','open'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $service_provider = ServiceProvider::create([
        'country'   => $request->get('countries'),
        'ext_id'    => str_random(20),
        'name'      => $request->get('name'),
        'phone_numnber' => $request->get('phone1_number'),
        'email'     => $request->get('email'),
        'address'   => $request->get('address'),
        'latitude'  => $request->get('latitude'),
        'longitude' => $request->get('longitude'),
        'attention' => $request->get('attention'),
        'active'    => 1
        ]);

       return redirect('/admin/serviceproviders');
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
        $service_provider = ServiceProvider::select('country as lang_code','ext_id','address','email','phone_number','attention','latitude','longitude','name')
        ->where('ext_id',$ext_id)
        ->first();

        $countries = Country::pluck('name','code as id');
        $service_providers   = ServiceProvider::select('countries.name as country','ext_id','address','email','phone_number','attention','service_providers.name')
        ->join('countries','country','=','countries.code')
        ->get();

        return view('service_providers',compact('countries','service_provider','isEdit','service_providers','open'));
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
        $service_provider = ServiceProvider::where('ext_id',$ext_id)->first();
        if ($service_provider!=null)
        {
            $service_provider->name      = $request->get('name');
            $service_provider->phone_number = $request->get('phone_number');
            $service_provider->email     = $request->get('email');
            $service_provider->address   = $request->get('address');
            $service_provider->latitude  = $request->get('latitude');
            $service_provider->longitude = $request->get('longitude');
            $service_provider->attention = $request->get('attention');
            $service_provider->save();
        }


        return redirect('/admin/serviceproviders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ext_id)
    {
        try{
            $service_provider = ServiceProvider::where('ext_id',$ext_id)->first();
            if ($service_provider!=null)
            {
                $service_provider->delete();
                return response()->json(['code'=>200]);

            }
            return response()->json(['code'=>404]);

        } catch (Exception $e) {
            return response()->json(['code'=>500]);
        }
    }
}
