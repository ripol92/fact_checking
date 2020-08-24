<?php

namespace App\Listeners;

use App\Models\AnalysedUrl;
use App\Events\ArticleParsed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class ArticleParsedFalDetectorListener implements ShouldQueue
{
    use Queueable;

    public function handle(ArticleParsed $event)
    {
        /**
         * @var AnalysedUrl $analyzedUrl
         */
        $analyzedUrl = AnalysedUrl::find($event->getAnalysedUrlId());
        $imgInStorage = last($analyzedUrl->image_links);
        if (!$imgInStorage) {
            return;
        }

        foreach ($analyzedUrl->image_links as $imageLink) {
            $imgPath = storage_path("app" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $imageLink);
            Artisan::call("tools:analyze-image", [
                "image_path" => $imgPath,
                "--identifier" => $event->getAnalysedUrlId(),
            ]);
        }
    }
}
