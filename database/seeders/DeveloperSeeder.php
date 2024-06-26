<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developers = [
            ['name' => 'Dev1', 'difficulty' => 1, 'hours' => 1],
            ['name' => 'Dev2', 'difficulty' => 2, 'hours' => 1],
            ['name' => 'Dev3', 'difficulty' => 3, 'hours' => 1],
            ['name' => 'Dev4', 'difficulty' => 4, 'hours' => 1],
            ['name' => 'Dev5', 'difficulty' => 5, 'hours' => 1],
        ];

        foreach ($developers as $developer) {
            \App\Models\Developer::create($developer);
        }
    }
}
