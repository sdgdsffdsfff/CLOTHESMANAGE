<?php

/**
 * ProductlistController.class.php 
 * 产品列表实现
 * @author timelesszhuang
 * @version CLOTHESMANAGE 1.0
 * @copyright 赵兴壮
 * @package  Controller
 * @todo 进入产品分类操作界面
 * 2014年8月20 09:07
 */

namespace Home\Controller;

use Think\Controller;

class ProductlistController extends BaseController {

    /**
     * 主页跳转到主页
     * @author 赵兴壮
     * @version CLOTHESMANAGE 1.0
     * @access public
     * @todo 跳转到列表主页进行操作
     */
    public function index() {
        $this->display();
    }

    /**
     * 根据获取到的
     * @author 赵兴壮
     * @version CLOTHESMANAGE 1.0
     * @access public
     * @todo 编辑信息然后更新
     * @return array data 根据id 查询到的数据
     */
    public function jsonTree() {
        //产品分类获取  分配到前台
        $proSortModel = M('ProductSort');
        $proSortList = $proSortModel->order('myorder desc')->select();
        //要判断是不是该分组为空值
        if (!empty($proSortList)) {
            foreach ($proSortList as $value) {
                $id = $value['id'];
                $text = $value['name'];
                $proSortData[] = array('id' => $id, 'text' => $text);
            }
        } else {
            $proSortData[] = array('id' => 0, 'text' => '暂无产品分类!');
        }
        $data = array(array('id' => 'no', 'text' => '产品分类', 'state' => 'closed', 'children' => $proSortData));
        exit(json_encode($data));
    }

    /**
     * 跳转到各种分类下操作主界面
     * @access public
     * @version clothesmanage 1.0
     * @author timelesszhuang <834916321@qq.com> 
     * @param int $id 产品分类sort_id
     * @todo 跳转到各种产品分类
     */
    public function proList() {
        $this->assign('id', I('get.id'));
        $this->display();
    }

    /**
     * 暂时没用到  主要是选择产品分类
     * @access public
     * @version clothesmanage 1.0
     * @author timelesszhuang <834916321@qq.com> 
     * @todo 把当前主要产品分类列出来
     */
    public function selectJsonTree() {
        $productSortModel = M('ProductSort');
        $tree = $productSortModel->field(array('id', 'name' => 'text'))->select();
        $tree = array_merge(array(array('id' => '0', 'text' => L('请先选择产品分类'))), $tree);
        echo json_encode($tree);
    }

    /**
     * 编辑信息页面
     * @author 赵兴壮
     * @version CLOTHESMANAGE 1.0
     * @access public
     * @todo 操纵数据
     * @return json data 产品分类信息json
     */
    public function json() {
        $id = I('get.id');
        $productListModel = M('ProductList');
        $condition['sort_id'] = array('eq', $id);
        $proListData = $productListModel->where($condition)->select();
        $count = $productListModel->where($condition)->count();
        if ($count != 0) {
            $array['total'] = $count;
            $array['rows'] = $proListData;
            echo json_encode($array);
        } else {
            $array['total'] = 0;
            $array['rows'] = array();
            echo json_encode($array);
        }
    }

    /**
     * 编辑信息页面
     * @author 赵兴壮
     * @version CLOTHESMANAGE 1.0
     * @access public
     * @todo 编辑信息然后更新
     * @return array data 根据id 查询到的数据
     */
    public function edit() {
        $id = I('get.id');
        $proListModel = M('ProductList');
        $condition['id'] = array('eq', $id);
        $proListData = $proListModel->where($condition)->find();
        $this->assign('data', $proListData);
        $this->display();
    }

    /**
     * 编辑每一条信息页面
     * @author timelesszhuang <834916321@qq.com>
     * @version CLOTHESMANAGE 1.0
     * @access public
     * @todo 更新
     * @return array data 更新数据状态
     */
    public function update() {
        $data['id'] = I('post.id');
        $data['name'] = I('post.name');
        if (empty($data['name'])) {
            $this->formatReturnData('产品信息更新失败', '更新数据状态', $isclose, 'failed');
            exit();
        }
        $data['sort_id'] = I('post.sort_id');
        $data['num'] = I('post.num');
        $data['barcode'] = I('post.barcode');
        $data['generate_address'] = I('post.generate_address');
        $data['companyname'] = I('post.companyname');
        $data['standard'] = I('post.standard');
        $data['model'] = I('post.model');
        $data['retailprice'] = I('post.retailprice');
        $data['lowerprice'] = I('post.lowerprice');
        $data['presellprice1'] = I('post.presellprice1');
        $data['presellprice2'] = I('post.presellprice2');
        $data['myorder'] = I('post.myorder');
        $data['updatetime'] = time();
        $proListModel = M('ProductList');
        $updateStatus = $proListModel->save($data);
        if ($updateStatus) {
            $this->formatReturnData('产品分类更新成功', '更新数据状态', 'c', 'suc');
        } else {
            $this->formatReturnData('产品分类更新失败', '更新数据状态', 'c', 'failed');
        }
        exit();
    }

    /**
     * add
     * 进入添加信息页面
     * @access public
     * @return array
     * @version idui 1.0
     * @return  json  删除数据状态
     * @todo 添加数据
     */
    public function add() {
        $this->assign('id', I('get.id'));
        $this->display();
    }

    /**
     * 编辑信息页面
     * @author 赵兴壮
     * @version CLOTHESMANAGE 1.0
     * @access public
     * @todo 编辑信息然后更新
     * @return array data 根据id 查询到的数据
     */
    public function insert() {
        $data['name'] = I('post.name');
        if (empty($data['name'])) {
            $this->formatReturnData('请输入用户名称', '提示信息', $isclose, 'failed');
        }
        $data['sort_id'] = I('post.sort_id');
        $data['num'] = I('post.num');
        $data['barcode'] = I('post.barcode');
        $data['generate_address'] = I('post.generate_address');
        $data['companyname'] = I('post.companyname');
        $data['standard'] = I('post.standard');
        $data['model'] = I('post.model');
        $data['retailprice'] = I('post.retailprice');
        $data['lowerprice'] = I('post.lowerprice');
        $data['presellprice1'] = I('post.presellprice1');
        $data['presellprice2'] = I('post.presellprice2');
        $data['myorder'] = I('post.myorder');
        $data['updatetime'] = time();
        $proListModel = M('ProductList');
        $addStatus = $proListModel->add($data);
        if ($addStatus) {
            $this->formatReturnData('产品分类更新成功', '更新数据状态', 'c', 'suc');
        } else {
            $this->formatReturnData('产品分类更新失败', '更新数据状态', 'c', 'failed');
        }
        exit();
    }

    /**
     * delete  单值 多值 删除操作
     * @author timelesszhuang <834916321@qq.com>
     * @version CLOTHESMANAGE 1.0 版本
     * @access public
     * @param array $id要删除的id
     * @param int  $single  标注是不是单值删除 
     * @return json 删除数据状态
     */
    public function delete() {
        $proSortProductModel = M('ProductList');
        $isSingle = I('post.single');
        if ($isSingle == '1') {
//单值删除
            $id = I('post.id');
            $condition['id'] = array('eq', $id);
            $status = $addStatus = $proSortProductModel->where($condition)->delete();
            if ($status) {
                $this->formatReturnData('产品删除成功', '删除数据状态', 'c', 'suc');
            } else {
                $this->formatReturnData('产品删除失败', '删除数据状态', 'c', 'failed');
            }
        } else if ($isSingle == '2') {
//多值删除实现
            $ids = I('post.id');
            $idstring = implode(",", $ids);
            $status = $addStatus = $proSortProductModel->delete($idstring);
            if ($status) {
                $this->formatReturnData('产品删除成功', '删除数据状态', 'c', 'suc');
            } else {
                $this->formatReturnData('产品删除失败', '删除数据状态', 'c', 'failed');
            }
        }
        exit();
    }

    /**
     * 验证产品分类是不是已经添加
     * @author timelesszhuang <834916321@qq.com>
     * @version CLOTHESMANAGE 1.0 版本
     * @access public
     * @param array $name要验证的姓名
     * @param int  $id   该数值代表要验证的是更新操作的
     * @return json 要验证的产品名字
     */
    public function checkName() {
        $name = I('post.name');
        $proListModel = M('ProductList');
        if (isset($_POST['id'])) {
            $id = I('post.id');
            $condition['name'] = array('eq', $name);
            $condition['id'] = array('neq', $id);
            $proListData = $proListModel->where($condition)->find();
            if (empty($proListData)) {
                $data['status'] = 2;
                $data['msg'] = '该产品名称可以使用。';
            } else {
                $data['status'] = 1;
                $data['msg'] = '该产品已经存在。';
            }
            exit(json_encode($data));
        }
        $condition['name'] = array('eq', $name);
        $proListData = $proListModel->where($condition)->find();
        if (empty($proListData)) {
            $data['status'] = 2;
            $data['msg'] = '该产品名称可以使用。';
        } else {
            $data['status'] = 1;
            $data['msg'] = '该产品已经存在。';
        }
        exit(json_encode($data));
    }

}
