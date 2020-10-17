<?php

namespace App\Http\Controllers\Backend;

use App\Models\NewApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\NewAppResource;

class ModernAppController extends Controller
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
        $row = new NewAppResource(NewApp::findOrFail(decrypt($id)));
        return response()->json(['row' => $row], 200);
    }

    public function update($id)
    {
        //
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
