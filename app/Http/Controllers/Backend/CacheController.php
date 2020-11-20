<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    function __construct()
    {
       $this->middleware('permission:view_caches', 
            ['only' => ['cacheClear', 'configClear', 'viewClear', 'routeCache', 'routeClear']]);
    }

    public function cacheClear()
    {
      try {
          //Artisan::call('cache:clear');
          \Cache::flush();
          return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
          return response()->json(['message' => 'Unable to clear, '. $e->getMessage()], 500);
        }
    }

    public function configClear()
    {
        try {
          // Artisan::call('config:clear');
          return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
          return response()->json(['message' => 'Unable to clear, '. $e->getMessage()], 500);
        }
    }

    public function viewClear()
    {
        try {
          // Artisan::call('view:clear');
          return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
          return response()->json(['message' => 'Unable to clear, '. $e->getMessage()], 500);
        }
    }

    public function routeCache()
    {
      try {
          // Artisan::call('route:cache');
          return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
          return response()->json(['message' => 'Unable to clear, '. $e->getMessage()], 500);
        }
    }

    public function routeClear()
    {
      try {
        // Artisan::call('route:clear');
        return response()->json(['message' => ''], 200);
      } catch (\Exception $e) {
        return response()->json(['message' => 'Unable to clear, '. $e->getMessage()], 500);
      }
    }
}
