<?php

$menuarray = array(
    array('label' => '基本资料', 'type' => 'sys_name', 'items' => array(
            array('label' => '商品设置', 'type' => 'base_name', 'items' => array(
                    #使用交行系统原有的部分修改
                    array('label' => '商品分类管理', 'type' => 'setting_base', 'pertype' => '1', 'link' => __MODULE__ . '/Productsort/index'),
                    array('label' => '商品信息管理', 'type' => 'setting_base', 'pertype' => '1', 'link' => __MODULE__ . '/Productlist/index')
                )),
            array('label' => '单位设置', 'type' => 'menu_region_name', 'items' => array(
                    array('label' => '单位分类管理', 'type' => 'region_list', 'pertype' => '1', 'link' => __MODULE__ . '/Companysort/index'),
                    array('label' => '单位信息管理', 'type' => 'region_list', 'pertype' => '1', 'link' => __MODULE__ . '/Companylist/index')
                )),
            array('label' => '职员设置', 'type' => 'menu_citysites_name', 'items' => array(
                    #还未实现  要实现跳转到城市站点相应管理
                    array('label' => '职员信息管理', 'type' => 'citysites_list', 'pertype' => '1', 'link' => __MODULE__ . '/Clerk/index'),
                )),
            array('label' => '仓库设置', 'type' => 'menu_wxlist_name', 'items' => array(
                    array('label' => '仓库信息管理', 'type' => 'wx_list', 'pertype' => '1', 'link' => __MODULE__ . '/Warehouse/index'),
                )),
            array('label' => '结算账户设置', 'type' => 'card_name', 'items' => array(
                    array('label' => '结算账户管理（还没搞懂呢）', 'type' => 'card_list', 'link' => __MODULE__ . '/CardList/index')
                )),
            array('label' => '收支项目设置', 'type' => 'card_name', 'items' => array(
                    array('label' => '收支项目管理（还没搞懂呢）', 'type' => 'card_list', 'link' => __MODULE__ . '/CardList/index')
                ))
        )),
    array('label' => '业务录入', 'type' => 'user_name', 'items' => array(
            array('label' => '信息录入', 'type' => 'member_name', 'items' => array(
                    array('label' => '销售单', 'type' => 'changepwd', 'rel' => 'dialog', 'link' => __MODULE__ . '/Account/changepwd'),
                    array('label' => '销售退货单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '零售单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '进货单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '进货退货单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '收款单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '付款单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '收入单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '支出单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '转账单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index'),
                    array('label' => '付款单', 'type' => 'member_frontlist', 'link' => __MODULE__ . '/Members/index')
                ))
        )),
    array('label' => '报表查询', 'type' => 'user_name', 'items' => array(
            array('label' => '信息录入', 'type' => 'member_name', 'items' => array(
                    array('label' => '以后再加', 'type' => 'changepwd', 'rel' => 'dialog', 'link' => __MODULE__ . '/Account/changepwd'),
                ))
        ))
);
