<?php

namespace Estivenm0\Core\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController
{
    public function index(Request $r)
    {
        return Inertia::render('Welcome');
    }

    public function dashboard(Request $r)
    {
        return Inertia::render('Dashboard');
    }
}
