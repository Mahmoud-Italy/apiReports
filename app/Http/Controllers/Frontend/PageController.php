<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Page;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\PageResource;

class PageController extends Controller
{
    public function index()
    {
        # code...
    }

    public function store()
    {
        # code...
    }

    public function show($slug)
    {
        Visitor::saveAsVisitor();
        $id   = Page::getRow($slug)->id;
        $row  = new PageResource(Page::findOrFail($id));
        return response()->json(['row' => $row], 200);
    }
}

