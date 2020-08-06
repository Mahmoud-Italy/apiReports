<?php

namespace App\Http\Controllers\Backend;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccommodationUpdateRequest;
use App\Http\Requests\AccommodationStoreRequest;
use App\Http\Resources\AccommodationResource;

class AccommodationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_accommodations', ['only' => ['index', 'show', 'export']]);
        $this->middleware('permission:add_.$accommodations',  ['only' => ['store']]);
        $this->middleware('permission:edit_.$accommodations', 
                                ['only' => ['update', 'active', 'inactive', 'trash', 'restore']]);
        $this->middleware('permission:delete_.$accommodations', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = Accommodation::has('tenant')->get();
        $rows = AccommodationResource::collection(Accommodation::fetchData(request()->all()));
        return response()->json([
            'all'       => count($data),
            'active'    => count($data->where('status', true)->where('trash', false)),
            'inactive'  => count($data->where('status', false)->where('trash', false)), 
            'trash'     => count($data->where('trash', true)),

            'rows'      => $rows,
            'paginate'  => $this->paginate($rows)
        ], 200);
    }

    public function store(AccommodationStoreRequest $request)
    {
        $row = Accommodation::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }

    public function show($id)
    {
        $row = new AccommodationResource(Accommodation::has('tenant')->findOrFail($id));
        return response()->json(['row' => $row], 200);
    }

    public function update(AccommodationUpdateRequest $request, $id)
    {
        $row = Accommodation::createOrUpdate($id, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $row = Accommodation::has('tenant');

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
            $row = Accommodation::has('tenant');

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
            $row = Accommodation::has('tenant');

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
            $row = Accommodation::has('tenant');

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
            $row = Accommodation::has('tenant');

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
        $data = Accommodation::has('tenant')->where(['status' => true, 'trash' => false]);

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
        return response()->json(['rows' => AccommodationResource::collection($data)], 200);
    }
}
