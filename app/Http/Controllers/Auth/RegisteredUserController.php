<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

        $request->merge([
            'email' => strtolower($request->email),
            'identifier' => strtolower($request->identifier),
            'password' => Str::random(12),
        ]);

        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'identifier' => ['required', 'string', 'lowercase', 'unique:users,identifier', 'regex:/^\S*$/u'],
        ];

        if ($request['role_id'] != env('TEACHER_ROLE_ID')) $request['email'] = $request['identifier'] . env('STUDENT_EMAIL_DOMAIN');
    
        $validatedData = $request->validate($rules);

        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'role_id' => $validatedData['role_id'],
            'identifier' => $validatedData['identifier'],
            'email' => $validatedData['email'],
            'password' => Hash::make($request->password),
        ]);
        
        ApiKey::setApiKeyForUser($user->id);

        event(new Registered($user));

        return redirect('/admin/'.$request->identifier);
    }

    public function importWithExcel()
    {
        return view('auth.import-users-excel');
    }

    public function storeWithExcel(Request $request)
    {
        $required_rows = [
            "full_name",
            "identifier"
        ];
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv'
        ]);
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        $header = null;
        $errors = [];
        $created_users = 0;

        foreach ($rows as $index => $row) {
            if ($index === 0){
                $header = $row;
                $missing = array_diff($required_rows, $header);
                
                if (!empty($missing)) {
                    return redirect()->back()->with([
                        'message' => 'Er zijn geen verplichte kolommen in een Excel-bestand: ' . implode(', ', $missing)
                    ]);
                }

                continue;
            }

            $data = [
                'full_name' => $row[array_search('full_name', $header)],
                'email' => $row[array_search('identifier', $header)] . env('STUDENT_EMAIL_DOMAIN'),
                'role_id' => 2,
                'identifier' => $row[array_search('identifier', $header)],
            ];
            $userRequest = new StoreUserRequest();
            $validator = Validator::make($data, $userRequest->rules());

            if ($validator->fails()) {
                $errors[$index] = $validator->errors();
                continue;
            }

            $data['email'] = strtolower($data['email']);
            $data['identifier'] = strtolower($data['identifier']);
            $password = Str::random(12);
            $data['password'] = Hash::make($password);

            $user = User::create($data);
            ApiKey::setApiKeyForUser($user->id);
            $created_users = $created_users + 1;
        }

        $message = "Bestand is succesvol geïmporteerd";
        if (!$created_users > 0) $message = "Het bestand bevat geen nieuwe gegevens om te importeren.";

        return redirect()->back()->with([
            'message' => $message,
            'errors' => $errors,
        ]);
    }
}
