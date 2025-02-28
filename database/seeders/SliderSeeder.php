<?php

namespace Database\Seeders;

use App\Models\Admin\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'tile' => 'Slider Title',
            'order' => 1,
            'image' => null,
        ];

        try {
            Slider::create($data);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
