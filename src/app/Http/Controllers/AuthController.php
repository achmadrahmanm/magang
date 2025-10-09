<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->email;
        $password = $request->password;
        $remember = $request->boolean('remember');

        // Determine if login is email or username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $login,
            'password' => $password
        ];

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'sysadmin':
                return redirect()->route('dashboard.sysadmin');
            case 'mahasiswa':
                return redirect()->route('dashboard.mahasiswa');
            case 'dosen':
                return redirect()->route('dashboard.dosen');
            case 'management':
                return redirect()->route('dashboard.management');
            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Show the general dashboard
     */
    public function dashboard()
    {
        //    return view('dashboards.general');
        return $this->redirectBasedOnRole();
    }

    /**
     * Show the sysadmin dashboard
     */
    public function sysadminDashboard()
    {
        return view('dashboards.sysadmin');
    }

    /**
     * Show the mahasiswa dashboard
     */
    public function mahasiswaDashboard()
    {
        return view('dashboards.mahasiswa');
    }

    /**
     * Show mahasiswa courses
     */
    public function mahasiswaCourses()
    {
        return view('mahasiswa.courses');
    }

    /**
     * Show mahasiswa grades
     */
    public function mahasiswaGrades()
    {
        return view('mahasiswa.grades');
    }

    /**
     * Show mahasiswa schedule
     */
    public function mahasiswaSchedule()
    {
        return view('mahasiswa.schedule');
    }

    /**
     * Show mahasiswa assignments
     */
    public function mahasiswaAssignments()
    {
        return view('mahasiswa.assignments');
    }

    /**
     * Show mahasiswa settings
     */
    public function mahasiswaSettings()
    {
        return view('mahasiswa.settings');
    }

    /**
     * Show mahasiswa profile
     */
    public function mahasiswaProfile()
    {
        $user = Auth::user();
        $identity = $user->identity;

        return view('mahasiswa.profile', compact('user', 'identity'));
    }

    /**
     * Show the dosen dashboard
     */
    public function dosenDashboard()
    {
        return view('dashboards.dosen');
    }

    /**
     * Show the management dashboard
     */
    public function managementDashboard()
    {
        return view('dashboards.management');
    }
}
