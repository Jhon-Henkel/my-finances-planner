<?php

namespace App\Http\Controllers;

use App\Enums\RouteEnum;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;

class DashboardController
{
    public function renderDashboardView(): View|App|Factory|AppFoundation
    {
        return view(RouteEnum::WEB_DASHBOARD);
    }
}