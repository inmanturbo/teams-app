<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormTestController extends Controller
{
    public function __invoke(Request $request)
    {
        return dd($request->all());
    }
}
