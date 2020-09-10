<?php

namespace App\Http\Controllers\Backend;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailTemplateResource;

class EmailTemplateController extends Controller
{
    function __construct()
    {
        //
    }


    public function show($id)
    {
        $row = new EmailTemplateResource(EmailTemplate::findOrFail($id));
        return response()->json(['row' => $row], 200);
    }

    public function update(Request $request, $id)
    {
        $row = EmailTemplate::createOrUpdate($id, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }

}
