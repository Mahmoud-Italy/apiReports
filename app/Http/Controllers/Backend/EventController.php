<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resources\Backend\EventResource;
use App\Http\Controllers\Controller;


class EventController extends Controller
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
        $row = new EventResource(Event::findOrFail($id));
        if($id == 1) {
            $active = Setting::select('status')->findOrFail(20);
        } else {
            $active = false;
        }
        return response()->json([
            'row'     => $row, 
            'active'  => $active,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $row = Event::createOrUpdate($id, $request->all());
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
