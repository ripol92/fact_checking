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
        $data = [['name' => 'feeds.feedburner.com'], ['name' => 'simple_rss']];

        \App\Models\RssFeedType::insert($data);
    }
}
