<?php
namespace app\api\controller;

use think\Controller;
use think\Session;
use think\Db;
/**
 *分馆信息查询API
 * Class Ueditor
 * @package app\api\controller
 */
class Signlist extends Controller
{
    /**连续签到的实现方式*/
    public function sign(){
           
         $member_id =$this->request->param('member_id');
        /**先查到是否有这个用户*/
         $sign = DB::name('sign')->where('member_id',$member_id)->find();
        /**如果有就进行判断时间差，然后处理签到次数*/
        if($sign){
            /**昨天的时间戳时间范围*/
            $t = time();
            $last_start_time = mktime(0,0,0,date("m",$t),date("d",$t)-1,date("Y",$t));
            $last_end_time = mktime(23,59,59,date("m",$t),date("d",$t)-1,date("Y",$t));
            /**今天的时间戳时间范围*/
             $now_start_time = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
             $now_end_time = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
            /**判断最后一次签到时间是否在昨天的时间范围内*/
            if($last_start_time<$sign['time'] && $sign['time']<$last_end_time){
                $da['time'] = time();
                $da['count'] = $sign['count']+1;
                $da['gral'] = $sign['gral']+5;
              Db::name('sign')->where('member_id',$member_id)->sava($da);
            }else{
                /**返回已经签到的操作*/
                $datas['code'] = 400;
                $datas['msg'] = '今天已经签到请明天再试！';
            }
        }else{
            $data['member_id'] = $member_id;
            $data['time'] = time();
            $data['count'] = 1;
            $data['gral'] = 5;
            $res = DB::name('sign')->insert($data);
            if($res){
                $datas['code'] = 200;
                $datas['msg'] = '签到成功';
            }
        }

        return json_encode($datas);
    }
    /**
     * 意见反馈
     */
    public function feedback(){
      $member_id =$this->request->param('member_id');
      $text = $this->request->param('text');
      $imagepath = request()->file('filepathImage');

      if(empty($member_id) || empty($text)){
        $datas['code'] = 600;
        $datas['msg'] = '参数不能为空';
      }

      $data['member_id'] = $member_id;
      $data['text'] = $text;
      $data['imagepath'] = $imagepath;

      $result = DB::name('feedback')->insert($data);
      if($result){
          $datas['code'] = 200;
          $datas['msg'] = '添加成功';
      }else{
          $datas['code'] = 500;
          $datas['msg'] = '添加失败';
      }
       return json_encode($datas);

    }
}