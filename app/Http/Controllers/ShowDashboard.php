<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ShowDashboard extends Controller
{
    public function __invoke(ApiService $api)
    {
        $territories = $api->getTerritories();
        return Inertia::render('Dashboard', compact('territories'));
    }
}
