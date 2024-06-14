<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function user_list(Request $request){
        try{
            $query = DB::table('users')->join('roles','roles.id','=','users.role_id');
            $users = $query->where('users.is_deleted',0)->select('users.*','roles.name as role_name')->get();
            echo json_encode([
                'users' => $users
            ]);
            exit;
        }catch(\Exception $ex){
            return json_encode([]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id','!=',1)->where('is_deleted',0)->get();
        return view('users.create',compact('roles'));
    }

    public function change_password($id)
    {
        $user_data = User::where('id',$id)->where('is_deleted',0)->first();
        return view('users.change_password',compact('user_data'));
    }

    public function change_password_store($id,Request $request)
    {
        $user = User::where('id',$id)->where('is_deleted',0)->first();

        $adminUser = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8', // confirmed means it must match 'password_confirmation' field
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

        } else {
            return back()->with('error', 'The provided old password does not match your current password.');
        }
        return redirect()->route('users')->with('success','Password Changed successfully.');
    }

    public function redirect(){
        return view('users.redirect');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required',
        ], [
            'name.required' => 'Username is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'role_id.required' => 'Role is required',
        ]);

        $user_data = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => $request->get('role_id'),
        ]);

        $user_data->save();

        return redirect()->route('users')
            ->with('success','User created successfully.');
    }

    public function edit($id){
        $user_data = User::where('id',$id)->where('is_deleted',0)->first();

//        $decryptedPassword = decrypt($user_data->password);
//        dd($decryptedPassword);
//        $user_data->password = $decryptedPassword;
        $roles = Role::where('id','!=',1)->where('is_deleted',0)->get();
        return view('users.edit',compact('user_data','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
//            'password' => 'required',
            'role_id' => 'required',
        ], [
            'name.required' => 'Username is required',
            'email.required' => 'Email is required',
//            'password.required' => 'Password is required',
            'role_id.required' => 'Role is required',
        ]);

        User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
//                'password' => encrypt($request->password),
                'role_id' => $request->role_id,
            ]);

        return redirect()->route('users')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        User::where('id', $request->id)
            ->update([
                'is_deleted' => 1
            ]);

        echo json_encode(['message' => 'Deleted successfully']);
    }
}
