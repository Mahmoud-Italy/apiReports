<?php

namespace App\Http\Controllers\Backend;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Resources\Backend\PermissionResource;

class PermissionController extends Controller
{
    function __construct()
    {
        //
    }

    public function index()
    {
        $rows = Permission::fetchPermissionGroups();
        return response()->json([
            'rows'   => $rows,
        ], 200);
    }

    public function store(PermissionStoreRequest $request)
    {
        $row = Permission::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }

    public function show($id)
    {
        $row = new PermissionResource(Permission::findOrFail(decrypt($id)));
        return response()->json(['row' => $row], 200);
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        $row = Permission::createOrUpdate(decrypt($id), $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $row = Permission::query();

            if(strpos($id, ',') !== false) {
                foreach(explode(',',$id) as $sid) {
                    $ids[] = $sid;
                }
                $row->whereIN('id', $ids);
            } else {
                $row->where('id', $id);
            }   
            $row->delete();

            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete entry, '. $e->getMessage()], 500);
        }
    }

}
