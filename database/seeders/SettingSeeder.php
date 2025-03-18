<?php

namespace Database\Seeders;



use App\Models\Admin\Setting\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            /**
             *
             * Site
             *
             */
            [
                'display_name' => 'Title',
                'key'        => 'site.title',
                'value'        => 'Mini Bazar',
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text',
                'order'        => 7,
                'group'        => 'Site',
            ],
            [
                'display_name' => 'Description',
                'key'        => 'site.description',
                'value'        => "\"Discover a unique marketplace where seamless transactions meet curated variety, offering you exclusive products at your fingertips.\"",
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text_area',
                'order'        => 6,
                'group'        => 'Site',
            ],
            [
                'display_name' => 'Keywords',
                'key'        => 'site.keywords',
                'value'        => "laravel, rabiulhassandev, e-commerce",
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text_area',
                'order'        => 5,
                'group'        => 'Site',
            ],
            [
                'display_name' => 'Logo',
                'key'        => 'site.logo',
                'value'        => \null,
                'details'      => '[]',
                'note'      => "",
                'type'         => 'image',
                'order'        => 4,
                'group'        => 'Site',
            ],
            [
                'display_name' => 'Favicon',
                'key'        => 'site.favicon',
                'value'        => \null,
                'details'      => '[]',
                'note'      => "",
                'type'         => 'image',
                'order'        => 2,
                'group'        => 'Site',
            ],
            [
                'display_name' => 'Currency',
                'key'        => 'site.currency',
                'value'        => "﷼",
                'details'      => '[]',
                'note'      => "",
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Site',
            ],
            [
                'display_name' => 'Inside Jeddha',
                'key'        => 'site.inside_area',
                'value'        => '80',
                'details'      => '[]',
                'note'      => "",
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Site',
            ],
            [
                'display_name' => 'Outside Jeddha',
                'key'        => 'site.outside_area',
                'value'        => '100',
                'details'      => '[]',
                'note'      => "",
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Site',
            ]



            /**
             *
             * Contact
             *
             */



            [
                'display_name' => 'Phone',
                'key'        => 'contact.phone',
                'value'        => "(+123) 456 789",
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text',
                'order'        => 6,
                'group'        => 'Contact',
            ],
            [
                'display_name' => 'WhatsApp Number',
                'key'        => 'contact.whatsapp',
                'value'        => "01601308010",
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text',
                'order'        => 4,
                'group'        => 'Contact',
            ],
            [
                'display_name' => 'Email',
                'key'        => 'contact.email',
                'value'        => "support@domain.com",
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text',
                'order'        => 3,
                'group'        => 'Contact',
            ],
            [
                'display_name' => 'Address',
                'key'        => 'contact.address',
                'value'        => "New York, US",
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text',
                'order'        => 2,
                'group'        => 'Contact',
            ],
            [
                'display_name' => 'Google Map',
                'key'        => 'contact.map',
                'value'        => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2799160894!2d-74.25987584510598!3d40.6976700633816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY!5e0!3m2!1sen!2sus!4v1678209692982!5m2!1sen!2sus",
                'details'      => '[]',
                'note'      => \null,
                'type'         => 'text',
                'order'        => 1,
                'group'        => 'Contact',
            ],

            /**
             *
             * Social
             *
             */

            [
                'group' => 'Social',
                'key' => 'social.facebook',
                'display_name' => 'Facebook',
                'value' => 'https://www.facebook.com/rabiulhassan.dev',
                'type' => 'text',
                'details' => '{}',
                'note' => '[]',
                'order' => 1,
            ],
            [
                'group' => 'Social',
                'key' => 'social.twitter',
                'display_name' => 'Twitter',
                'value' => 'https://twitter.com/rabiulhassandev',
                'type' => 'text',
                'details' => '{}',
                'note' => '[]',
                'order' => 2,
            ],
            [
                'group' => 'Social',
                'key' => 'social.instagram',
                'display_name' => 'Instagram',
                'value' => 'https://www.instagram.com/rabiulhassan.dev',
                'type' => 'text',
                'details' => '{}',
                'note' => '[]',
                'order' => 3,
            ],
            [
                'group' => 'Social',
                'key' => 'social.youtube',
                'display_name' => 'YouTube',
                'value' => 'https://www.youtube.com/channel/UC_cRoDLSVHe2nvJb6pjyF6A',
                'type' => 'text',
                'details' => '{}',
                'note' => '[]',
                'order' => 4,
            ],
            [
                'group' => 'Social',
                'key' => 'social.skype',
                'display_name' => 'Skype',
                'value' => 'live:rabiulhassan.dev',
                'type' => 'text',
                'details' => '{}',
                'note' => '[]',
                'order' => 5,
            ],



        ];
        foreach ($data as  $item) {
            $setting = $this->findSetting($item['key']);
            if (!$setting->exists) {
                $setting->fill([
                    'display_name' => $item['display_name'],
                    'value'        => $item['value'],
                    'details'      => $item['details'],
                    'note'      => $item['note'],
                    'type'         => $item['type'],
                    'order'        => $item['order'],
                    'group'        => $item['group'],
                ])->save();
            }
        }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
