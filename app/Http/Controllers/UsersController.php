<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    /**
     * Register a new user view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function registerView()
    {
        return view('user.registerView');
    }

    /**
     * Registers a new seeker with the provided registration request data.
     *
     * @param RegistrationFormRequest $request The request containing the seeker's registration data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the login page after successful registration.
     */
    public function register(RegistrationFormRequest $request)
    {
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->sendEmailVerificationNotification();

        return redirect('login')->with('success', 'Registration successful');
    }

    /**
     * Registers a new employer user.
     *
     * @param RegistrationFormRequest $request The request object containing the registration form data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the login page after successful registration.
     */
    public function employerRegister(RegistrationFormRequest $request)
    {

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => 'employer',
            'trial' => now()->addWeek()
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return response()->json('success');
    }

    /**
     * Renders the login view if the user is not authenticated, otherwise redirects to the dashboard.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function loginView()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('user.login');
    }

    /**
     * Logs in a user based on the provided request data.
     *
     * @param Request $request The request object containing the user's email and password.
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the dashboard if login is successful,
     * or redirects back with an error message if login fails.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        echo $request->email;

        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            echo 'success';
            return redirect()->intended('dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function employerRegisterView()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('user.employerRegisterView');
    }

    /**
     * Logs out the user and redirects to the login page.
     *
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the login page after logging out.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
