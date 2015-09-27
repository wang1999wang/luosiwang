<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-28 07:36:48
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_group.htm" */ ?>
<?php /*%%SmartyHeaderCode:1274756087d90280bd6-41573977%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17d216b276250f310d748854fb1188a79ac73c63' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_group.htm',
      1 => 1434528046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1274756087d90280bd6-41573977',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'admin_group' => 0,
    'navigation' => 0,
    'v' => 0,
    'power' => 0,
    'one_menu' => 0,
    'val' => 0,
    'two_menu' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56087d90c603a4_31739913',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56087d90c603a4_31739913')) {function content_56087d90c603a4_31739913($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<link href="./images/reset.css" rel="stylesheet" type="text/css" />
<link href="./images/system.css" rel="stylesheet" type="text/css" />

<link href="./images/table_form.css" rel="stylesheet" type="text/css" />

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

<title></title>
<?php echo '<script'; ?>
 language="javascript">
function check_group(t1,t2){
	var t1,t2;
	if(t1!=""){
		document.getElementById("group"+t1).checked="checked";	
	}
	if(t2!=""){
		document.getElementById("group"+t2).checked="checked";	
	}
}
<?php echo '</script'; ?>
>
</head>
<body class="body_ifm">

<div class="infoboxp">
<div class="infoboxp_top_bg"></div>
<div class="admin_h1_bg infoboxp_topIjf">
<span class="infoboxp_top_span">添加用户组</span>
<span class="infoboxp_top_span_sz infoboxp_top_span_sz_in ">
	<a href=" javascript:history.back(-1);" class="infoboxp_tj">管理员组列表</a> 
</span>

</div>
<div class="clear"></div>
<div class="common-form">
<div class="admin_table_border">
<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe> 
<form name="myform" target="supportiframe" action="index.php?m=admin_user&c=savagroup" method="post" id="myform">
<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['admin_group']->value[0];?>
" name="groupid" />
<table width="100%" style="background:#fff;">
	<tr>
		<td width="150" height="30" align="center" style="border-right:1px solid #CCC;">用户组名称</td>
		<td  style="padding-left:10px;">
        <input type="text" name="group_name" id="realname" class="input-text" size="40" value="<?php echo $_smarty_tpl->tpl_vars['admin_group']->value[1];?>
"></input>
        </td>
	</tr>
    <tr>
    	<td colspan="2" style="height:1px; background-color:#CCC"></td>
    </tr>
	<tr>
		<td  width="120" align="center" style="border-right:1px solid #CCC;">用户组权限</td>
		<td>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigation']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
            <table width="100%" bgcolor="#dfdfdf">
            <tr>
                <td height="30" style="padding-left:10px">
                <input type="checkbox"	name="power[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" id="group<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['id'],$_smarty_tpl->tpl_vars['power']->value)) {?> checked="checked"<?php }?>>
                <label for="group<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</label>
                </td>
            </tr>
            <tr>
            <td>
                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one_menu']->value[$_smarty_tpl->tpl_vars['v']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
            	<table width="100%" bgcolor="#f7f7f7">
                <tr>
                <td height="30" style="padding-left:40px;">
                    <input type="checkbox" name="power[]" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" id="group<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" <?php if (in_array($_smarty_tpl->tpl_vars['val']->value['id'],$_smarty_tpl->tpl_vars['power']->value)) {?> checked="checked"<?php }?>  onClick="check_group(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
,'')">
                    <label for="group<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</label>
                </td>
                </tr>
                <tr>
                <td bgcolor="#fdfeff" height="30" style="padding-left:70px;">
                    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['two_menu']->value[$_smarty_tpl->tpl_vars['val']->value['id']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                    <div style="float:left; width:120px; height:30px; line-height:30px; ">
                    <input type="checkbox" name="power[]" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" id="group<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" <?php if (in_array($_smarty_tpl->tpl_vars['value']->value['id'],$_smarty_tpl->tpl_vars['power']->value)) {?> checked="checked"<?php }?> onClick="check_group(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
)">
                    <label for="group<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</label>
                	</div>
                	<?php } ?>
                </td>
                </tr>
                <?php } ?>
                 </table>
               </td>
               </tr>
               </table>
         <?php } ?>
    	</td>
		</tr>
	<tr>
		<td colspan="2" align="center" height="40" style="border-top:1px solid #CCC;">
           <input class="admin_submit4" name="add_group" type="submit" value="提交" id="dosubmit">
</td>
</table>
</form>
</div>
</div></div>
</body>
</html><?php }} ?>
