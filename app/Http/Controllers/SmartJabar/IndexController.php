<?php

namespace App\Http\Controllers\SmartJabar;

use App\Http\Controllers\Controller;
use App\Models\SmartjabarJoinedApp;
use App\Models\SmartjabarUsageStat;

class IndexController extends Controller
{
    protected $smartJabarId = 2;

    public function index()
    {
        $data = SmartjabarJoinedApp::where('service_type_id', $this->smartJabarId)
            ->orderByDesc('year')->orderByDesc('month')->get();

        $stats = SmartjabarUsageStat::where('service_type_id', $this->smartJabarId)
            ->orderByDesc('year')->orderByDesc('month')->get();

        return response()->json(compact('data', 'stats'));
    }
}
