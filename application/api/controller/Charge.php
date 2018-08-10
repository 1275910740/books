<?php
namespace app\api\controller;

use think\Controller;
use think\Session;

/**
 *分馆信息查询API
 * Class Ueditor
 * @package app\api\controller
 */
class Charge extends Controller
{
    /**
     * 使用curl 分为4步:
     * 第一步，初始化 $ch = curl_init();
     * 第二步：进行配置 curl_setopt()  //记忆方法：set配置  option选项  
     * 第三步：执行--发送请求curl_exec()
     * 第四步：关闭curl资源  curl_close();
     */
    public function charge(){
      header("Content-type:text/json;charset=utf-8");
         $search = $this->request->param('serarch');

         $url='http://183.61.108.206:8088/opac/api/search?q=''.$search.''&searchWay=title&rows=10&page=2';
       //$file_contents = file_get_content('http://183.61.108.206:8088/opac/api/search?q=php&searchWay=title&rows=10&page=1');
         $json = $this->get_url($url);
         $xml = simplexml_load_string($json,NULL,LIBXML_NOCDATA);
         $array =json_decode(json_encode($xml),true);
         echo '<pre>';
         print_r($array);
         echo '</pre>';/*

         $data = json_encode($array);
          return $data;*/
    }
    public function borrow(){
      header("Content-type:text/json;charset=utf-8");
      $url = "http://183.61.108.206:8088/opac/webservice/loanWebservice?wsdl";
      $json = $this->get_url($url);
      $xml = simplexml_load_string($json,NULL,LIBXML_NOCDATA);
             dump($xml);
      die;
      $array = json_decode(json_encode($xml),true);
      print_r($array);
    }


    public function get_url($url){ 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url); //设置访问的url地址 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//不输出内容 
        $result = curl_exec($ch); 
        curl_close ($ch); 
        return $result; 
    }
    
    
}