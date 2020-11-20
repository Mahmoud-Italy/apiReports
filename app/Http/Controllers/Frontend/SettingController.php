<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\SettingResource;

class SettingController extends Controller
{
    public function index()
    {
        //
    }

    public function store()
    {
        # code...
    }

    public function show($slug)
    {
        $id   = Setting::getRow($slug)->id;
        $row  = new SettingResource(Setting::findOrFail($id));
        return response()->json(['row' => $row], 200);
    }
}

