<?php

namespace App\Http\Controllers;

use App\Events\ArticleParsed;
use Illuminate\Http\Request;

class TextRuController extends Controller
{
    /**
     * @param Request $request
     * @param $uuid
     */
    public function runJobs(Request $request, $uuid) {
        event(new ArticleParsed($uuid));
    }
}
