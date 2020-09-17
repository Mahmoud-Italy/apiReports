<?php

namespace App\Http\Controllers\Backend;

use App\Models\Training;
use App\Models\Member;
use App\Models\Instructor;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\TrianingResource;
use App\Http\Resources\Backend\MemberResource;
use App\Http\Resources\Backend\InstructorResource;
use App\Http\Resources\Backend\ExperienceResource;

class ApplicationController extends Controller
{
    function __construct()
    {
        //
    }

    public function index($type)
    {
        if($type == 'memberships-applications') {
            $data = Member::get();
            $rows = MemberResource::collection(Member::fetchData(request()->all()));
        } else if ($type == 'instructor-applications') {
            $data = Instructor::get();
            $rows = InstructorResource::collection(Instructor::fetchData(request()->all()));
        } else if ($type == 'experience-applications') {
            $data = Experience::get();
            $rows = ExperienceResource::collection(Experience::fetchData(request()->all()));
        } else {
            $data = Training::get();
            $rows = TrainingResource::collection(Training::fetchData(request()->all()));
        }
        $statusBar = [
            'app1' => Training::get(),
            'app2' => Member::get(),
            'app3' => Instructor::get(),
            'app4' => Experience::get()
        ];
        return response()->json([
            'statusBar'   => $statusBar,
            'rows'        => $rows,
            'paginate'    => $this->paginate($rows)
        ], 200);
    }


    public function show($type, $id)
    {
        if($type == 'memberships-applications') {
            $row = Member::findOrFail(decrypt($id))
        } else if ($type == 'instructor-applications') {
            $row = Instructor::findOrFail(decrypt($id))
        } else if ($type == 'experience-applications') {
            $row = Experience::findOrFail(decrypt($id))
        } else {
            $row = Training::findOrFail(decrypt($id))
        }
        $row = new ExperienceResource($row);
        return response()->json(['row' => $row], 200);
    }


    public function export($type)
    {
        if($type == 'memberships-applications') {
            $data = Member::query();
            $rows = MemberResource::collection($data);
        } else if ($type == 'instructor-applications') {
            $data = Instructor::query();
            $rows = InstructorResource::collection($data);
        } else if ($type == 'experience-applications') {
            $data = Experience::query();
            $rows = ExperienceResource::collection($data);
        } else {
            $data = Training::query();
            $rows = TrainingResource::collection($data);
        }

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
        if($type == 'memberships-applications') {
            $rows = MemberResource::collection($data);
        } else if ($type == 'instructor-applications') {
            $rows = InstructorResource::collection($data);
        } else if ($type == 'experience-applications') {
            $rows = ExperienceResource::collection($data);
        } else {
            $rows = TrainingResource::collection($data);
        }
        return response()->json(['rows' => $rows], 200);
    }
    
}
