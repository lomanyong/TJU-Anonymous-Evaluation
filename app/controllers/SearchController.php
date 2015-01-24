<?php

class SearchController extends BaseController {

  public function getSearch($query) {
    $result = array();
    if ($query != '') {
      /*$result1 = DB::table('courses')
                  ->select('*')
                  ->where('coursename', 'like', '%'.$query.'%')
                  ->get();
      $result2 = DB::table('courses')
                  ->select('*')
                  ->where('teacher', 'like', '%'.$query.'%')
                  ->get();
      $result = array_unique(array_merge($result1, $result2), SORT_REGULAR);*/
      $result = DB::table('courses')
                  ->select('*')
                  ->where('coursename', 'like', '%'.$query.'%')
                  ->get();
    }
    return $result;
  }

  public function getHot() {
    $result = array();
    $arr = DB::table('evaluation')
                ->join('courses', 'evaluation.cid', '=', 'courses.id')
                ->select('evaluation.cid', 'courses.coursename', 'courses.teacher', DB::raw('count(*) as count, sum(rate) as sum'))
                ->groupBy('evaluation.cid')
                ->get();

    $arr = json_decode(json_encode($arr), true);

    foreach ($arr as &$value) {
      $value['avg'] = round($value['sum']/$value['count'], 2);
      unset($value['sum']);
    }

    usort($arr, function($a, $b) {
      $result = 0;
      if ($a['avg'] > $b['avg']) {
        $result = -1;
      } else if ($a['avg'] < $b['avg']) {
        $result = 1;
      }
      return $result;
    });
    $result['score'] = array_slice($arr, 0, 5);

    usort($arr, function($a, $b) {
      return $b['count'] - $a['count'];
    });
    $result['hot'] = array_slice($arr, 0, 5);

    return $result;
  }

}