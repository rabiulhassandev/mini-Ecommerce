<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Admin\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
                'name'               => 'Apple Watch Series 4 (GPS + Cellular, 44mm)',
                'slug'               => 'apple-watch-series-4-gps--cellular-44mm',
                'category_id'        => 1,
                'unit'               => 'Pcs',
                'min_order_qty'      => '1',
                'price'         => '560',
                'sku'                => 'skladu0r92u293j',
                'shipping_days'      => 7,
                'short_desc'         => 'Apple Watch Series 4 (GPS + Cellular, 44mm) - Gold Stainless Steel Case with Stone Sport Band',
                'long_desc'          => 'GLONASS, Galileo, and QZSS, Barometric altimeter, Optical heart sensor, Electrical heart sensor, Improved accelerometer up to 32 g‑forces, Improved gyroscope, Ambient light sensor, LTPO OLED Retina display with Force Touch (1000 nits), Digital Crown with haptic feedback, Louder speaker, Ion-X strengthened glass, Sapphire crystal and ceramic back',
                'additional_info'    => 'Additional Info',
                'meta_title'         => 'Apple Watch Series 4 (GPS + Cellular, 44mm) - Gold Stainless Steel Case with Stone Sport Band',
                'meta_desc'          => 'Over 30% larger displayElectrical and optical heart sensorsECG appDigital Crown with haptic feedback50% louder speakerS4 SiP with faster 64-bit dual-core processorImproved accelerometer and gyroscope for fall detectionSwim proofwatchOS 5',
                'meta_keywords'      => 'a4tech, tech, new',
                'stock_status'       => true,
                'status'             => true,
            ],
            [
                'name'               => '2021 Apple TV HD (32GB, 5th Generation)',
                'slug'               => '2021-apple-tv-hd-32gb-5th-generation-7sp1v',
                'category_id'        => 2,
                'unit'               => 'Pcs',
                'min_order_qty'      => '1',
                'price'         => '1020',
                'sku'                => 'skladu0r92sf293j',
                'shipping_days'      => 3,
                'short_desc'         => 'AUse AirPlay to share photos, videos, and more from your iPhone, iPad, and Mac on your TV',
                'long_desc'          => 'HomeKit-enabled cameras and control your smart home accessories and your TV with Apple Arcade, Apple Fitness+, and Apple Music',
                'additional_info'    => 'Additional Info',
                'meta_title'         => 'Get a live view of your HomeKit-enabled cameras and control your smart home accessories',
                'meta_desc'          => 'More ways to enjoy your TV with Apple Arcade, Apple Fitness+, and Apple Music ',
                'meta_keywords'      => 'Amazon Prime Video, HBO Max',
                'stock_status'       => true,
                'status'             => true,
            ],
            [
                'name'               => '2021 Apple 11-inch iPad Pro (Wi‑Fi, 128GB) - Silver',
                'slug'               => '2021-apple-11-inch-ipad-pro-wifi-128gb---silver-2bllf',
                'category_id'        => null,
                'unit'               => 'Pcs',
                'min_order_qty'      => '1',
                'price'         => '210',
                'sku'                => null,
                'shipping_days'      => 5,
                'short_desc'         => '11-inch Liquid Retina display with True Tone, P3 wide color, and an antireflective coating ',
                'long_desc'          => ' Available in blue, purple, pink, starlight, and space gray Stereo landscape speakers ',
                'additional_info'    => 'Additional Info',
                'meta_title'         => 'Touch ID for secure authentication and Apple Pay',
                'meta_desc'          => '11-inch Liquid Retina display with True Tone, P3 wide color, and an antireflective coating  ',
                'meta_keywords'      => 'Tone, P3 wide color',
                'stock_status'       => false,
                'status'             => true,
            ],
            [
                'name'               => '2021 Apple iMac (24-inch, Apple M1 chip with 8‑core CPU and 7‑core GPU, 8GB RAM, 256GB) - Silver',
                'slug'               => '2021-apple-imac-24-inch-apple-m1-chip-with-8core-cpu',
                'category_id'        => 3,
                'unit'               => 'Pcs',
                'min_order_qty'      => '1',
                'price'         => '940',
                'sku'                => 's35t6r09239ruji',
                'shipping_days'      => 7,
                'short_desc'         => 'Immersive 24-inch 4.5K Retina display with P3 wide color gamut and 500 nits of brightness ',
                'long_desc'          => 'Apple M1 chip delivers powerful performance with 8-core CPU and 7-core GPU ',
                'additional_info'    => 'Additional Info',
                'meta_title'         => 'Strikingly thin 11.5 mm design in vibrant colors ',
                'meta_desc'          => '1080p FaceTime HD camera with M1 ISP for amazing video quality ',
                'meta_keywords'      => 'computer, tech, color, smoth',
                'stock_status'       => true,
                'status'             => false,
            ],
            [
                'name'               => '2022 Apple iPad Air (10.9-inch, Wi-Fi, 64GB) - Blue (5th Generation)',
                'slug'               => '2022-apple-ipad-air-109-inch-wi-fi-64gb---blue-5th-generation-ujgtj',
                'category_id'        => 1,
                'unit'               => 'Pcs',
                'min_order_qty'      => '1',
                'price'         => '2000',
                'sku'                => 'sk533du0r92u293j',
                'shipping_days'      => 7,
                'short_desc'         => '10.9-inch Liquid Retina display with True Tone, P3 wide color, and an antireflective coating ',
                'long_desc'          => ' Available in blue, purple, pink, starlight, and space gray ',
                'additional_info'    => 'Additional Info',
                'meta_title'         => 'Stereo landscape speakers ',
                'meta_desc'          => 'Touch ID for secure authentication and Apple Pay',
                'meta_keywords'      => 'Tone, P3 wide color',
                'stock_status'       => true,
                'status'             => true,
            ],
        ];

        foreach ($data as $item) {
            Product::create([
                'name'               => $item['name'],
                'slug'               => $item['slug'],
                'category_id'        => $item['category_id'],
                // 'sku'                => Str::random(15),
                'price'              => $item['price'],
                'stock_status'       => $item['stock_status'],
                'status'             => $item['status'],
                'color_id'           => json_encode([2, 4]),
                'attr_value_id'      => json_encode([1, 2, 3])
            ]);
        }
    }
}
