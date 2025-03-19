<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function show($user_id = null)
    {
        return view('users.show', compact('user_id'));
    }
    
    public function edit($user_id)
    {
        //Edit-logic

        return redirect()->route('users.show', compact('user_id'));
    }
}
