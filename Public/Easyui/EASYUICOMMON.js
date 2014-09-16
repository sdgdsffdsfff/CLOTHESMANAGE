/**
 * openDatagrid 执行datagrid 操作公共操作 比如 设定datagrid urljson
 * @param classId id
 * @param urljson 读取数据的url地址
 * @author 赵兴壮
 * @version CLOTHESMANAGE
 */
function openDatagrid(classId, urljson) {
    var height = $('.indexcenter').height();
    $('#datagrid_' + classId).datagrid({
        url: urljson,
        idField: 'id',
        pagination: true,
        rownumbers: true,
        fitColumns: true,
        height: height - 50,
        frozenColumns: [[
                {
                    field: 'ck',
                    checkbox: true
                }
            ]]
                //Same as the columns property, but the these columns will be frozen on left.
    });
}
/**
 *openDialog 弹出框 包括添加修改各类操作
 *@param href 传递控制器的url地址
 *@param title 弹出窗口的标题
 *@param classId  操纵各个操作的标识  
 *@author 赵兴壮
 *@version CLOTHESMANGE 1.0版本
 */
function openDialog(classId, href, title) {
    $('#dialog_cms').dialog({
        href: href,
        width: 900,
        height: 550,
        resizable: true,
        title: title,
        modal: true,
        resizable:true,
                collapsible: true,
        maximizable: true,
        cache: false,
        onClose: function() {
            dialogOnClose();
        },
        buttons: [{
                text: '保存',
                iconCls: 'icon-ok',
                handler: function() {
                    submitForm(classId); //调用更新操作
                }
            }, {
                text: '取消',
                iconCls: 'icon-cancel',
                handler: function() {
                    dialogOnClose();
                }
            }
        ]
    });
}

/**
 *  submitForm  提交表单时执行
 *  @param classId 为当前表单的id
 *  @author 赵兴壮
 *  @version CLOTHESMANAGE 1.0版本
 */
function submitForm(classId) {
    var url = $('.form_dogocms').attr('action');
    $('.form_dogocms').form('submit', {//easyui 内置封装好的方法 .form()方法实现ajax提交表单  封装好的.post  .get
        url: url,
        onSubmit: function() {
            //可以进行一下字段检查之类的
        },
        success: function(msg) {
            var data = $.parseJSON(msg);
            formAjax(data, classId);
        }
    });
}

/**
 * 关闭dialog时，销毁dialog代码
 * @author 赵兴壮
 * @version CLOTHESMANAGE 1.0 版本
 */
function dialogOnClose() {
    $('#dialog_cms').dialog('destroy');
    $('body.layout_index').append('<div id="dialog_cms"  data-options="iconCls:\'icon-save\'"></div>');
    var frame = $('iframe[src="about:blank"]');//destroy与iframe冲突问题，大概是内存释放的原因
    frame.remove();
}

/**
 * ajax 更新操作完成之后操作
 * @param data 完成请求之后返回的信息
 * @param classId  执行操作的classid     
 * @author 赵兴壮
 * @version CLOTHERMANAGE 1.0 版本
 */
function formAjax(data, classId) {
    $('#treegrid_' + classId).treegrid('reload');
    $('#datagrid_' + classId).datagrid('reload');
    if (data.status == 'suc') {
        $.messager.show({
            title: data.title,
            msg: data.info,
            timeout: 5000,
            showType: 'slide'
        });

        if (data.isclose == 'c')
        {
            dialogOnClose();  // 关闭dialog()实现
        }
    } else if (data.status == 'failed') {
        $.messager.alert(data.title, data.info, 'error');
    }
}

/**
 * 编辑信息操作
 * @author 赵兴壮
 * @version CLOTHESMANAGE 1.0版本
 * @param string href  编辑信息 获取数据路径   操作信息id在href中   后台使用get 方式获取
 * @param string classId
 * @returns  null
 */
function ding_edit(href, classId) {
    var title = '编辑信息';
    openDialog(classId, href, title);
}
/**
 * 删除信息操作
 * @param int id
 * @param string  href
 * @param string classId
 * @returns null
 */
function ding_cancel(id, href, classId) {
    var title = '删除信息';
    $.messager.confirm(title, '确定要删除信息吗?', function(status) {
        if (!status) {
            return false;
        }

        $.ajax({
            url: href,
            type: 'post',
            data: {
                id: id,
                single: '1'
            },
            dataType: 'json',
            success: function(data) {
                formAjax(data, classId);
            }
        });
    });//$
}

/**
 * 多条删除信息实现
 * @param string classId
 * @param string url
 * @param string subtitle
 * @returns null
 */
function dogoDelete(ids, title, href, classId) {
    $.messager.confirm(title, '确定要删除信息吗?', function(r) {
        if (!r) {
            return false;
        }
        $.ajax({
            url: href,
            type: 'post',
            data: {
                id: ids,
                single: '2'
            },
            dataType: 'json',
            success: function(data) {
                formAjax(data, classId);
            }
        });
    });
}


/**
 * @
 * 更新tab功能*/
function updateTab(classId, url, subtitle) {
    $('#tabs_' + classId).tabs('select', subtitle);
    var tab = $('#tabs_' + classId).tabs('getSelected');
    tab.panel('refresh', url);
}

/**
 * openTreeGrid 执行树结构的文档
 *classId id
 * urljson 读取数据的url地址
 * hrefadd 添加信息路径
 * hrefedit修改信息路径
 * hrefcancel 删除信息路径 暂未使用
 */

function openTreeGrid(classId, urljson, hrefadd, hrefedit, hrefcancel) {
    var height = $('.indexcenter').height();
    $('#treegrid_' + classId).treegrid({
        url: urljson,
        idField: 'id',
        treeField: 'text',
        pagination: true,
        rownumbers: true,
        fitColumns: true,
        autoRowHeight: false,
        showFooter: true,
        height: height - 50,
        animate: true,
        toolbar: [{
                id: 'btnadd' + classId,
                text: '添加',
                iconCls: 'icon-add',
                handler: function() {
                    var title = '添加分类';
                    openDialog(classId, hrefadd, title);
                }
            }, '-', {
                id: 'btnedit' + classId,
                text: '编辑',
                iconCls: 'icon-edit',
                handler: function() {
                    var selected = $('#treegrid_' + classId).datagrid('getSelected');
                    if (!selected) {
                        $.messager.alert('信息提示', '请选择要操作的项', 'error');
                        return false;
                    }
                    var id = selected.id;
                    var href = hrefedit + '?id=' + id;
                    var title = '编辑信息';
                    openDialog(classId, href, title);
                }
            }, '-', {
                id: 'btncancel' + classId,
                text: '删除',
                iconCls: 'icon-cancel',
                handler: function() {
                    var selected = $('#treegrid_' + classId).datagrid('getSelected');
                    if (!selected) {
                        $.messager.alert('信息提示', '请选择要操作的项', 'error');
                        return false;
                    }
                    var id = selected.id;
                    var href = hrefcancel;
                    var title = '删除信息';
                    dogoDelete(id, title, href, classId);
                }
            }
        ]
    });
}


/**
 * @returns {undefined}
 */
function changeTheme(themeName) {
    var $easyuiTheme = $('#easyuiTheme');
    var url = $easyuiTheme.attr('href');
    var href = url.substring(0, url.indexOf('themes')) + 'themes/' + themeName + '/easyui.css';
    $easyuiTheme.attr('href', href);

    var $iframe = $('iframe');
    if ($iframe.length > 0) {
        for (var i = 0; i < $iframe.length; i++) {
            var ifr = $iframe[i];
            $(ifr).contents().find('#easyuiTheme').attr('href', href);
        }
    }

    $.cookie('easyuiThemeName', themeName, {
        expires: 7
    });
}
















/*
 *  失去作用
 *
 */
function closeCombo() {
    $('body.layoutindex>.combo-p').remove();
    $('body.layoutindex>.window').remove();
    $('body.layoutindex>.window-shadow').remove();
    $('body.layoutindex>.window-mask').remove();
}