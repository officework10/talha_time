<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   
    public $LoginUser;

    public function __construct()
{
    // Check if technical_calculator cookie exists (user session)
    if (isset($_COOKIE['technical_calculator'])) {
        $login_id = $_COOKIE['technical_calculator']; // User's session/login ID

        // Validate the login ID from login_table
        $userId = DB::table('login_table')->where('login_id', $login_id)->value('id');

        if ($userId) {
            // Fetch user details from admins table
            $user = DB::table('admins')->where('admin_id', $userId)->first();

            // Set the LoginUser property
            $this->LoginUser = $user ? (array)$user : null;
        } else {
            $this->LoginUser = null;
        }
    } else {
        $this->LoginUser = null; // User not logged in
    }
}


	// function __construct() {
    //     if (isset($_COOKIE['technical_calculator-kindom'])) {
    //         dd($this->LoginUser);
    //         $login_id= $_COOKIE['technical_calculator-kindom'];
	// 		$id = DB::table('login_table')->where('login_id',$login_id)->select('id')->first();
    //         if ($id) {
    //             $id=$id->id;
	// 			$user = DB::table('admins')->where('admin_id',$id)->first();
    //             $this->LoginUser = (array)$user;
    //         }else{
    //             $this->LoginUser = '';
    //         }
    //     }else{
    //         $this->LoginUser = '';
    //     }
    // }

    public function index(Request $request){
        setcookie("technical_calculator-kindom" , $request->getRequestUri(), time()+24*3600*10 ,"/");
        if (!empty($this->LoginUser) && $this->LoginUser['role']=='1') {
            $users = DB::table('admins')->get();
			return view('admin/temp/users',['users'=>$users,'LoginUser'=>$this->LoginUser]);
        }else{
            return redirect(url('admin/login/'));
        }
    }
    public function saveUser($request,$id=null){
        $name=trim($request->name);
        $password=$request->password;
        $active=0;
        if (isset($request->active)) {
            $active=1;
        }
        $role=$request->role;
        $data['admin_name']=$name;
        $data['admin_pass']=$password;
        $data['is_active']=$active;
        $data['role']=$role;
        if (isset($request->logout)) {
            DB::table('login_table')->where('id',$id)->delete();
        }
        if (is_null($id)) {
            $done = DB::table('admins')->insert($data);
            $add = "Add";
        }else{
            $done = DB::table('admins')->where('admin_id',$id)->update($data);
            $add = "Update";
        }
        if($done){
            return back()->with('status',"User $add Successfully.");
        }else{
            return back()->with('status',"<strong>Error!</strong> in User $add\ing");
        }
    }
    public function addUser(Request $request){
        setcookie("technical_calculator-kindom" , $request->getRequestUri(), time()+24*3600*10 ,"/");
        if (!empty($this->LoginUser) && $this->LoginUser['role']=='1') {
            if (isset($request->add_user)) {
                $data = $request->validate([
					'name' => 'required|unique:admins,admin_name',
					'password' => 'required|confirmed',
					'password_confirmation' => 'required',
					'role' => 'required',
				]);

				$this->saveUser($request);
            }
			return view('admin/temp/add-user',['LoginUser'=>$this->LoginUser]);
        }else{
            return redirect(url('admin/login/'));
        }
    }

    public function editUser($id,Request $request){
        setcookie("technical_calculator-kindom" , $request->getRequestUri(), time()+24*3600*10 ,"/");
        if (!empty($this->LoginUser) && $this->LoginUser['role']=='1') {
            if (isset($request->add_user)) {
                $data = $request->validate([
					'name' => 'required|unique:admins,admin_name,'.$id.',admin_id',
					'password' => 'required',
					'role' => 'required',
				]);

				$this->saveUser($request,$id);
            }
            $user = DB::table('admins')->where('admin_id',$id)->first();
			return view('admin/temp/edit-user',['user'=>$user,'LoginUser'=>$this->LoginUser]);
        }else{
            return redirect(url('admin/login/'));
        }
    }
}
