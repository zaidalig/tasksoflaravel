<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Image;
use Session;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if (auth()->user()) {
            return view('auth.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
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
            $request->session()->flash('status', 'you are logged in');
            return view('auth.dashboard');
        }

        $request->session()->flash('email', $request->email);
        $request->session()->flash('password', $request->password);

        $request->session()->flash('status', 'Wrong Email OR Password');
        return redirect()->route("login");
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
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),

            ],
            'confirm_password' => 'required|same:password|min:8',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',

        ]);
        if ($request->hasFile('image')) {

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->confirm_password = Hash::make($request->confirm_password);
            $user->image = $request->image->getClientOriginalName();
            $imageName = $request->image->getClientOriginalName();
            $image = Image::make($request->file('image'))->resize(150, 100);
            $path = 'thumbnails/' . $request->image->getClientOriginalName();
            $image->save($path);
            $user->save();
            $request->session()->flash('status', 'You have been registered successfully');
            return view('auth.dashboard');
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->confirm_password = Hash::make($request->confirm_password);
        $user->save();

        $request->session()->flash('status', 'You have been registered successfully');
        return view('auth.dashboard');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }
        $request->session()->flash('status', 'You are not  logged in  ');
        return view("auth.login");
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
            'password' => Hash::make($data['password']),
            'confirm_password' => Hash::make($data['confirm_password']),
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login');
    }

    public function gotoprofile()
    {

        $id = Auth::user()->id;
        $user = User::find($id);
        return view('auth.profile', compact('user'));
    }

    public function edit_profile(Request $request)
    {

        $id = Auth::user()->id;
        $user = User::find($id);
        if ($request->hasFile('image')) {
            $user->image = $request->image->getClientOriginalName();
            $imageName = $request->image->getClientOriginalName();
            $image = Image::make($request->file('image'))->resize(150, 100);
            $path = 'thumbnails/' . $request->image->getClientOriginalName();

            if(Auth::user()->image=='user.jpg'){
                // we dont want to delete the default image
            }else{
            File::delete(asset('thumbnails/' . Auth::user()->image));
            }
            $image->save($path);

            $user->save();
            $request->session()->flash('status', 'Profile Updated');
            return redirect()->route('dashboard');

        }
        if (!($request->hasFile('image')) &&$request->email == Auth::user()->email && $request->name == Auth::user()->name) {

            $request->session()->flash('status', 'Nothing Updated');
            return view("auth.dashboard");
        } elseif ($request->email == Auth::user()->email && $request->name != Auth::user()->name) {
            $request->validate([
                'name' => 'required',
            ]);

            $user->name = $request->name;
            $user->save();
            $request->session()->flash('status', 'Name Updated Successfully ');

            return view("auth.dashboard");
        } elseif ($request->email != Auth::user()->email && $request->name != Auth::user()->name) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',

            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $request->session()->flash('status', 'Email And Name Updated Successfully');

            return view("auth.dashboard");
        } else {
            $request->validate([
                'email' => 'required|email|unique:users',
            ]);

            $user->email = $request->email;
            $user->save();
            $request->session()->flash('status', 'Email  Updated Successfully');

            return view("auth.dashboard");
        }
    }

    public function change_password()
    {
        return view('auth.change_password');
    }

    public function check_and_update_password(Request $request)
    {

        $id = Auth::user()->id;
        $user = User::find($id);

        //  dd([Hash::make($request->old_password),$user->password,$user->name]);
        // if (Hash::make($request['old_password']) == $user->password) {
        //     dd('xsif');
        // }

        if (!Hash::check(Hash::make($request['old_password']), $user->password)) {
            $user->password = Hash::make($request->old_password);
            $user->save();
            $request->session()->flash('status', 'Password  Updated Successfully');
            return view("auth.dashboard");

        }
    }
}
