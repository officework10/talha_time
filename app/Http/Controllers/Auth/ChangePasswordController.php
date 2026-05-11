<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data['meta_title'] = 'Change Password';
        $data['meta_des'] =  'Change Password';
        return view('auth.change-password',$data);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        // Define validation rules
        $rules = [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        // Check if the user has a password set
        if (!empty($user->password)) {
            $rules['current_password'] = ['required', 'string', 'min:8'];
        }
        // Validate request
        $request->validate($rules);
        // If the user has a password, verify the current password
        if (!empty($user->password) && !Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('status', 'Current Password does not match the old password.');
        }
        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->back()->with('message', 'Password updated successfully.');
    }


   


    
}