<?php

namespace GlebStarSimpleCms\Controllers;

use Illuminate\Routing\Controller as BaseController;
use GlebStarSimpleCms\Models\Cms;

class CmsController extends BaseController
{
    public function index($path)
    {
        $page = Cms::where('path', $path)->first();
        if(!$page) {
            abort(404);
        }

        return view('simplecms::cms.index', ['page' => $page]);
    }
}
