<?php

namespace App\Http\Controllers\Backend;

use App\Models\Cruise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CruiseUpdateRequest;
use App\Http\Requests\CruiseStoreRequest;
use App\Http\Resources\CruiseResource;

class CruiseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_cruises', ['only' => ['index', 'show', 'export']]);
        $this->middleware('permission:add_cruises',  ['only' => ['store']]);
        $this->middleware('permission:edit_cruises', 
                                ['only' => ['update', 'active', 'inactive', 'trash', 'restore']]);
        $this->middleware('permission:delete_cruises', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = Cruise::has('tenant')->get();
        $rows = CruiseResource::collection(Cruise::fetchData(request()->all()));
        return response()->json([
            'all'       => count($data),
            'active'    => count($data->where('status', true)->where('trash', false)),
            'inactive'  => count($data->where('status', false)->where('trash', false)), 
            'trash'     => count($data->where('trash', true)),

            'rows'      => $rows,
            'paginate'  => $this->paginate($rows)
        ], 200);
    }

    public function store(CruiseStoreRequest $request)
    {
        $row = Cruise::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }

    public function show($id)
    {
        $row = new CruiseResource(Cruise::has('tenant')->findOrFail($id));
        return response()->json(['row' => $row], 200);
    }

    public function update(CruiseUpdateRequest $request, $id)
    {
        $row = Cruise::createOrUpdate($id, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $row = Cruise::has('tenant');

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
            $row = Cruise::has('tenant');

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
            $row = Cruise::has('tenant');

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
            $row = Cruise::has('tenant');

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
            $row = Cruise::has('tenant');

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
        $data = Cruise::has('tenant')->where(['status' => true, 'trash' => false]);

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
        return response()->json(['rows' => CruiseResource::collection($data)], 200);
    }
}
