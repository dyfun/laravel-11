<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            ['name' => 'Provider A', 'class_name' => 'ProviderA'],
            ['name' => 'Provider B', 'class_name' => 'ProviderB'],
        ];

        foreach ($providers as $provider) {
            \App\Models\Provider::create($provider);
        }
    }
}
