<?php

class EvaluationController extends BaseController {

  public function postEvaluate($id) {
    $content = Input::get('content', '');
    $rate = intval(Input::get('rate', 0));

    if ($content === '' || $rate === 0) {
      return Response::json(array('info' => '数据不能为空'), 400);
    }

    DB::table('evaluation')->insert(
        array(
            'cid' => $id,
            'comment' => $content,
            'rate' => $rate,
            'is_deleted' => 0
          )
      );

    return Response::json(array('info' => true));
  }

  public function postVote($id) {
    return $_SERVER;
    return Request::server('SERVER_ADDR') . ':' . Request::server('REMOTE_ADDR');
    return Request::getClientIp();
  }

  public function getBasic($id) {
    $info = DB::table('courses')
                ->select('*')
                ->where('id', '=', $id)
                ->first();
    return json_decode(json_encode($info), true);
  }

  public function getInfo($id) {
    $info = DB::table('courses')
                ->select('*')
                ->where('id', '=', $id)
                ->first();
    $comments = DB::table('evaluation')
                ->select('id', 'cid', 'rate', 'comment', 'is_deleted')
                ->where('cid', '=', $id)
                ->get();

    $info = json_decode(json_encode($info), true);
    //$comments = json_decode(json_encode($comments), true);

    foreach ($comments as &$value) {
      if ($value->is_deleted == 1) {
        $value->comment = "<!-- 由于用户举报已被隐藏了哟 -->";
      }
      unset($value->is_deleted);
    }

    $sum = 0;
    foreach ($comments as $item) {
      $sum += $item->rate;
    }
    $info['rate'] = count($comments) === 0 ? '暂时还没有评价' : round($sum / count($comments), 2);

    $result = array();
    $result['info'] = $info;
    $result['comments'] = $comments;

    return $result;
  }

  public function postStat() {
    $useragent = Request::header('user-agent');
    $result = DB::table('stat')->insert(
        array(
            'views' => $useragent
          )
      );
    return array('status' => true);
  }

}