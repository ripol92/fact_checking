<?php

namespace App\Nova\Actions;

use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;

class AnalyzeImage extends DetachedAction
{
    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Exception
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        /***
         * @var UploadedFile $file
         */
        $file = $fields->get("input_img");
        Storage::disk("public")->put("", $file);

        $imagePath = storage_path("app" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $file->hashName());

        Artisan::call("tools:analyze-image", [
            "image_path" => $imagePath,
            "--no_crop" => !$fields->get("crop_face"),
        ]);
    }

    public function fields()
    {
        return [
            Image::make("Input Image", "input_img")
                ->rules(["required", "mimes:jpg,jpeg,png"]),

            Boolean::make("Crop Face", "crop_face")
                ->rules(["required"])
        ];
    }
}
