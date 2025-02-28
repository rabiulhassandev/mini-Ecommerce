<?php

namespace Database\Seeders;

use App\Models\Admin\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'White',
                'color_code' => '#ffffff',
            ],
            [
                'name' => 'Black',
                'color_code' => '#000000',
            ],
            [
                'name' => 'Green',
                'color_code' => 'green',
            ],
            [
                'name' => 'Blue',
                'color_code' => 'blue',
            ],
            [
                'name' => 'Orange',
                'color_code' => 'orange',
            ],
        ];

        foreach ($data as  $item) {
            Color::create([
                'name' => $item['name'],
                'color_code' => $item['color_code'],
            ]);
        }
    }
}
