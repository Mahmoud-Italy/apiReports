<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingUpdateRequest;
use App\Http\Requests\SettingStoreRequest;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:view_settings' ['only' => ['index', 'show', 'export']]);
        // $this->middleware('permission:add_settings',  ['only' => ['store']]);
        // $this->middleware('permission:edit_settings', 
        //                         ['only' => ['update', 'active', 'inactive', 'trash', 'restore']]);
        // $this->middleware('permission:delete_settings', ['only' => ['destroy']]);
    }

    public function index()
    {
        $rows = SettingResource::collection(Setting::fetchData(request()->all()));
        return response()->json(['data' => $rows], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SettingStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingStoreRequest $request)
    {
        try {
            Setting::create($request->all());
            return response()->json(['message' => ''], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to create entry, '. $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        $row = new SettingResource(Setting::find($setting));
        return response()->json(['row' => $row], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SettingUpdateRequest  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        try {
            $setting->update($request->all());
            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to update entry, '. $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        try {
            $setting->delete();
            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete entry, '. $e->getMessage()], 500);
        }
    }
}
