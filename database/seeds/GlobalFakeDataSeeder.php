<?php

use App\Models\AnalysedUrl;
use App\Models\ImageCheck;
use App\Models\MarkedItem;
use App\User;
use Illuminate\Database\Seeder;

class GlobalFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amountOfUsers = 10;
        factory(User::class, $amountOfUsers)->create()->each(function (User $user) {

            factory(MarkedItem::class, 3)->create()->each(function (MarkedItem $markedItem) use ($user) {
                $markedItem->users()->attach($user);
                $markedItem->analyzedUsers()->attach($user);

                factory(AnalysedUrl::class, 1)->create(["url" => $markedItem->link])->each(function (AnalysedUrl $analysedUrl) {
                    factory(ImageCheck::class, 1)->create(["identifier" => $analysedUrl->id]);
                });
            });
        });
    }
}
