<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showForm()
    {
        $users = session('users', []);
        return view('register', [
            'users' => $users,
            'showUsers' => false,
            'accessDenied' => false
        ]);
    }

    public function handleForm(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $age = (int)$request->input('age');

        if ($age >= 15) {
            return view('register', [
                'users' => [],
                'showUsers' => false,
                'accessDenied' => true
            ]);
        }

        $users = session('users', []);
        $users[] = ['name' => $name, 'email' => $email, 'age' => $age];
        session(['users' => $users]);

        return view('register', [
            'users' => $users,
            'showUsers' => true,
            'accessDenied' => false
        ]);
    }
}
    }
}
