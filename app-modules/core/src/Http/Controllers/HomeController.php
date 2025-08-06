<?php

namespace Estivenm0\Core\Http\Controllers;

use Estivenm0\Core\Services\MapService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController
{
    public function __construct(protected MapService $mapService) {}

    public function index(Request $r)
    {
        return Inertia::render('Welcome', [
            'businesses' => $this->mapService->businesses($r),
        ]);
    }

    public function dashboard(Request $r)
    {
        return Inertia::render('Dashboard', [
            'businesses' => $this->mapService->businesses($r),
        ]);
    }
}
