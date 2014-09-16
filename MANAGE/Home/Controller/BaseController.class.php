<?php

/*
 * 公共类其他控制器继承该类   1判断登录状态  2
 * @author timelesszhuang
 * @version CLOTHESMANAGE 1.0
 * @copyright 赵兴壮
 * @package  Controller
 * @todo 验证用户登录状态
 * 2014年8月12 12:00
 */

namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller {

    /**
     * _initialize()
     * 判断用户登录状态
     * @access public
     * @version CLOTHESMANAGE 1.0
     * @todo 登录验证
     */
    public function _initialize() {
        if (!isset($_SESSION['IS_LOGIN'])) {
            //跳转到登登录页面
            redirect(__MODULE__ . "/Login");
        }
    }

    /** 
     * formatReturnData() 把数据操纵状态json形式传送到后台
     * @access protected
     * @author timelesszhuang<834916321@qq.com>
     * @param string $info 数据操纵结果信息
     * @param string $title 提示信息的时候标题
     * @param string $isclose 右下角显示的窗体是否关闭   c 表示关闭  o 表示不关闭 
     * @param boolen $status 数据操纵状态  默认成功
     * @version CLOTHESMANAGE 1.0
     * @todo 返回数据到前台
     */

    protected function formatReturnData($info,$title="提示信息",$isclose='c',$status='suc'){
        $data['info']=$info;
        $data['title']=$title;
        $data['isclose']=$isclose;
        $data['status']=$status;
        echo json_encode($data);  
    }
}
