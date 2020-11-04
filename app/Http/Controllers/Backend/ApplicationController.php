<?php

namespace App\Http\Controllers\Backend;

use App\Models\NewApp;
use App\Models\Training;
use App\Models\Member;
use App\Models\Instructor;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\TrainingResource;
use App\Http\Resources\Backend\MemberResource;
use App\Http\Resources\Backend\InstructorResource;
use App\Http\Resources\Backend\ExperienceResource;
use App\Http\Resources\Backend\NewAppResource;

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
        } else if ($type == 'trainings-applications') {
            $data = Training::get();
            $rows = TrainingResource::collection(Training::fetchData(request()->all()));
        }

        else if ($type == 'accreditation-applications') {
            $data = NewApp::where('is_accreditation', 1)->get();
            $rows = NewAppResource::collection(NewApp::fetchData(request()->all(), 1));
        }
        else if ($type == 'certificate-applications') {
            $data = NewApp::where('is_accreditation', 0)->get();
            $rows = NewAppResource::collection(NewApp::fetchData(request()->all(), 0));
        }
        $statusBar = [
            'app1' => Training::count(),
            'app2' => Member::count(),
            'app3' => Instructor::count(),
            'app4' => Experience::count(),
            'app5' => NewApp::where('is_accreditation', 1)->count(),
            'app6' => NewApp::where('is_accreditation', 0)->count()
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
            $row = Member::findOrFail(decrypt($id));
        } else if ($type == 'instructor-applications') {
            $row = Instructor::findOrFail(decrypt($id));
        } else if ($type == 'experience-applications') {
            $row = Experience::findOrFail(decrypt($id));
        } else {
            $row = Training::findOrFail(decrypt($id));
        }
        $row = new ExperienceResource($row);
        return response()->json(['row' => $row], 200);
    }


    public function export($type)
    {
        if($type == 'memberships-applications') {
            $data = Member::query();
        } else if ($type == 'instructor-applications') {
            $data = Instructor::query();
        } else if ($type == 'experience-applications') {
            $data = Experience::query();
        } else if ($type == 'trainings-applications') {
            $data = Training::query();
        } else if ($type == 'certificate-applications') {
            $data = NewApp::where('is_accreditation', false);
        } else if ($type == 'accreditation-applications') {
            $data = NewApp::where('is_accreditation', true);
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
        } else if ($type == 'trainings-applications') {
            $rows = TrainingResource::collection($data);
        } else if ($type == 'certificate-applications') {
            $data = NewAppResource::collection($data);
        } else if ($type == 'accreditation-applications') {
            $data = NewAppResource::collection($data);
        }
        return response()->json(['rows' => $rows], 200);
    }

    public function destroy($type, $id)
    {
        try {
            if($type == 'memberships-applications') {
                $data = Member::where('id', $id)->delete();
            } else if ($type == 'instructor-applications') {
                $data = Instructor::where('id', $id)->delete();
            } else if ($type == 'experience-applications') {
                $data = Experience::where('id', $id)->delete();
            } else if ($type == 'trainings-applications') {
                $data = Training::where('id', $id)->delete();
            } else if ($type == 'certificate-applications') {
                $data = NewApp::where('is_accreditation', false)->where('id', $id)->delete();
            } else if ($type == 'accreditation-applications') {
                $data = NewApp::where('is_accreditation', true)->where('id', $id)->delete();
            }
            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete entry, '. $e->getMessage()], 500);
        }
    }
    
}
