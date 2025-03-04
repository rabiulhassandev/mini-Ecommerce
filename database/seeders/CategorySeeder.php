<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'name' => 'Electronic',
                'slug' => 'electronic',
                'parent_id' => null,
            ],
            [
                'name' => 'Camara',
                'slug' => 'camara',
                'parent_id' => 1,
            ],
            [
                'name' => 'Toys',
                'slug' => 'toys',
                'parent_id' => null,
            ],
            [
                'name' => 'Mouse',
                'slug' => 'mouse',
                'parent_id' => 1,
            ],
            [
                'name' => 'Grocery',
                'slug' => 'grocery',
                'parent_id' => null,
            ],
            [
                'name' => 'Keyboard',
                'slug' => 'keyboard',
                'parent_id' => 1,
            ],
            [
                'name' => 'Fresh Fruits',
                'slug' => 'fresh-fruits',
                'parent_id' => 5,
            ],
            [
                'name' => 'Juice',
                'slug' => 'juice',
                'parent_id' => 5,
            ]
        ];

        foreach ($data as  $item) {
            Category::create([
                'name' => $item['name'],
                'slug' => $item['slug'],
                'parent_id' => $item['parent_id'],
            ]);
        }
    }
}
