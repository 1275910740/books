<?php
namespace app\admin\controller;
use app\common\model\AuthGroup as AuthGroupModel;
use app\common\model\AuthRule as AuthRuleModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 分馆管理
 * Class Index
 * @package app\admin\controller
 */
class Branch extends AdminBase
{
    protected function _initialize()
    {
        parent::_initialize();
        $this->auth_group_model = new AuthGroupModel();
        $this->auth_rule_model  = new AuthRuleModel();
    }

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        $auth_group_list = $this->auth_group_model->select();

        return $this->fetch('index', ['auth_group_list' => $auth_group_list]);
        

        return $this->fetch('index',['config' => $config]);
    }
}