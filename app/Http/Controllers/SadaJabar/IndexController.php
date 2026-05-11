<?php

namespace App\Http\Controllers\SadaJabar;

use App\Http\Controllers\Controller;
use App\Models\SadajabarAppIntegration;
use App\Models\SadajabarEncryptionStat;

class IndexController extends Controller
{
    protected $sadajabarId = 1;

    public function index()
    {
        $enkripsi  = SadajabarEncryptionStat::where('service_type_id', $this->sadajabarId)
            ->orderByDesc('year')->orderByDesc('month')->get();

        $integrasi = SadajabarAppIntegration::with('institutionCategory')
            ->where('service_type_id', $this->sadajabarId)
            ->orderByDesc('year')->orderByDesc('month')->get();

        return response()->json(compact('enkripsi', 'integrasi'));
    }
}
