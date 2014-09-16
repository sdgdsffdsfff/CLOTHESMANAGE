<?php

/**
 * CompanysortController.class.php 
 * 单位分类实现
 * @author timelesszhuang
 * @version CLOTHESMANAGE 1.0
 * @copyright 赵兴壮
 * @package  Controller
 * @todo 进入单位分类操作界面
 * 2014年8月12 12:25
 */

namespace Home\Controller;

use Think\Controller;

class CompanysortController extends BaseController {

    /**
     * 主页跳转到主页
     * @author 赵兴壮
     * @version CLOTHESMANAGE 1.0
     * @access public
     * @todo 跳转到主页进行操作
     */
    public function index() {
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
    public function edit() {
        $id = I('get.id');
        $comSortModel = M('CompanySort');
        $condition['id'] = array('eq', $id);
        $comSortData = $comSortModel->where($condition)->find();
        $this->assign('data', $comSortData);
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
            $this->formatReturnData('单位分类更新失败', '更新数据状态', $isclose, 'failed');
            exit();
        }
        $data['remark'] = I('post.remark');
        $data['myorder'] = I('post.order');
        $data['updatetime'] = time();
        $proSortModel = M('CompanySort');
        $condition['id'] = array('eq', $id);
        $updateStatus = $proSortModel->save($data);
        if ($updateStatus) {
            $this->formatReturnData('单位分类更新成功', '更新数据状态', 'c', 'suc');
        } else {
            $this->formatReturnData('单位分类更新失败', '更新数据状态', 'c', 'failed');
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
            $this->formatReturnData('请输入单位分类名称', '提示信息', $isclose, 'failed');
        }
        $data['myorder'] = I('post.order');
        $data['remark'] = I('post.remark');
        $data['updatetime'] = time();
        $companySortModel = M('CompanySort');
        $addStatus = $companySortModel->add($data);
        if ($addStatus) {
            $this->formatReturnData('单位分类更新成功', '更新数据状态', 'c', 'suc');
        } else {
            $this->formatReturnData('单位分类更新失败', '更新数据状态', 'c', 'failed');
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
        $comSortModel = M('CompanySort');
        $isSingle = I('post.single');
        if ($isSingle == '1') {
            //单值删除
            $id = I('post.id');
            $condition['id'] = array('eq', $id);
            $status = $addStatus = $comSortModel->where($condition)->delete();
            if ($status) {
                $this->formatReturnData('单位分类删除成功', '删除数据状态', 'c', 'suc');
            } else {
                $this->formatReturnData('单位分类删除失败', '删除数据状态', 'c', 'failed');
            }
        } else if ($isSingle == '2') {
            //多值删除实现
            $ids = I('post.id');
            $idstring = implode(",", $ids);
            $status = $addStatus = $proSortProductModel->delete($idstring);
            if ($status) {
                $this->formatReturnData('单位分类删除成功', '删除数据状态', 'c', 'suc');
            } else {
                $this->formatReturnData('单位分类删除失败', '删除数据状态', 'c', 'failed');
            }
        }
        exit();
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
        $comSortModel = M('CompanySort');
        $proSortData = $comSortModel->select();
        $count = $comSortModel->count();
        if ($count != 0) {
            $array['total'] = $count;
            $array['rows'] = $proSortData;
            echo json_encode($array);
        } else {
            $array['total'] = 0;
            $array['rows'] = array();
            echo json_encode($array);
        }
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
        $comSortModel = M('CompanySort');
        if (isset($_POST['id'])) {
            $id = I('post.id');
            $condition['name'] = array('eq', $name);
            $condition['id'] = array('neq', $id);
            $proSortData = $comSortModel->where($condition)->find();
            if (empty($proSortData)) {
                $data['status'] = 2;
                $data['msg'] = '该单位分类名称可以使用。';
            } else {
                $data['status'] = 1;
                $data['msg'] = '该单位分类已经存在。';
            }
            exit(json_encode($data));
        }
        $condition['name'] = array('eq', $name);
        $proSortData = $comSortModel->where($condition)->find();
        if (empty($proSortData)) {
            $data['status'] = 2;
            $data['msg'] = '该单位分类名称可以使用。';
        } else {
            $data['status'] = 1;
            $data['msg'] = '该单位分类已经存在。';
        }
        exit(json_encode($data));
    }

}
