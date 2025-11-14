<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            'Barista',
            'Kitchen',
            'Pastry',
            'Service / Runner',
        ];

        foreach ($divisions as $name) {
            Division::create([
                'name' => $name
            ]);
        }
    }
}
