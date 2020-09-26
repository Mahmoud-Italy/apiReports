<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\CertificateResource;

class CertificateController extends Controller
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
        $row = new CertificateResource(Certificate::findOrFail($id));
        if($id == 1) {
            $active = Setting::select('status')->findOrFail(22);
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
        $row = Certificate::createOrUpdate($id, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }
}
