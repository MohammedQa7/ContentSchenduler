<?php

namespace Database\Seeders;

use App\Enums\PlatformTypes;
use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = collect(PlatformTypes::cases())->map(function ($platform) {
            Platform::firstOrCreate([
                'name' => $platform->value,
                'type' => $platform->value,
            ]);
        });
    }
}