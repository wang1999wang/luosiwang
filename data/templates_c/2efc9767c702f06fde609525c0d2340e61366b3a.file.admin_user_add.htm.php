<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-03 21:49:52
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_user_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:9562560fdbd52cef88-48498010%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2efc9767c702f06fde609525c0d2340e61366b3a' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_user_add.htm',
      1 => 1443880184,
      2 => 'file',
    ),
    'c7dbd406038454f5fedad410c70ea02973487dcd' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\\\app\\template\\admin\\rooter.htm',
      1 => 1443880088,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9562560fdbd52cef88-48498010',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560fdbd59ef4a2_48894800',
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560fdbd59ef4a2_48894800')) {function content_560fdbd59ef4a2_48894800($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
>
            $(document).ready(function () {
                $(".job_name").hover(function () {
                    var job_name = $(this).attr('v');
                    if ($.trim(job_name) != '') {
                        layer.tips(job_name, this, { guide: 1, style: ['background-color:#F26C4F; color:#fff;top:-7px', '#F26C4F'] });
                    }
                }, function () {
                    var job_name = $(this).attr('v');
                    if ($.trim(job_name) != '') {
                        layer.closeTips();
                    }
                });
                //弹窗框部分
                $(".status").click(function () {
                    var uid = $(this).attr("pid");
                    var pytoken = $("#pytoken").val();
                    var status = $(this).attr("status");
                    $("#status_" + status).attr("checked", true);
                    $("input[name=uid]").val(uid);
                    status_div('锁定用户', '350', '220');
                });
                $(".user_status").click(function () {
                    var id = $(this).attr("pid");
                    var status = $(this).attr("status");
                    $("#status" + status).attr("checked", true);
                    var pytoken = $("#pytoken").val();
                    $("input[name=yesid]").val(id);
                    $.layer({
                        type: 1,
                        title: '友情链接审核',
                        closeBtn: [0, true],
                        border: [10, 0.3, '#000', true],
                        area: ['350px', '160px'],
                        page: { dom: "#infobox2" }
                    });
                });
            })
        <?php echo '</script'; ?>
>
        
        
        <link href="images/reset.css" rel="stylesheet" type="text/css" />
        <link href="images/system.css" rel="stylesheet" type="text/css" />
        <link href="images/table_form.css" rel="stylesheet" type="text/css" />
        
<link href="./images/table_form.css" rel="stylesheet" type="text/css" />


    </head>

    <body class="body_ifm">

        



<div class="infoboxp">
    <div class="infoboxp_top_bg"></div>
    <div class="infoboxp_top">
        <span class="infoboxp_top_span" style="float:left">添加管理员</span>
        <a href=" javascript:history.back(-1);" class="admin_infoboxp_tj">管理员列表</a>
    </div>
    <div class="common-form">
        <div class="admin_table_border">
            <iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
            <form name="myform" action="index.php?m=admin_user&c=save" target="supportiframe" method="post" id="myform">
                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value[0];?>
" name="uid" />
                <table width="100%" class="table_form contentWrap" style="background:#fff;">
                    <tr>
                        <td style="width:110px; text-align:right">用户名：</td>
                        <td>
                            <input type="text" name="username" id="realname" class="input-text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value[2];?>
">
                        </td>
                    </tr>
                    <tr class="admin_table_trbg">
                        <td style="width:110px; text-align:right">密码：</td>
                        <td>
                            <input type="password" name="password" id="realname" class="input-text" size="30" value=""><?php if (is_array($_smarty_tpl->tpl_vars['adminuser']->value)) {?><font color="gray">如果密码留空则不修改密码！</font><?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:110px; text-align:right">真实姓名：</td>
                        <td>
                            <input type="text" name="name" id="realname" class="input-text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['adminuser']->value[4];?>
">
                        </td>
                    </tr>
                    <tr class="admin_table_trbg">
                        <td style="width:110px; text-align:right">权限：</td>
                        <td>
                            <select name="m_id">
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['user_group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['id']==$_smarty_tpl->tpl_vars['adminuser']->value[1]) {?> selected=selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['group_name'];?>
</option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input class="admin_submit4" name="useradd" type="submit" value="提交" id="dosubmit">
                        </td>
                </table>
                <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
            </form>
        </div>
    </div>
</div>


        

        

        

        

    </body>
</html><?php }} ?>
