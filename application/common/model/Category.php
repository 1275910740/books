<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Category extends Model
{
    protected $insert = ['create_time'];

    /**
     * 反转义HTML实体标签
     * @param $value
     * @return string
     */
    protected function setContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * 自动生成时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 获取层级缩进列表数据
     * @return array
     */
    public function getLevelList()
    {
        $category_level = $this->order(['sort' => 'DESC'])->select();

        return array2level($category_level);
    }
}