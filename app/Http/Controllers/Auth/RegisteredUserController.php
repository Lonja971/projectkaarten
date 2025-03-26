<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use App\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * 
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ];

        if ($request->role_id != 1)
        {
            $rules['identifier'] = ['required', 'integer', 'unique:users,identifier'];
        }
    
        $validatedData = $request->validate($rules);

        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'role_id' => $validatedData['role_id'],
            'identifier' => $validatedData['identifier'] ?? null,
            'email' => $validatedData['email'],
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect('/admin/'.$request->identifier);
    }
}
