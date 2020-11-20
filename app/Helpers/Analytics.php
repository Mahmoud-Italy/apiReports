<?php
namespace App\Helpers;

use DB;
use Carbon\Carbon;

class Analytics 
{

  // fetch Period
  public static function fetchPeriod($tableName, $days)
  {
        $operator   = '-';
        $percentage = '0%';
        $arrow      = 'ti-arrow-down';

        // get Period Day
        $obj = self::fetchPeriodDay($tableName, $days);

        // find percentage & arrow
        if($days != 'infinity') {
            $obj2 = self::fetchPeriodDay($tableName, $days);
            if($obj >= $obj2) { $operator = '+'; $arrow = 'ti-arrow-up'; } 
            else { $operator = '-'; $arrow = 'ti-arrow-down'; }

            $diff = 0;
            if($obj > 0 && $obj2) { $diff = $obj / $obj2 * 100; }
            $percentage = $operator.''.$diff.'%';
        }

        $data = ['total' => $obj, 'percentage' => $percentage, 'arrow' => $arrow];
        return $data;
        
  }

    public static function fetchPeriodDay($tableName, $days)
    {
        $obj = DB::table($tableName)->where('id','!=', 0);


            $date = 'created_at';
            if($tableName == 'visitors') {
              $date = 'at_date';
            }

            // Today & else = Yesterday, 28 Days, 90 Days , 180 Days
            if($days != 'infinity') {
                if($days == 0) {
                    $obj = $obj->whereDate($date, Carbon::now());
                } else if ($days != 0) {
                    $obj = $obj->whereDate($date, '>=', Carbon::now()->subDay($days));
                }
            }

        $obj = $obj->count();
        return $obj;
    }



    // fetch Countries
    public static function fetchCountries($tableName, $days)
    {
        $countries = $total = [];
        $obj = DB::table($tableName)->select('country');

            // Today   & else = Yesterday, 28 Days, 90 Days , 180 Days
            if($days == 0) {
                $obj = $obj->whereDate('at_date', Carbon::now());
            } else if ($days != 0 && $days != 'infinity') {
                $obj = $obj->whereDate('at_date', '>=', Carbon::now()->subDay($days));
            } 

        $obj = $obj->whereNOTNULL('country')->groupBy('country')->paginate(5);

        foreach ($obj as $value) {
            $countries[] = $value->country;
            $total[] = self::totalCountryVisits($tableName, $value->country, $days);
        }

        $data = ['countries' => $countries, 'total'=>$total];
        return $data;
    }


    public static function totalCountryVisits($tableName, $country, $days)
    {
        $obj = DB::table($tableName);

            if($days == 0) {
                $obj = $obj->whereDate('at_date', Carbon::now());
            } else if ($days != 0 && $days != 'infinity') {
                $obj = $obj->whereDate('at_date', '>=', Carbon::now()->subDay($days));
            } 

        $obj = $obj->where('country', $country)->groupBy('country')->count();
        return $obj ?? 0;
    }


    public static function lineChart($tableName, $type)
    {
        if($type == 'weekly') {
            return self::postViewsWeekly($tableName);
        } else if($type == 'monthly') {
            return self::postViewsMonthly($tableName);
        } else if ($type == 'quarter') {
            return self::postViewsQuarter($tableName);
        } else if ($type == 'yearly') {
            return self::postViewsYearly($tableName);
        }
    }

    public static function postViewsWeekly($tableName)
    {
        $sun     = self::viewsPerWeek($tableName, '00');
        $mon     = self::viewsPerWeek($tableName, '01');
        $thu     = self::viewsPerWeek($tableName, '02');
        $wed     = self::viewsPerWeek($tableName, '03');
        $tue     = self::viewsPerWeek($tableName, '04');
        $fri     = self::viewsPerWeek($tableName, '05');
        $sat     = self::viewsPerWeek($tableName, '06');

        $series  = [$sun, $mon, $thu, $wed, $tue, $fri, $sat];
        $xaxis   = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursady', 'Friday', 'Saturday'];
        $data    = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }
    public static function viewsPerWeek($tableName, $day)
    {
       $obj = DB::table($tableName);
           
        $obj = $obj->whereRaw('WEEKDAY(created_at)='.$day)
                    ->count();

        return $obj ?? [];
    }

    public static function postViewsMonthly($tableName)
    {
        $mo01     = self::viewsPerMonth($tableName, '01');
        $mo02     = self::viewsPerMonth($tableName, '02');
        $mo03     = self::viewsPerMonth($tableName, '03');
        $mo04     = self::viewsPerMonth($tableName, '04');
        $mo05     = self::viewsPerMonth($tableName, '05');
        $mo06     = self::viewsPerMonth($tableName, '06');
        $mo07     = self::viewsPerMonth($tableName, '07');
        $mo08     = self::viewsPerMonth($tableName, '08');
        $mo09     = self::viewsPerMonth($tableName, '09');
        $mo10     = self::viewsPerMonth($tableName, '10');
        $mo11     = self::viewsPerMonth($tableName, '11');
        $mo12     = self::viewsPerMonth($tableName, '12');

        $series   = [$mo01, $mo02, $mo03, $mo04, $mo05, $mo06, $mo07, $mo08, $mo09, $mo10, $mo11, $mo12];
        $xaxis    = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'];
        $data     = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }

    public static function viewsPerMonth($tableName, $month)
    {
        $date = 'created_at';
        if($tableName == 'visitors') {
            $date = 'at_date';
        }

        $obj = DB::table($tableName)
                    ->whereMonth($date, $month)
                    ->count();

        return $obj ?? [];
    }


    public static function postViewsQuarter($tableName)
    {
        $quarter1   = self::viewsPerQuarter($tableName, ['01', '03']);
        $quarter2   = self::viewsPerQuarter($tableName, ['04', '06']);
        $quarter3   = self::viewsPerQuarter($tableName, ['07', '09']);
        $quarter4   = self::viewsPerQuarter($tableName, ['10', '12']);

        $series     = [$quarter1, $quarter2, $quarter3, $quarter4];
        $xaxis      = ['Jan - Mar', 'Apr - Jun', 'Jul - Sep', 'Oct - Dec'];
        $data       = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }
    public static function viewsPerQuarter($tableName, $quarter)
    {
        $date = 'created_at';
        if($tableName == 'visitors') {
            $date = 'at_date';
        }
        
        $obj = DB::table($tableName)
                  ->whereBetween(DB::raw('MONTH(created_at)'), $quarter)
                  ->whereYear($date, date('Y'))
                  ->count();
        return $obj ?? [];
    }


    public static function postViewsYearly($tableName)
    {
        $prev_year    = date('Y', strtotime("-1 year"));
        $current_year = date('Y');
        $next1_year   = date('Y', strtotime("+1 year"));
        $next2_year   = date('Y', strtotime("+2 year"));
        $next3_year   = date('Y', strtotime("+3 year"));

        $series0      = self::viewPerYear($tableName, $prev_year);
        $series1      = self::viewPerYear($tableName, $current_year);
        $series2      = self::viewPerYear($tableName, $next1_year);
        $series3      = self::viewPerYear($tableName, $next2_year);
        $series4      = self::viewPerYear($tableName, $next3_year);

        $series       = [$series0, $series1, $series2, $series3, $series4];
        $xaxis        = [$prev_year, $current_year, $next1_year, $next2_year, $next3_year];
        $data         = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }
    public static function viewPerYear($tableName, $year)
    {
        $date = 'created_at';
        if($tableName == 'visitors') {
            $date = 'at_date';
        }
        
        $obj = DB::table($tableName)
                  ->whereYear($date, $year)
                  ->count();
       return $obj ?? [];
    }

}