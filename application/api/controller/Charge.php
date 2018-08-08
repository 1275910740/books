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

         header('content-type:application/json;charset=utf8');
     
         $url="http://183.61.108.206:8088/opac/webservice/loanWebservice?wsdl&rdid=002010900002&doPage=true&pageSize=3&toPage=5";
         
        $html=file_get_contents($url);

         $sixml = simplexml_load_string($html);

         dump($sixml);
    
        
    } 
}