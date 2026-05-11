<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller

{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()

    {
        $data['meta_title'] = 'Login Page';
        $data['meta_des'] =  'Login Page';
        return view('auth.login',$data);
    }  

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function registration()
    {
        $data['meta_title'] = 'register Page';
        $data['meta_des'] =  'register Page';
        return view('auth.register',$data);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->withSuccess('You have Successfully loggedin');

        }
        return redirect()->intended('login')->withErrors(['error' => 'Oops! You have entered invalid credentials']);
    }
    /**
     * Write code on Method
     *
     * @return response()

     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',

        ]);
        try {
            $data = $request->all();
            $user = $this->create($data);
    
            if ($user) {
                Auth::login($user);
                return redirect("/")->withSuccess('Great! You have Successfully logged in');
            } else {
                return back()->with('error', 'Registration failed. Please try again.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }

    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])

      ]);

    }
    /**
     * Write code on Method
     *
     * @return response()

     */

    public function logoutuser() {
        Session::flush();
        Auth::logout();
        return Redirect('/');

    }
    public function profile() {
        $data['meta_title'] = 'profile Page';
        $data['meta_des'] =  'profile Page';
        return view('auth.profile',$data);

    }



    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // 2MB limit
        ]);
    
        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->image && file_exists(public_path('avatars/' . $user->image))) {
                unlink(public_path('avatars/' . $user->image));
            }
    
            // Store new avatar directly in the public folder
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $avatarName);
    
            // Update database with new file path
            $user->image = $avatarName;
        }
    
        $user->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    

    
}