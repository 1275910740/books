<?php
namespace app\api\controller;

use think\Controller;
use think\Session;
use think\Db;
/**
 *添加栏目
 * Class Ueditor
 * @package app\api\controller
 */
class Programa extends Controller
{
    /**连续签到的实现方式*/
    public function sign(){
    
     $title = $this->request->param('title');  
     $content = $this->request->param('content');

     if(empty($title) || empty($content)){
        $datas['code'] = 200;
        $datas['msg'] = '缺少参数';
     }

     $data['title'] = $title;
             
    }
    
}