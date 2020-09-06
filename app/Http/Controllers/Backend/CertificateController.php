<?php

namespace App\Http\Controllers\Backend;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;

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
        $row = new CertificateResource(Certificate::findOrFail(1));
        return response()->json(['row' => $row], 200);
    }

    public function update(Request $request, $id)
    {
        $row = Certificate::createOrUpdate(decrypt($id), $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }
}
