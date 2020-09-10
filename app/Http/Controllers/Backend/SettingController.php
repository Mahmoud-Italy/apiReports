<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingUpdateRequest;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    function __construct()
    {
        //
    }

    public function index()
    {
        //
    }

    public function store()
    {
        //
    }

    public function show($id)
    {
        $row = new SettingResource(Setting::findOrFail($id));
        return response()->json(['row' => $row], 200);
    }

    public function update(SettingUpdateRequest $request, $id)
    {
        $row = Setting::createOrUpdate($id, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }

    public function destroy($id)
    {
        //
    }
}
