<?php
namespace app\admin\controller;

use app\common\model\Article as ArticleModel;
use app\common\model\Category as CategoryModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 栏目管理
 * Class Category
 * @package app\admin\controller
 */
class Category extends AdminBase
{

    protected $category_model;
    protected $article_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->category_model = new CategoryModel();
        $this->article_model  = new ArticleModel();
       
         $category_level_list = Db::name('category')->select();


        $this->assign('category_level_list', $category_level_list);
    }

    /**
     * 栏目管理
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 添加栏目
     * @param string $pid
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存栏目
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Category');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->category_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑栏目
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $category = Db::name('category')->find($id);

        return $this->fetch('edit', ['category' => $category]);
    }

    /**
     * 更新栏目
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Category');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                    if ($this->category_model->allowField(true)->save($data, $id) !== false) {
                        $this->success('更新成功');
                    } else {
                        $this->error('更新失败');
                    }
                }
            }
    }

    /**
     * 删除栏目
     * @param $id
     */
    public function delete($id)
    {
        $category = $this->category_model->where(['pid' => $id])->find();
        $article  = $this->article_model->where(['cid' => $id])->find();

        if (!empty($category)) {
            $this->error('此分类下存在子分类，不可删除');
        }
        if (!empty($article)) {
            $this->error('此分类下存在文章，不可删除');
        }
        if ($this->category_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
    public function jiekou(){

            $data = array ('rdid ' => '002010900002','doPage '=>'true','pageSize '=>10,'toPage '=>4);
            $data = http_build_query($data);

            $opts = array (
            'http' => array (
            'method' => 'POST',
            'header'=> "Content-type: application/x-www-form-urlencodedrn".
            "Content-Length: " . strlen($data) . "rn",
            'content' => $data
            )
            );

            $context = stream_context_create($opts);
            
            $html = file_get_contents('http://183.61.108.206:8088/opac/webservice/loanWebservice?wsdl', false, $context);
dump($html);
            die;
            echo $html;
    }
}