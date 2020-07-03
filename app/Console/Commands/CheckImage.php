<?php

namespace App\Console\Commands;

use App\Models\ImageCheck;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class CheckImage extends Command
{
    const ERR_ON_IMAGE = [
        "no face detected by dlib, exiting",
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools:check-image {image_path} {--uuid=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks given image and tells if it was modified, this tool works only with faces';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get path to image
        $imgPath = $this->argument("image_path");
        $uuid = $this->option("uuid");
        if ($uuid == "") {
            $uuid = Uuid::uuid1()->toString();
        }

        // change directory to project to avoid `path` misconfigurations and lookups
        chdir(config("services.fake_img_detector.project_path"));

        // generate command with input as given file and tmp-output
        $globalClassifierCommand = "python global_classifier.py --input_path $imgPath --model_path weights/global.pth";

        // run command and handle results
        $glClassOutput = [];
        $glClassCode = -1;
        exec($globalClassifierCommand, $glClassOutput, $glClassCode);
        $glClassMessage = implode("====>", $glClassOutput);

        // in case classifier fails log result and stop command
        if ($glClassCode != 0) {
            $this->logGlobalClassifierError($uuid, $imgPath, $glClassMessage);
            return;
        }
        // in case ok run but image corruption or etc...
        if (in_array($glClassMessage, static::ERR_ON_IMAGE)) {
            $this->logGlobalClassifierError($uuid, $imgPath, $glClassMessage);
            return;
        }

        // when global classifier tells us about percentage and probability of being modified
        // only then run local detector
        $outPath = $this->generateOutputPath();
        $localDetectorCommand = "python local_detector.py --input_path $imgPath --model_path weights/local.pth --dest_folder $outPath";

        $lcDetOutput = [];
        $lcDetCode = -1;
        exec($localDetectorCommand, $lcDetOutput, $lcDetCode);
        $lcDetMessage = implode("====>", $lcDetOutput);

        // in case classifier fails log result and stop command
        if ($lcDetCode != 0) {
            $this->logLocalDetectorError($uuid, $imgPath, $lcDetMessage);
            return;
        }
        // in case ok run but image corruption or etc...
        if (in_array($lcDetMessage, static::ERR_ON_IMAGE)) {
            $this->logLocalDetectorError($uuid, $imgPath, $lcDetMessage);
            return;
        }

        $this->storeAnalyzeResults($uuid, $imgPath, $glClassMessage, $outPath);
    }

    protected function logGlobalClassifierError($id, $imgPath, $error)
    {
        $imgCheck = new ImageCheck();
        $imgCheck->identifier = $id;
        $imgCheck->image_path = $imgPath;
        $imgCheck->local_detector_error = $error;
        $imgCheck->save();
    }

    protected function logLocalDetectorError($id, $imgPath, $error)
    {
        $imgCheck = new ImageCheck();
        $imgCheck->identifier = $id;
        $imgCheck->image_path = $imgPath;
        $imgCheck->global_detector_error = $error;
        $imgCheck->save();
    }

    protected function storeAnalyzeResults($id, $imgPath, $analyzeMessage, $resultsPath)
    {
        $imgCheck = new ImageCheck();
        $imgCheck->identifier = $id;
        $imgCheck->image_path = $imgPath;
        $imgCheck->analyze_msg = $analyzeMessage;
        $imgCheck->results_path = $resultsPath;
        $imgCheck->save();
    }

    protected function generateOutputPath()
    {
        $storage = storage_path("app" . DIRECTORY_SEPARATOR . "public");
        $uniquePath = uniqid();
        mkdir($storage . DIRECTORY_SEPARATOR . $uniquePath);
        return storage_path("app" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $uniquePath);
    }
}
