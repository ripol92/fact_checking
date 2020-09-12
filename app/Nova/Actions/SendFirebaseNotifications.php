<?php

namespace App\Nova\Actions;

use App\Jobs\SendFirebaseNotifications as SendFirebaseNotificationsJob;
use App\Models\FirebaseNotification;
use App\Models\MarkedItem;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Ramsey\Uuid\Uuid;

class SendFirebaseNotifications extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @throws \Exception
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $title = $fields->get("title");
        $text = $fields->get("text");

        /**@var MarkedItem $markedItem */
        foreach ($models as $markedItem) {
            // do not send notifications if news is not analyze
            if (!$markedItem->is_analyzed) {
                throw new \Exception("not analyzed");
            }

            // do not send notifications if no url of fact check provided
            if (empty($markedItem->fact_check_url)) {
                throw new \Exception("fact check url not provided");
            }

            $this->createAndSendNotifications($markedItem, $title, $text);

            $markedItem->notification_send = true;
            $markedItem->save();
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make("Title", "title")
                ->rules(["required", "min:3", "max:64"]),

            Text::make("Text", "text")
                ->rules(["required", "min:3", "max:255"]),
        ];
    }

    /**
     * @param MarkedItem $markedItem
     * @param $title
     * @param $text
     * @throws \Exception
     */
    private function createAndSendNotifications(MarkedItem $markedItem, $title, $text)
    {
        $users = $markedItem->analyzedUsers()->get();
        if (empty($users)) {
            throw new \Exception("marked item has no analyze users");
        }

        $batchId = Uuid::uuid1()->toString();
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = [
                "title" => $title,
                "text" => $text,
                "marked_item_id" => $markedItem->id,
                "user_id" => $user->id,
                "batch_id" => $batchId,
            ];
        }
        FirebaseNotification::insert($notifications);
        SendFirebaseNotificationsJob::dispatch($batchId);
    }
}
