<?php
namespace App\JsonFile;

class Analytics 
{
    public function fetchData() 
    {
        $data = file_get_contents(config_path('/../public/reports.json'));
        $data = json_decode($data, true);
        return $data;
    }

    // pieChart
    public function pieChart()
    {
        // pieChart Types 
        $lables   = ['extended', 'intermediate', 'primary'];
        $extended = $intermediate = $primary = 0;

        foreach ($this->fetchData() as $row) {
            if($row['body']['type'] == 'extended') {
                $extended++;
            } else if ($row['body']['type'] == 'intermediate') {
                $intermediate++;
            } else if ($row['body']['type'] == 'primary') {
                $primary++;
            }
        }

        $items = ['lables' => $lables, 'total'=> [$extended, $intermediate, $primary]];
        return $items;
    }



    // lineChart
    public function lineChart($type)
    {
        if($type == 'monthly') {
            $items = $this->byMonthly();
        } else if ($type == 'yearly') {
            $items = $this->byYearly();
        }

        return $items ?? [];
    }


    public function byMonthly()
    {
        $mo01     = $this->perMonth('01');
        $mo02     = $this->perMonth('02');
        $mo03     = $this->perMonth('03');
        $mo04     = $this->perMonth('04');
        $mo05     = $this->perMonth('05');
        $mo06     = $this->perMonth('06');
        $mo07     = $this->perMonth('07');
        $mo08     = $this->perMonth('08');
        $mo09     = $this->perMonth('09');
        $mo10     = $this->perMonth('10');
        $mo11     = $this->perMonth('11');
        $mo12     = $this->perMonth('12');

        $series   = [$mo01, $mo02, $mo03, $mo04, $mo05, $mo06, $mo07, $mo08, $mo09, $mo10, $mo11, $mo12];
        $xaxis    = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'];
        $data     = ['xaxis' => $xaxis, 'series'=>$series];
        return $data;
    }

    public function perMonth($month)
    {
        $items = 0;
        foreach ($this->fetchData() as $row) {
            if(date('m', strtotime($row['createdAt'])) == $month) {
                $items++;
            } 
        }
       return $items;
    }

    public function byYearly()
    {
        $prev_year    = date('Y', strtotime("-1 year"));
        $current_year = date('Y');
        $next1_year   = date('Y', strtotime("+1 year"));
        $next2_year   = date('Y', strtotime("+2 year"));
        $next3_year   = date('Y', strtotime("+3 year"));

        $series0      = $this->perYear($prev_year);
        $series1      = $this->perYear($current_year);
        $series2      = $this->perYear($next1_year);
        $series3      = $this->perYear($next2_year);
        $series4      = $this->perYear($next3_year);

        $series       = [$series0, $series1, $series2, $series3, $series4];
        $xaxis        = [$prev_year, $current_year, $next1_year, $next2_year, $next3_year];
        $items        = ['xaxis' => $xaxis, 'series'=>$series];
        return $items;
    }
    public function perYear($year)
    {
        $items = 0;
        foreach ($this->fetchData() as $row) {
            if(date('Y', strtotime($row['createdAt'])) == $year) {
                $items++;
            } 
        }
       return $items;
    }


    // barChart
    public function barChart()
    {
        $xaxis = $series = [];

        // sort by score desc..
        $data = $this->fetchData();
        usort($data, function($a, $b) { 
            return $a['body']['reportScore'] > $b['body']['reportScore'] ? -1 : 1;
        }); 

        // get only top 10
        $offset = array_slice($data, (1-1) * 10, 10); 
        foreach ($offset as $row) {
           $xaxis[]  = $row['body']['bankName'];
           $series[] = $row['body']['reportScore'];
        }

        $response = ['xaxis' => $xaxis, 'series' => $series];
        return $response;
    }

}