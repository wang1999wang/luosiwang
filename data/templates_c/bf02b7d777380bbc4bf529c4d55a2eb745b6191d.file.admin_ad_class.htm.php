<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-03 16:01:20
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_ad_class.htm" */ ?>
<?php /*%%SmartyHeaderCode:26066560f88629c0da9-30777632%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf02b7d777380bbc4bf529c4d55a2eb745b6191d' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_ad_class.htm',
      1 => 1443859277,
      2 => 'file',
    ),
    'c7dbd406038454f5fedad410c70ea02973487dcd' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\\\app\\template\\admin\\rooter.htm',
      1 => 1443856932,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26066560f88629c0da9-30777632',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560f88633b61d1_75357202',
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560f88633b61d1_75357202')) {function content_560f88633b61d1_75357202($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        

        
        <title>后台管理</title>
        
        
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
>
        
<?php echo '<script'; ?>
 src="js/show_pub.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
    function add_industry(type) {
        if (type == '1') {
            $("#class_name").val('');
            $("#orders").val('');
            $("#href").val('');
            $("#id").val('');
            $("#integral_buy").val('');
        }
        $.layer({
            type: 1,
            title: '添加类别',
            closeBtn: [0, true],
            border: [10, 0.3, '#000', true],
            offset: [($(window).height() - 320) / 2 + 'px', ''],
            area: ['320px', '320px'],
            page: { dom: '#houtai_div' }
        });
    }
    function save_adclass() {
        var id = $("#id").val();
        var pid = $("#pid").val();
        var class_name = $("#class_name").val();
        var orders = $("#orders").val();
        var pytoken = $("#pytoken").val();
        var integral_buy = $("#integral_buy").val();
        var type = $('input[name="type"]:checked').val();
        var href = $('#href').val();
        if ($.trim(class_name) == '') {
            parent.layer.msg('广告类别名称不能为空！', 2, 2); return false;
        }
        if (type == '1' && (integral_buy == '')) {
            parent.layer.msg('请输入购买<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
！', 2, 2); return false;
        }
        wait_result();
        $.post("index.php?m=advertise&c=class", { class_name: class_name, orders: orders, integral_buy: integral_buy, type: type, href: href, id: id, pid: pid, pytoken: pytoken }, function (msg) {
            if (msg == 1) {
                parent.layer.msg('操作成功！', 2, 9, function () { location = location; }); return false;
            } else {
                parent.layer.msg('操作失败！', 2, 8, function () { location = location; }); return false;
            }
        });
    }
<?php echo '</script'; ?>
>

        
        <link href="images/reset.css" rel="stylesheet" type="text/css" />
        <link href="images/system.css" rel="stylesheet" type="text/css" />
        <link href="images/table_form.css" rel="stylesheet" type="text/css" />
        
        

    </head>

    <body class="body_ifm">

        
<div id="wname" style="display:none; width: 400px; ">
    <div style="height: 180px;" class="job_box_div">
        <div class="job_box_inp">
            <table class="table_form " style="width:100%">
                <tr><td class='ui_content_wrap'>复制(CTRL+C)以下內容并添加到模板中</td></tr>
                <tr><td class='ui_content_wrap'>limit=5 为调用数量，可自行修改，如调用6条，为limit=6</td></tr>
                <tr><td><input type="text" name="position" id='copy_url' class="input-text" size='60' /></td></tr>
            </table>
        </div>
    </div>
</div>
<div id="houtai_div" style=" width:318px; display:none;">
    <table class="table_form " style="width:100%">
        <tbody>
            <tr class="ui_td_11">
                <td style="text-align: right;" class="ui_content_wrap">上级类别：</td>
                <td>
                    <select name="pid" id="pid">
                        <option value="0">一级类别</option>
                        <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ad_class_list1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['one']->value['class_name'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr class="ui_td_11">
                <td style="text-align: right;" class="ui_content_wrap">类别名称：</td>
                <td><input type="text" name="add_name" id="class_name" class="input-text" /></td>
            </tr>
            <tr class="ui_td_11">
                <td style="text-align: right;" class="ui_content_wrap">排&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;序：</td>
                <td><input type="text" name="orders" id='orders' size='5' class="input-text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /></td>
            </tr>
            <tr class="ui_td_11">
                <td style="text-align: right;" class="ui_content_wrap">广告类型：</td>
                <td>
                    <input type="radio" value='1' name="type" id="radio_1" onclick="$('.buy').show();">
                    <label for="radio_1">可购买</label>
                    <input type="radio" value='2' name="type" id="radio_2" checked='checked' onclick="$('.buy').hide();">
                    <label for="radio_2">不可购买</label>
                </td>
            </tr>
            <tr class="ui_td_11 buy" style="display:none">
                <td style="text-align: right;" class="ui_content_wrap">购买<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：</td>
                <td>
                    <input id="integral_buy" class="input-text" type="text" size="5" onkeyup="value=this.value.replace(/\D+/g,'')" value="" name="integral_buy">
                    <?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
/月
                </td>
            </tr>
            <tr class="ui_td_11">
                <td style="text-align: right;" class="ui_content_wrap">演示地址：</td>
                <td><input id="href" class="input-text" type="text" value="" name="href"></td>
            </tr>
            <tr class="ui_td_11">
                <td class="ui_content_wrap" colspan='2'>
                    <input name='id' value='' type='hidden' id='id' />
                    <input class="admin_submit4" type="button" name="add" value="添加" onclick="save_adclass()" />
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="infoboxp">
    <div class="infoboxp_top_bg"></div>
    <div class="infoboxp_top">
        <span class="admin_title_span">广告分类</span>
        <a href="javascript:void(0)" onclick="add_industry('1')" class="admin_infoboxp_tj">添加类别</a>
    </div>
    <div class="clear"></div>
    <div class="table-list">
        <div class="admin_table_border">
            <iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
            <form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
                <input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
                <input name="m" value="advertise" type="hidden" />
                <input name="c" value="delclass" type="hidden" />
                <table width="100%">
                    <thead>
                        <tr class="admin_table_top">
                            <th>
                                <label for="chkall">
                                    <input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
                                </label>
                            </th>
                            <th>编号</th>
                            <th align="left">分类名称</th>
                            <th>演示地址</th>
                            <th>排序</th>
                            <th>调用代码</th>
                            <th class="admin_table_th_bg">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ad_class_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['list']->key;
?>
                        <tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
">
                    <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
                    <td><span><?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
</span></td>
                    <td align="left"><span><?php echo $_smarty_tpl->tpl_vars['list']->value['class_name'];?>
</span></td>
                    <td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['list']->value['href'];?>
</td>
                    <td class="od"><?php echo $_smarty_tpl->tpl_vars['list']->value['orders'];?>
</td>
                    <td class="ud">
                        <a href="javascript:void(0);" onclick="copy_adclass('内部调用','{yun\:}adlist classid=<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
 limit=5 item=adlist_<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
{/yun}{yun\:}$adlist_<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
.html{/yun}{yun\:}/adlist{/yun}')" class="admin_cz_sc">内部调用</a>
                    </td>
                    <td><span style="cursor:pointer;" onclick="showdiv5('<?php echo $_smarty_tpl->tpl_vars['list']->value['class_name'];?>
','<?php echo $_smarty_tpl->tpl_vars['list']->value['orders'];?>
','<?php echo $_smarty_tpl->tpl_vars['list']->value['integral_buy'];?>
','<?php echo $_smarty_tpl->tpl_vars['list']->value['href'];?>
','<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['list']->value['type'];?>
');" class="admin_cz_bj">修改</span> | <a href="javascript:void(0)" onclick="layer_del('确定要删除？', 'index.php?m=advertise&c=delclass&id=<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
');" class="admin_cz_bj">删除</a></td>
                    </tr>
                    <?php } ?>
                    <tr style="background:#f1f1f1;">
                        <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
                        <td colspan="2">
                            <label for="chkAll2">全选</label>
                            &nbsp;
                            <input class="admin_submit4" type="button" name="delsub" value="删除所选" onclick="return really('del[]')" />
                        </td>
                        <td colspan="10" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    

        

        

        

        

        <?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </body>
</html><?php }} ?>
