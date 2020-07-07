<?php

namespace App\Console\Commands;

use App\Models\ImageCheck;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;

class SendImageToAnalyze extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools:analyze-image {image_path} {--identifier=} {--no_crop=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends arguments to FALdetector to perform image analyses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        // get path to image and cropping face option
        $inputPath = (string)$this->argument("image_path");
        if (!file_exists($inputPath)) {
            throw new \Exception("no such file or directory $inputPath");
        }

        // determine if image needs to be cropped
        $noCrop = (bool)$this->option("no_crop");

        // get channel name to publish arguments for python lib
        $chan = config("services.fake_img_detector.publish_chan");

        // make destination folder name
        $destinationFolder = storage_path("app" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . uniqid());

        // make identifier
        $identifier = (string)$this->option("identifier");
        if (!Uuid::isValid($identifier)) {
            $identifier = Uuid::uuid4()->toString();
        }

        // encode to json-string payload
        $message = json_encode([
            "input_path" => $inputPath,
            "no_crop" => $noCrop,
            "dest_folder" => $destinationFolder,
            "identifier" => $identifier,
        ]);

        Redis::publish($chan, $message);

        $this->registerImageCheck($inputPath, $identifier, $destinationFolder);
    }

    protected function registerImageCheck($inputPath, $identifier, $destinationFolder)
    {
        $imgCheck = new ImageCheck();
        $imgCheck->image_path = $inputPath;
        $imgCheck->identifier = $identifier;
        $imgCheck->results_path = $destinationFolder;
        $imgCheck->save();
    }
}
