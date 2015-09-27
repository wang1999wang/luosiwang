<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-28 07:36:44
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_group_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:1673456087d8ceff3f3-48786079%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd7ae0126f632cdf6845a7fa5b8ac027f93cc16d' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_group_list.htm',
      1 => 1434528046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1673456087d8ceff3f3-48786079',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'adminusergroup' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56087d8d2b2da5_42887037',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56087d8d2b2da5_42887037')) {function content_56087d8d2b2da5_42887037($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />
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
 
<title>后台管理</title>
</head>
<body class="body_ifm">
<div class="infoboxp">
<div class="infoboxp_top_bg"></div>
<div class="admin_h1_bg infoboxp_topIjf">
<span class="infoboxp_top_span" style="float:left">管理员列表</span>
<a href="index.php?m=admin_user&c=addgroup"  class="admin_infoboxp_tj"> 添加管理员类型</a>
</div>
<div class="">
  <div class="table-list">
    <div class="admin_table_border">
      <table width="100%">
        <thead>
          <tr class="admin_table_top">
            <th width="7%">编号</th>
            <th width="12%">类型名称</th>
            <th width="12%">管理员数</th>
            <th width="12%" class="admin_table_th_bg">操作</th>
          </tr>
        </thead>
        <tbody>
        
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['adminusergroup']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <tr>
          <td align="center" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
          <td align="center" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['group_name'];?>
</td>
           <td align="center" style="cursor:pointer;">10</td>
          <td align="center">
			<a href="index.php?m=admin_user&c=addgroup&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_cz_bj">修改</a> |
		    <a href="javascript:void(0);" onClick="layer_del('确定要删除？','index.php?m=admin_user&c=delgroup&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_cz_sc">删除</a>
			</td>
        </tr>
        <?php } ?>
          </tbody>
        
      </table>
    </div>
  </div>
</div>
</div>
	<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
</body>
</html><?php }} ?>
