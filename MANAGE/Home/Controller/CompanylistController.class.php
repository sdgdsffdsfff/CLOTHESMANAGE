<?php

/**
 * CompanylistController.class.php 
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

class CompanylistController extends BaseController {

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
        $comSortModel = M('CompanyList');
        $comSortList = $comSortModel->order('myorder desc')->select();
        if (!empty($comSortList)) {
            foreach ($comSortList as $value) {
                $id = $value['id'];
                $text = $value['name'];
                $comSortData[] = array('id' => $id, 'text' => $text);
            }
        }
        else
        {
            $comSortData[] = array('id' => 0, 'text' => '暂时没有单位信息!');
        }
        $data = array(array('id' => 'no', 'text' => '单位分类', 'state' => 'closed', 'children' => $comSortData));
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
    public function comList() {
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
        $productSortModel = M('ComanySort');
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
        $comListModel = M('CompanyList');
        $condition['sort_id'] = array('eq', $id);
        $comListData = $comListModel->where($condition)->select();
        $count = $comListModel->where($condition)->count();
        if ($count != 0) {
            $array['total'] = $count;
            $array['rows'] = $comListData;
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
        $comListModel = M('CompanyList');
        $condition['id'] = array('eq', $id);
        $comListData = $comListModel->where($condition)->find();
        $this->assign('data', $comListData);
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
            $this->formatReturnData('单位信息更新失败', '更新数据状态', $isclose, 'failed');
            exit();
        }
        $data['sort_id'] = I('post.sort_id');
        $data['num'] = I('post.num');
        $data['address'] = I('post.address');
        $data['telphone'] = I('post.telphone');
        $data['email'] = I('post.email');
        $data['contact'] = I('post.contact');
        $data['remark'] = I('post.remark');
        $data['myorder'] = I('post.myorder');
        $data['updatetime'] = time();
        $comListModel = M('CompanyList');
        $updateStatus = $comListModel->save($data);
        if ($updateStatus) {
            $this->formatReturnData('单位信息更新成功', '更新数据状态', 'c', 'suc');
        } else {
            $this->formatReturnData('单位信息更新失败', '更新数据状态', 'c', 'failed');
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
            $this->formatReturnData('请输入单位名称', '提示信息', $isclose, 'failed');
        }
        $data['sort_id'] = I('post.sort_id');
        $data['num'] = I('post.num');
        $data['address'] = I('post.address');
        $data['telphone'] = I('post.telphone');
        $data['email'] = I('post.email');
        $data['contact'] = I('post.contact');
        $data['remark'] = I('post.remark');
        $data['myorder'] = I('post.myorder');
        $data['updatetime'] = time();
        $comListModel = M('CompanyList');
        $addStatus = $comListModel->add($data);
        if ($addStatus) {
            $this->formatReturnData('单位信息更新成功', '更新数据状态', 'c', 'suc');
        } else {
            $this->formatReturnData('单位信息更新失败', '更新数据状态', 'c', 'failed');
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
        $proSortProductModel = M('CompanyList');
        $isSingle = I('post.single');
        if ($isSingle == '1') {
//单值删除
            $id = I('post.id');
            $condition['id'] = array('eq', $id);
            $status = $addStatus = $proSortProductModel->where($condition)->delete();
            if ($status) {
                $this->formatReturnData('单位信息删除成功', '删除数据状态', 'c', 'suc');
            } else {
                $this->formatReturnData('单位信息删除失败', '删除数据状态', 'c', 'failed');
            }
        } else if ($isSingle == '2') {
//多值删除实现
            $ids = I('post.id');
            $idstring = implode(",", $ids);
            $status = $addStatus = $proSortProductModel->delete($idstring);
            if ($status) {
                $this->formatReturnData('单位信息删除成功', '删除数据状态', 'c', 'suc');
            } else {
                $this->formatReturnData('单位信息删除失败', '删除数据状态', 'c', 'failed');
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
        $proListModel = M('CompanyList');
        if (isset($_POST['id'])) {
            $id = I('post.id');
            $condition['name'] = array('eq', $name);
            $condition['id'] = array('neq', $id);
            $proListData = $proListModel->where($condition)->find();
            if (empty($proListData)) {
                $data['status'] = 2;
                $data['msg'] = '该单位名称可以使用。';
            } else {
                $data['status'] = 1;
                $data['msg'] = '该单位已经存在。';
            }
            exit(json_encode($data));
        }
        $condition['name'] = array('eq', $name);
        $proListData = $proListModel->where($condition)->find();
        if (empty($proListData)) {
            $data['status'] = 2;
            $data['msg'] = '该单位名称可以使用。';
        } else {
            $data['status'] = 1;
            $data['msg'] = '该单位已经存在。';
        }
        exit(json_encode($data));
    }

}
