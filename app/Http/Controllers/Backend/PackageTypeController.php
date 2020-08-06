<?php

namespace App\Http\Controllers\Backend;

use App\Models\PackageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PackageTypeUpdateRequest;
use App\Http\Requests\PackageTypeStoreRequest;
use App\Http\Resources\PackageTypeResource;

class PackageTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_packages', ['only' => ['index', 'show', 'export']]);
        $this->middleware('permission:add_packages',  ['only' => ['store']]);
        $this->middleware('permission:edit_packages', 
                                ['only' => ['update', 'active', 'inactive', 'trash', 'restore']]);
        $this->middleware('permission:delete_packages', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = PackageType::has('tenant')->get();
        $rows = PackageTypeResource::collection(PackageType::fetchData(request()->all()));
        return response()->json([
            'all'       => count($data),
            'active'    => count($data->where('status', true)->where('trash', false)),
            'inactive'  => count($data->where('status', false)->where('trash', false)), 
            'trash'     => count($data->where('trash', true)),

            'rows'      => $rows,
            'paginate'  => $this->paginate($rows)
        ], 200);
    }

    public function store(PackageTypeStoreRequest $request)
    {
        $row = PackageType::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }

    public function show($id)
    {
        $row = new PackageTypeResource(PackageType::has('tenant')->findOrFail($id));
        return response()->json(['row' => $row], 200);
    }

    public function update(PackageTypeUpdateRequest $request, $id)
    {
        $row = PackageType::createOrUpdate($id, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $row = PackageType::has('tenant');

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

    public function active($id)
    {
        try {
            $row = PackageType::has('tenant');

            if(strpos($id, ',') !== false) {
                foreach(explode(',',$id) as $sid) {
                    $ids[] = $sid;
                }
                $row->whereIN('id', $ids);
            } else {
                $row->where('id', $id);
            }   
            $row->update(['status' => true, 'trash' => false]);

            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function inactive($id)
    {
        try {
            $row = PackageType::has('tenant');

            if(strpos($id, ',') !== false) {
                foreach(explode(',',$id) as $sid) {
                    $ids[] = $sid;
                }
                $row->whereIN('id', $ids);
            } else {
                $row->where('id', $id);
            }   
            $row->update(['status' => false, 'trash' => false]);

            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function trash($id)
    {
        try {
            $row = PackageType::has('tenant');

            if(strpos($id, ',') !== false) {
                foreach(explode(',',$id) as $sid) {
                    $ids[] = $sid;
                }
                $row->whereIN('id', $ids);
            } else {
                $row->where('id', $id);
            }   
            $row->update(['trash' => true]);

            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            $row = PackageType::has('tenant');

            if(strpos($id, ',') !== false) {
                foreach(explode(',',$id) as $sid) { 
                    $ids[] = $sid; 
                }
                $row->whereIN('id', $ids);
            } else {
                $row->where('id', $id);
            }   
            $row->update(['trash' => false]);

            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function export()
    {
        $data = PackageType::has('tenant')->where(['status' => true, 'trash' => false]);

        if(request('id')) {
            $id = request('id');
            if(strpos($id, ',') !== false) {
                foreach(explode(',',$id) as $sid) {
                    $ids[] = $sid;
                }
                $data->whereIN('id', $ids);
            } else {
                $data->where('id', $id);
            }
        }

        $data = $data->orderBy('id','DESC')->get();
        return response()->json(['rows' => PackageTypeResource::collection($data)], 200);
    }
}
