<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Country;
use App\Seller;

class SellerController extends Controller
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
        $seller = new Seller;
        $countries = Country::pluck('name','code as id');
        $sellers = Seller::select('countries.name as country','ext_id','address1','email1','phone1','attention','sellers.name')
        ->join('countries','country_id','=','countries.id')
        ->get();

        return view('sellers',compact('countries','seller','isEdit','sellers','open'));
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
        $seller = new Seller;
        $countries = Country::pluck('name','code as id');
        $sellers = Seller::select('countries.name as country','ext_id','address1','email1','phone1','attention','sellers.name')
        ->join('countries','country_id','=','countries.id')
        ->get();

        return view('sellers',compact('countries','seller','isEdit','sellers','open'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country_id = Country::where('code',$request->get('countries'))->first()->id;
        $seller = Seller::create([
            'country_id'=> $country_id,
            'ext_id'    => str_random(20),
            'name'      => $request->get('name'),
            'address1'  => $request->get('address1'),
            'address2'  => $request->get('address2'),
            'phone1'    => $request->get('phone1'),
            'phone2'    => $request->get('phone2'),
            'email1'    => $request->get('email1'),
            'email2'    => $request->get('email2'),
            'latitude'  => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
            'attention' => $request->get('attention'),
            ]);

        return redirect('/admin/sellers');
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
       $seller = Seller::select('countries.code as country','ext_id','address1','address2','email1','email2','phone1','phone2','attention','latitude','longitude','sellers.name')
       ->join('countries','country_id','=','countries.id')
       ->where('ext_id',$ext_id)
       ->first();

       $countries = Country::pluck('name','code as id');
       $sellers   = Seller::select('countries.name as country','ext_id','address1','email1','phone1','attention','sellers.name')
       ->join('countries','country_id','=','countries.id')
       ->get();

       return view('sellers',compact('countries','seller','isEdit','sellers','open'));

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
        $seller = Seller::where('ext_id',$ext_id)->first();
      

        if($seller!=null){
            $seller->name      = $request->get('name');
            $seller->address1  = $request->get('address1');
            $seller->address2  = $request->get('address2');
            $seller->phone1    = $request->get('phone1');
            $seller->phone2    = $request->get('phone2');
            $seller->email1    = $request->get('email1');
            $seller->email2    = $request->get('email2');
            $seller->latitude  = $request->get('latitude');
            $seller->longitude = $request->get('longitude');
            $seller->attention = $request->get('attention');
            $seller->save();     
        }
        
        return redirect('/admin/sellers');  

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
            $seller = Seller::where('ext_id',$ext_id)->first();
            $seller->delete();


            return response()->json(['code'=>200]);
            
        } catch (Exception $e) {
            return response()->json(['code'=>500]);
        }
    }
}
