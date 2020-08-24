<?php

namespace App\Http\Controllers\Backend;

use App\Models\Visitor;
use App\Models\Training;
use App\Models\Member;
use App\Models\User;
use App\Models\Sector;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SectorResource;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    // Total visitors
    public function visitors(Request $request)
    {
      $data = Visitor::fetchPeriod($request->headers->all(), $request->days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow']
        ], 200);
    }

    // Total Trainings
   public function trainings(Request $request)
   {
      $data = Training::fetchPeriod($request->headers->all(), $request->days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow']
        ], 200);
   }

   // Total Members
   public function members(Request $request)
   {
      $data = Member::fetchPeriod($request->headers->all(), $request->days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow']
        ], 200);
   }

   // Total Users
   public function users(Request $request)
   {
      $data = User::fetchPeriod($request->headers->all(), $request->days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow']
        ], 200);
   }

   // lineChart
   public function lineChart(Request $request)
   {
      $data = Visitor::lineChart($request->headers->all(), $request->type);
      return response()->json(['rows'=>$data], 200);
   }

   // pieChart
   public function pieChart(Request $request)
   {
      $data = Visitor::fetchCountries($request->headers->all(), $request->days);
      return response()->json(['rows'=>$data], 200);
   }


   // topSectors
   public function topSectors()
   {
      $xaxis   = $series = [];
      $data    = Sector::whereNULL('parent_id')
                    ->latest()
                    ->where(['status'=>true,'trash'=>false])
                    ->paginate(5);
      $sectors = SectorResource::collection($data);
      foreach($sectors as $sector) {
         $xaxis[]  = $sector->title;
         $series[] = count($sector->programs);
      }
      return response()->json(['xaxis'=>$xaxis,'series'=>$series], 200);
   }

   // recentPrograms
   public function recentPrograms()
   {
      $data = Product::latest()->where(['status'=>true, 'trash'=>false])->paginate(10);
      $row  = ProductResource::collection($data);
      return response()->json(['rows' => $row], 200);
   }
}
