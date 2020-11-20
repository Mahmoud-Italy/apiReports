<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Analytics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExploreController extends Controller
{
    // Total Visitors
    public function visitors($days)
    {
      $data = Analytics::fetchPeriod('visitors', $days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow'],
        ], 200);
    }

    // Total Pages
   public function pages($days)
   {
      $data = Analytics::fetchPeriod('pages', $days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow']
        ], 200);
   }

   // Total Messages
   public function messages($days)
   {
      $data = Analytics::fetchPeriod('inboxes', $days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow']
        ], 200);
   }

   // Total Users
   public function users($days)
   {
      $data = Analytics::fetchPeriod('users', $days);
      return response()->json([
            'total'      => $data['total'],
            'percentage' => $data['percentage'],
            'arrow'      => $data['arrow']
        ], 200);
   }

   // lineChart
   public function lineChart($type)
   {
      $data = Analytics::lineChart('visitors', $type);
      return response()->json(['rows' => $data], 200);
   }

   // pieChart
   public function pieChart($days)
   {
      $data = Analytics::fetchCountries('visitors', $days);
      return response()->json(['rows'=>$data], 200);
   }

}
