<?php

use App\Models\AnalysedUrl;
use App\Models\FirebaseNotification;
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
        $amountOfUsers = 50;
        factory(User::class, $amountOfUsers)->create()->each(function (User $user) {

            factory(MarkedItem::class, 3)->create()->each(function (MarkedItem $markedItem) use ($user) {
                $markedItem->users()->attach($user);
                $markedItem->analyzedUsers()->attach($user);

                factory(AnalysedUrl::class, 1)->create(["url" => $markedItem->link])->each(function (AnalysedUrl $analysedUrl) {
                    factory(ImageCheck::class, 1)->create(["identifier" => $analysedUrl->id]);
                });

                factory(FirebaseNotification::class, 3)->create(["marked_item_id" => $markedItem->id, "user_id" => $user->id]);
            });
        });
    }
}
