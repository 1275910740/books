<?php
namespace app\api\controller;

use think\Controller;
use think\Session;
use think\Db;
/**
 * 微信登入接口
 * Class Login
 * @package app\api\controller
 */
class Login extends Controller
{
    public function index()
    {
    	  $code =$this->request->param('_code');
        $nick_name =$this->request->param('nick_name');
        $face =$this->request->param('face');
        $appid ='wxe12d378320426745';
        $secret='d7d168774664e3d326e9ca41d0a85f99';
         $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $curl = new \app\common\controller\Curl();
        $info = $curl->get($url);
        $json = json_decode($info);
        $arr = get_object_vars($json);
        if(empty($arr['openid'])){
            $datas['code'] = 400;
            $datas['msg'] = 'secret被修改';
        }
        $open_id = $arr['openid'];
        if(empty($open_id)){
            $datas['code'] = 400;
            $datas['msg'] = '获取失败';
        }
        $result = DB::name('member')->where('open_id','=',$open_id)->find();
        if($result){
              $member_id = $result['member_id'];
              $open_id = $result['open_id'];
              $status = $result['status'];
              $datas['code'] =200;
              $datas['open_id'] = $open_id;
              $datas['status'] = $status;
              $datas['member_id'] =$member_id;
              $datas['msg'] ='获取成功';
        }else{
          $data['open_id'] = $open_id;
          $data['nick_name'] = $nick_name;
          $data['face'] = $face;
          $data['add_time'] = time();
          $sesole = DB::name('member')->insert($data);
            if($sesole){
                $open = DB::name('member')->where('open_id','=',$data['open_id'])->field('member_id,open_id')->find();
                $member_id = $open['member_id'];
                $openid = $open['open_id'];
                $status = $result['status'];
                $datas['code'] =200;
                $datas['member_id'] =$member_id;
                $datas['openid'] =$openid;
                $datas['status'] = $status;
                $datas['msg'] ='获取成功';
                 
            }
        }
        return json_encode($datas);

    }

    public function information(){

      $member_id =$this->request->param('member_id');
      $area =$this->request->param('area');
      $like = $this->request->param('like');
      $id_number =$this->request->param('id_number');

      if(empty($member_id) || empty($area)){
            $datas['code'] = 400;
            $datas['msg'] = '确少参数';
            return json_encode($datas);
        }
          $data['member_id'] = $member_id;
          $data['area'] = $area;
          $data['like'] = $like;
          $data['id_number'] = $id_number;
          $data['add_time'] = time();
          $result = DB::name('member_details')->insert($data);
          if($result){
            $datas['code'] = 200;
            $datas['msg'] = '添加成功';
          }else{
            $datas['code'] = 400;
            $datas['msg'] = '添加失败';
          }
        return json_encode($datas);

    }

    public function shuffling(){

      $shuffling = DB::name('slide')->where('status','1')->order('sort desc')->select();
      $column = DB::name('category')->where('status','1')->order('sort desc')->select();
      $datas['code'] = 200;
      $datas['msg'] = '获取成功';
      $datas['data'] =$shuffling;
      $datas['column'] = $column;

      return  json_encode($datas);
      
    }
}