<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function show($user_identifier = null)
    {
        $user_identifier_uppercase = strtoupper($user_identifier);
        return view('users.show', compact('user_identifier', 'user_identifier_uppercase'));
    }
    
    public function edit($user_identifier)
    {
        //Edit-logic

        return redirect()->route('users.show', compact('user_identifier'));
    }
}
