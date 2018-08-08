<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;

/**
 * 后台首页
 * Class Index
 * @package app\admin\controller
 */
class Feedback extends AdminBase
{

    protected function _initialize()
    {
        parent::_initialize();
    }
   
    /**
     * 用户反馈信息
     * @return mixed
     */
    public function index()
    {
        $category_level_list = Db::name('feedback')->select();
        
        foreach($category_level_list as $k=>$v){
            $member_id = $v['member_id'];
           $category_level_list[$k]['user'] =  Db::name('member')->where('member_id',$member_id)->field('nick_name,face')->select();

        }

        $this->assign('category_level_list', $category_level_list);
       return $this->fetch();
    }

    public function delete(){

      $id =$this->request->param('id');

      if(empty($id)){
         $this->success('删除失败');
      }
      $result = Db::name('feedback')->where('id',$id)->delete();
      if($result){
         $this->success('删除成功');
      }else{
         $this->success('删除失败');
      }
    }
}