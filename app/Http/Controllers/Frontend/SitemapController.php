<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        $rows = Page::where(['status' => true, 'trash' => false, 'index' => true])->get();
        $rows = $this->toCollection(PageResource::collection($data);

        return response()->view('sitemap.index', [
                'rows' => $rows,
            ])->header('Content-Type', 'text/xml');
    }

}

