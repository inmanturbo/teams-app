<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocsController extends Controller
{
    public function index(Request $request, $file = 'index'): Response
    {
        if ($file != 'index') {
            $file = $file . '/index';
        }

        return File::get(public_path() . '/docs/' . $file . '.html');
    }
}
