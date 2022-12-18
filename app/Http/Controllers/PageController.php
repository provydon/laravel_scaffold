<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PageController extends Controller
{
    public function getIndex()
    {
        $data = [
            'canLogin' => Route::has('login'),
            'appName' => env('APP_NAME'),
            'canRegister' => Route::has('register'),
            'page' => 'index',
            'title' => null,
            'description' => 'company description',
        ];

        return Inertia::render('Index', $data);
    }
}
