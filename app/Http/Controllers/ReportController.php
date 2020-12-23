<?php

namespace App\Http\Controllers;

use App\JsonFile\Report;
use App\JsonFile\Analytics;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index()
    {

      try {
        
        $rows = new Report;

        if(request('bankName')) {
          $rows->whereLike('bankName', request('bankName'));
        }

        if(request('bankBIC')) {
          $rows->whereLikeIN('bankBIC', request('bankBIC'));
        }

        if(request('type')) {
          $rows->where('type', request('type'));
        }

        if(request('published')) {
          $rows->wherePublished(request('published'));
        }

        if(request('score_from') || request('score_to')) {
          $rows->whereBetween('reportScore', request('score_from') ?? false, request('score_to') ?? false);
        }

        if(request('sort')) {
          if(request('sort_by') == 'createdAt' || request('sort_by') == 'publishedAt') {
              $rows->sortDate(request('sort_by'), request('sort'));
          } else if (request('sort_by') == 'bankBIC') {
              $rows->sortIN(request('sort_by'), request('sort'));
          } else {
              $rows->sort(request('sort_by'), request('sort'));
          }
        }

        $links = $rows->links();
        $rows  = $rows->pagination(request('perPage') ?? 10);

          return response()->json([
              'items'    => $rows ?? [],
              'paginate' => $links
          ], 200);

      } catch (\Exception $e) {
          return response()->json([
              'message'  => $e->getMessage()
          ], 500);
      }

    }


    public function lineChart($type)
    {
      $items = new Analytics;
      return response()->json(['items' => $items->lineChart($type)], 200);
    }

    public function pieChart()
    {
      $items = new Analytics;
      return response()->json(['items' => $items->pieChart()], 200);
    }

    public function barChart()
    {
      $items = new Analytics;
      return response()->json(['items' => $items->barChart()], 200);
    }

}