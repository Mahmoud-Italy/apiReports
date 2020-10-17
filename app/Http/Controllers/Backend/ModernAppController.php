<?php

namespace App\Http\Controllers\Backend;

use App\Models\NewAppLayout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\NewAppLayoutResource;

class AboutController extends Controller
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
        $row = new NewAppLayoutResource(NewAppLayout::findOrFail($id));
        return response()->json(['row' => $row], 200);
    }

    public function update($id)
    {
        $row = NewAppLayout::createOrUpdate($id, $request->all());
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

    public function active($id)
    {
        //
    }

    public function inactive($id)
    {
        //
    }

    public function trash($id)
    {   
        //
    }

    public function restore($id)
    {   
        //
    }

    public function export()
    {   
        //
    }
    
}
