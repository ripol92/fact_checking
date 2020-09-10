<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
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
                'name' => 'en',
                'display_name' => 'English',
                'order' => 1
            ],
            [
                'name' => 'ru',
                'display_name' => 'Russian',
                'order' => 2
            ],
            [
                'name' => 'tg',
                'display_name' => 'Tajik',
                'order' => 3
            ],
            [
                'name' => 'all',
                'display_name' => 'Mixed (En, Ru, Tj)',
                'order' => 4
            ]
        ];

        Language::insert($data);
    }
}
