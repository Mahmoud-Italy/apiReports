<?php

namespace App\Http\Controllers\Backend;

use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberUpdateRequest;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Resources\ExperienceResource;

class ExperienceController extends Controller
{
    function __construct()
    {
        //
    }

    public function index()
    {
        $data = Experience::get();
        $rows = ExperienceResource::collection(Experience::fetchData(request()->all()));
        return response()->json([
            'statusBar'   => $this->statusBar($data),
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }

    public function store(MemberStoreRequest $request)
    {
        $row = Experience::createOrUpdate(NULL, $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry, ' . $row], 500);
        }
    }

    public function show($id)
    {
        $row = new ExperienceResource(Experience::findOrFail(decrypt($id)));
        return response()->json(['row' => $row], 200);
    }

    public function update(MemberUpdateRequest $request, $id)
    {
        $row = Experience::createOrUpdate(decrypt($id), $request->all());
        if($row === true) {
            return response()->json(['message' => ''], 200);
        } else {
            return response()->json(['message' => 'Unable to update entry, ' . $row], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $row = Experience::query();

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
            $row = Experience::query();

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
            $row = Experience::query();

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
            $row = Experience::query();

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
            $row = Experience::query();

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
        $data = Experience::where(['status' => true, 'trash' => false]);

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
        return response()->json(['rows' => ExperienceResource::collection($data)], 200);
    }
}