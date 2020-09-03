<?php

namespace App\Http\Controllers\Backend;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resource\EventResource;
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
        return response()->json(['row' => $row], 200);
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
