<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ShowDashboard extends Controller
{
    public function __invoke(ApiService $api)
    {
        $teritories = $api->getTerritories();
        return Inertia::render('Dashboard', compact('teritories'));
    }
}
