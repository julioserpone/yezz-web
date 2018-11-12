<?php

namespace App\Http\Controllers;

use App\YezztalkLog;
use App\User;
use App\UserRol;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class UserController extends Controller
{
    private function rules($optional = []) {
        $rules = [
            'rol_id' => 'required',
            'name' => 'required|string',
            'gender' => 'required',
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
        $roles = UserRol::where('ext_id', '<>', 'web_user')->pluck('name', 'id');
        $users = User::withTrashed()->with('rol')->get();
                                     
        return view('adminuser', compact('roles','isEdit','open','users'));
    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
         $user = new User;
         return view('users.create',['user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validar que los datos esten completos
        $optional['email'] = 'required|unique:users,email';
        $optional['password'] = 'required';
        $v = \Validator::make($request->all(), $this->rules());
        if ($v->fails())
        {
            if ($request->ajax() || $request->wantsJson()){
                return new JsonResponse($v->errors(), 422);
            } else {
                return redirect()->back()->with('error', $v->errors())->withInput($request->all());
            }
        } 

        $cuser = \Auth::user();
        $role = UserRol::where('id', $request->get('rol_id'))->first(); 
        $user = User::create([ 
            'rol_id'     => $role->id,
            'name'       => $request->get('name'),
            'email'      => $request->get('email'),
            'gender'     => $request->get('gender'),
            'created_by' => $cuser->name,
            'password'   => bcrypt($request->get('password'))
        ]);

        if($user->count()>0){
            $log = YezztalkLog::create([
                'user_id'   => $cuser->id,
                'action'    => 'create',
                'entity'    => 'users',
                'ext_id'    =>  $user->id
            ]);
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
        $roles = UserRol::where('ext_id', '<>', 'web_user')->pluck('name', 'id');
        $users = User::withTrashed()->with('rol')->get();
        $user = $users->where('id',$id)->first();

        return view('adminuser', compact('roles','user','isEdit','open','users','user'));
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
        $optional['email'] = 'required|unique:users,email,'.$id.',id|email';
        $v = \Validator::make($request->all(), $this->rules($optional));
        if ($v->fails())
        {
            if ($request->ajax() || $request->wantsJson()){
                return new JsonResponse($v->errors(), 422);
            } else {
                return redirect()->back()->with('error', $v->errors())->withInput($request->all());
            }
        } 

        $role = UserRol::where('id', $request->get('rol_id'))->first(); 
        $user = User::where('id',$id)->first();
        $data = [ 
            'rol_id'     => $role->id,
            'name'       => $request->get('name'),
            'email'      => $request->get('email'),
            'gender'     => $request->get('gender'),
        ];
        if ($request->get('password')) {
            $data['password'] = bcrypt($request->get('password'));
        }
        $user->update($data);

        return redirect()->route('users.index')->with('msg', trans('message.updated_ok'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('users.index');
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
            $user = User::withTrashed()->where('id', $id)->first();
            if ($user) {
                $user->forceDelete();
            }
            return response()->json(['code'=> 200, 'data'=>$id]);
        } catch (Exception $e) {
            return response()->json(['code'=> 500]);
        }
    }

    public function active($id)
    {
        $user = User::onlyTrashed()->where('id',$id);
        $user->restore();
        return redirect()->route('users.index');
    }
}
