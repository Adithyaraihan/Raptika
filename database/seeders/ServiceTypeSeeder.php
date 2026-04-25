<?php

namespace Database\Seeders;


use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['SaDAJabar', 'SmartJabar', 'Rekayasa'];

        foreach ($types as $type) {
            ServiceType::firstOrCreate(['name' => $type]);
        }
    }
}
