<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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

        // Determine if login is email or username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // If request is API (prefixed with api/) or expects JSON, return token-based response
        if ($request->is('api/*') || $request->expectsJson()) {
            $user = User::where($fieldType, $login)->first();

            if (! $user || ! Hash::check($password, $user->password)) {
                return response()->json([
                    'message' => 'The provided credentials do not match our records.'
                ], 422);
            }

            // Create personal access token
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        }

        // Web / session based login (unchanged)
        $remember = $request->boolean('remember');
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
        // If API request using sanctum token, revoke current token
        if ($request->is('api/*') || $request->expectsJson()) {
            $user = $request->user();
            if ($user && $user->currentAccessToken()) {
                $user->currentAccessToken()->delete();
            }

            return response()->json(['message' => 'Logged out']);
        }

        // Web logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->input('role', 'mahasiswa'),
        ]);

        if ($request->is('api/*') || $request->expectsJson()) {
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token, 'token_type' => 'Bearer'], 201);
        }

        // For web flows, log the user in and redirect
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    /**
     * Return authenticated user
     */
    public function user(Request $request)
    {
        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json($request->user());
        }

        return redirect()->route('dashboard');
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
     * Show mahasiswa formal requests
     */
    public function mahasiswaFormalRequests()
    {
        return view('mahasiswa.formalrequests');
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
     * Show mahasiswa signature form
     */
    public function mahasiswaSignatureForm()
    {
        $user = Auth::user();
        $identity = $user->identity;

        return view('mahasiswa.signature', compact('user', 'identity'));
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
