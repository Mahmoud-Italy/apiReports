<?php
namespace App\JsonFile;

class Report 
{
  protected $data;
  protected $page = 1;
  protected $perPage = 10;

  function __construct() 
  {
    $data = file_get_contents(config_path('/../public/reports.json'));
    $data = json_decode($data, true);

    $this->page = request('page') ?? 1;
    $this->data = $data;
  }

  public function where($key, $value) 
  {
    $data = [];
    foreach ($this->data as $row) {
      if(strtolower($row['body'][$key] == strtolower($value))) {
        $data[] = $row;
      }
    }

    $this->data = $data;
  }

  public function whereLike($key, $value) 
  {
    $data = [];
    foreach ($this->data as $row) {
      $position = strpos(strtolower($row['body'][$key]), strtolower($value));
      if($position !== false) {
        $data[] = $row;
      }
    }

    $this->data = $data;
  }

  public function whereIN($key, $value) 
  {
    $data = [];
    foreach ($this->data as $row) {
        foreach($row['body'][$key] as $item) {
            if(strtolower($item) == strtolower($value)) {
                $data[] = $row;
            }
        }
    }

    $this->data = $data;
  }

  public function whereLikeIN($key, $value) 
  {
    $data = [];
    foreach ($this->data as $row) {
        foreach($row['body'][$key] as $item) {
            $position = strpos(strtolower($item), strtolower($value));
            if($position !== false) {
              $data[] = $row;
            }
        }
    }

    $this->data = $data;
  }

  public function wherePublished($value) 
  {
    $data = [];
    $currentDate = date('Y-m-d');
    foreach ($this->data as $row) {
        if($value == 1) { // publsihed
          if($currentDate >= date('Y-m-d', strtotime($row['publishedAt']))) {
            $data[] = $row;
          }
        } else if ($value == 2) { // not published yet
          if($currentDate < date('Y-m-d', strtotime($row['publishedAt']))) {
            $data[] = $row;
          }
        }
    }

    $this->data = $data;
  }

  public function whereBetween($key, $from, $to) 
  {
    $data = [];
    foreach ($this->data as $row) {
        $score = number_format($row['body'][$key], 14);
            if($from && !$to) {
                if($from <= $row['body'][$key]) {
                    $data[] = $row;
                }
            } else if (!$from && $to) {
                if($to >= $row['body'][$key]) {
                    $data[] = $row;
                }
            } else if ($from && $to) {
                if($score > $from && $score < $to) {
                    $data[] = $row;
                }
            }
    }

    $this->data = $data;
  }



  public function whereOut($key, $value) 
  {
    $data = [];
    foreach ($this->data as $row) {
      $position = strpos(strtolower($row[$key]), strtolower($value));
      if($position !== false) {
        $data[] = $row;
      }
    }

    $this->data = $data;
  }

  public function sort($key, $value) 
  {
      usort($this->data, function($a, $b) use ($key, $value) { 
          if(strtolower($value) == 'desc') {
              return $a['body'][$key] > $b['body'][$key] ? -1 : 1;
          } else {
              return $a['body'][$key] < $b['body'][$key] ? -1 : 1;
          }
      });
  }

  public function sortIN($key, $value) 
  {
      usort($this->data, function($a, $b) use ($key, $value) { 
          if(strtolower($value) == 'desc') {
              return $a['body'][$key][0] > $b['body'][$key][0] ? -1 : 1;
          } else {
              return $a['body'][$key][0] < $b['body'][$key][0] ? -1 : 1;
          }
      });
  }

  public function sortOut($key, $value) 
  {
      usort($this->data, function($a, $b) use ($key, $value) { 
          if(strtolower($value) == 'desc') {
              return $a[$key] > $b[$key] ? -1 : 1;
          } else {
              return $a[$key] < $b[$key] ? -1 : 1;
          }
      });
  }

  public function sortDate($key, $value) 
  {
      usort($this->data, function($a, $b) use ($key, $value) { 
          if(strtolower($value) == 'desc') {
              return strtotime($a[$key]) > strtotime($b[$key]) ? -1 : 1;
          } else {
              return strtotime($a[$key]) < strtotime($b[$key]) ? -1 : 1;
          }
      });
  }

  public function pagination($perPage=10) 
  {
    $this->perPage = $perPage;
    return array_slice($this->data, ($this->page-1) * $this->perPage, $this->perPage); 
  }

  public function links()
  {
    $this->perPage = request('perPage') ?? 10; // update perPage
    $links = [
        'total'        => count($this->data),
        'per_page'     => (int)$this->perPage,
        'current_page' => (int)$this->page
    ];
    return $links;
  }

  public function get() 
  {
    return $this->data;
  }

}
?>