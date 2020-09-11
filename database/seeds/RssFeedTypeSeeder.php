<?php

use App\Models\RssFeedType;
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

        RssFeedType::insert($data);
    }
}
