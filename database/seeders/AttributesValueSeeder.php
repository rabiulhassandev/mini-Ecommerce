<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\AttributesSet;
use App\Models\Admin\AttributesValue;

class AttributesValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // attributes
        $data = [
            [
                'title' => 'Text Size',
                'values' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
            ],
            [
                'title' => 'Numeric Size',
                'values' => ['28', '30', '32', '34', '36', '38', '40', '42', '44', '46', '48', '50', '52', '54', '56', '58', '60'],
            ],
        ];

        DB::transaction(function () use ($data) {
            collect($data)->each(function ($item) {
                $attribute = AttributesSet::create([
                    'title' => $item['title'],
                    'status' => 1,
                ]);

                $values = collect($item['values'])->map(function ($value) use ($attribute) {
                    return [
                        'value' => $value,
                        'attribute_id' => $attribute->id,
                        'status' => 1,
                    ];
                })->toArray();

                AttributesValue::insert($values);
            });
        });
    }
}
