<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index($age)
    {
        if ($age < 15) {
            return view('hello', [
                'accessDenied' => true,
                'age' => $age,
                'cars' => []
            ]);
        }

        $cars = [
            ['name' => 'Toyota', 'model' => 'Corolla', 'year' => 2020],
            ['name' => 'Honda', 'model' => 'Civic', 'year' => 2019],
            ['name' => 'Ford', 'model' => 'Focus', 'year' => 2018],
        ];

        return view('hello', [
            'cars' => $cars,
            'age' => $age,
            'accessDenied' => false
        ]);
    }
}
