<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use App\Helpers\helper;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = [];

    // Save As Visitors
    public static function saveAsVisitor()
    {
        try {
            $row             = new self;
            $row->ip         = request()->ip();
            $row->at_date    = date('Y-m-d');
            $row->country    = 'Egypt';
            $row->user_agent = request()->header('User-Agent');
            $row->save();
        } catch (\Exception $e) {}
    }

    // fetch Period
    public static function fetchPeriod($header, $days)
    {
        $operator = '-';
        $percentage = '0%';
        $arrow = 'ti-arrow-down';

        // get Period Day
        $obj = self::fetchPeriodDay($header, $days);

        // find percentage & arrow
        if($days != 'infinity') {
            $obj2 = self::fetchPeriodDay($header, $days);
            if($obj >= $obj2) { $operator = '+'; $arrow = 'ti-arrow-up'; } 
            else { $operator = '-'; $arrow = 'ti-arrow-down'; }

            $diff = 0;
            if($obj > 0 && $obj2) { $diff = $obj / $obj2 * 100; }
            $percentage = $operator.''.$diff.'%';
        }

        $data = ['total'=>$obj, 'percentage'=>$percentage, 'arrow'=>$arrow];
        return $data;
        
    }

    public static function fetchPeriodDay($header, $days)
    {
        $obj = self::where('id','!=', 0);

            // Today & else = Yesterday, 28 Days, 90 Days , 180 Days
            if($days == 0) {
                $obj = $obj->whereDate('at_date', Carbon::now());
            } else if ($days != 0 && $days != 'infinity') {
                $obj = $obj->whereDate('at_date', '>=', Carbon::now()->subDay($days));
            } 

        $obj = $obj->count();
        return $obj;
    }



    // fetch Countries
    public static function fetchCountries($header, $days)
    {
        $countries = $total = [];

        $obj = self::select('country')->whereNOTNULL('country');

            // Today   & else = Yesterday, 28 Days, 90 Days , 180 Days
            if($days == 0) {
                $obj = $obj->whereDate('at_date', Carbon::now());
            } else if ($days != 0 && $days != 'infinity') {
                $obj = $obj->whereDate('at_date', '>=', Carbon::now()->subDay($days));
            } 

        $obj = $obj->groupBy('country')->paginate(5);

        foreach ($obj as $value) {
            $countries[] = $value->country;
            $total[] = self::totalCountryVisits($value->country, $days);
        }

        $data = ['countries' => $countries, 'total'=>$total];
        return $data;
    }


    public static function totalCountryVisits($country, $days)
    {
        $obj = 0;
        $obj = self::where('country', $country);

            if($days == 0) {
                $obj = $obj->whereDate('at_date', Carbon::now());
            } else if ($days != 0 && $days != 'infinity') {
                $obj = $obj->whereDate('at_date', '>=', Carbon::now()->subDay($days));
            } 

        $obj = $obj->groupBy('country')->count();
        return $obj;
    }


    public static function lineChart($header, $type)
    {
        if($type == 'weekly') {
            return self::postViewsWeekly($header);
        } else if($type == 'monthly') {
            return self::postViewsMonthly($header);
        } else if ($type == 'quarter') {
            return self::postViewsQuarter($header);
        } else if ($type == 'yearly') {
            return self::postViewsYearly($header);
        }
    }

    public static function postViewsWeekly($header)
    {
        $sun     = self::viewsPerWeek('00');
        $mon     = self::viewsPerWeek('01');
        $thu     = self::viewsPerWeek('02');
        $wed     = self::viewsPerWeek('03');
        $tue     = self::viewsPerWeek('04');
        $fri     = self::viewsPerWeek('05');
        $sat     = self::viewsPerWeek('06');

        $series  = [$sun, $mon, $thu, $wed, $tue, $fri, $sat];
        $xaxis   = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursady', 'Friday', 'Saturday'];
        $data    = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }
    public static function viewsPerWeek($day)
    {
        return self::whereRaw('WEEKDAY(created_at)='.$day)->count();
    }

    public static function postViewsMonthly($header)
    {
        $mo01     = self::viewsPerMonth('01');
        $mo02     = self::viewsPerMonth('02');
        $mo03     = self::viewsPerMonth('03');
        $mo04     = self::viewsPerMonth('04');
        $mo05     = self::viewsPerMonth('05');
        $mo06     = self::viewsPerMonth('06');
        $mo07     = self::viewsPerMonth('07');
        $mo08     = self::viewsPerMonth('08');
        $mo09     = self::viewsPerMonth('09');
        $mo10     = self::viewsPerMonth('10');
        $mo11     = self::viewsPerMonth('11');
        $mo12     = self::viewsPerMonth('12');

        $series   = [$mo01, $mo02, $mo03, $mo04, $mo05, $mo06, $mo07, $mo08, $mo09, $mo10, $mo11, $mo12];
        $xaxis    = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'];
        $data     = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }

    public static function viewsPerMonth($month)
    {
        return self::whereMonth('at_date', $month)->count();
    }


    public static function postViewsQuarter($header)
    {
        $quarter1   = self::viewsPerQuarter(['01', '03']);
        $quarter2   = self::viewsPerQuarter(['04', '06']);
        $quarter3   = self::viewsPerQuarter(['07', '09']);
        $quarter4   = self::viewsPerQuarter(['10', '12']);

        $series     = [$quarter1, $quarter2, $quarter3, $quarter4];
        $xaxis      = ['Jan - Mar', 'Apr - Jun', 'Jul - Sep', 'Oct - Dec'];
        $data       = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }
    public static function viewsPerQuarter($quarter)
    {
        return self::whereBetween(DB::raw('MONTH(created_at)'), $quarter)->whereYear('at_date', date('Y'))->count();
    }


    public static function postViewsYearly($header)
    {
        $prev_year    = date('Y', strtotime("-1 year"));
        $current_year = date('Y');
        $next1_year   = date('Y', strtotime("+1 year"));
        $next2_year   = date('Y', strtotime("+2 year"));
        $next3_year   = date('Y', strtotime("+3 year"));

        $series0      = self::viewPerYear($prev_year);
        $series1      = self::viewPerYear($current_year);
        $series2      = self::viewPerYear($next1_year);
        $series3      = self::viewPerYear($next2_year);
        $series4      = self::viewPerYear($next3_year);

        $series       = [$series0, $series1, $series2, $series3, $series4];
        $xaxis        = [$prev_year, $current_year, $next1_year, $next2_year, $next3_year];
        $data         = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }
    public static function viewPerYear($year)
    {
        return self::whereYear('at_date', $year)->count();
    }
}
