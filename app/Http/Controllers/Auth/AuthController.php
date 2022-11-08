<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\Validation\Rules\Password;


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

        ]);

        $data = $request->all();
        $check = $this->create($data);
        $request->session()->flash('status', 'You have been registered successfully');
        return redirect()->route('auth.dashboard');
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
            'confirm_password' => Hash::make($data['confirm_password'])
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
        if ($request->email == Auth::user()->email && $request->name == Auth::user()->name) {


            $request->session()->flash('status', 'Nothing Updated');
            return view("auth.dashboard");
        } elseif ($request->email == Auth::user()->email && $request->name != Auth::user()->name) {
            $request->validate([
                'name' => 'required',
            ]);
            $id = Auth::user()->id;
            $user = User::find($id);
            $user->name = $request->name;
            $user->save();
            $request->session()->flash('status', 'Name Updated Successfully ');

            return view("auth.dashboard");
        } elseif ($request->email != Auth::user()->email && $request->name != Auth::user()->name) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',

            ]);

            $id = Auth::user()->id;
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $request->session()->flash('status', 'Email And Name Updated Successfully');

            return view("auth.dashboard");
        } else {
            $request->validate([
                'email' => 'required|email|unique:users',
            ]);

            $id = Auth::user()->id;
            $user = User::find($id);
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
