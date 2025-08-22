<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Core\Services\MapService;

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
