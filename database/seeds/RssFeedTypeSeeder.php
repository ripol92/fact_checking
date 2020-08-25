<?php

use Illuminate\Database\Seeder;

class RssFeedTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['name' => 'feeds.feedburner.com'];

        \App\Models\RssFeedType::insert($data);
    }
}
