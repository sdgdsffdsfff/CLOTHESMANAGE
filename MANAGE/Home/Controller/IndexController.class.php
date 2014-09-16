<?php

/*
 * IndexController.class.php 
 * @author timelesszhuang
 * @version CLOTHESMANAGE 1.0
 * @copyright 赵兴壮
 * @package  Controller
 * @todo BaseController判断用户登录状态之后进入主界面
 * 2014年8月12 12:25
 */

namespace Home\Controller;
use Think\Controller;

class IndexController extends BaseController {

    public function index() {
        require_once(APP_PATH . '/Home/Conf/leftmenu.php'); //引入菜单
        $this->assign('menu', $menuarray);
        $this->display();
    }

}
