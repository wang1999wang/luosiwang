<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-30 13:06:01
         compiled from "E:\WWW\luosiwang\app\template\admin\login.htm" */ ?>
<?php /*%%SmartyHeaderCode:2673560b6db97f45b8-60928228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18ca1c4fc30a6111a8f8cd2bd22febc200c76d28' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\login.htm',
      1 => 1436321722,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2673560b6db97f45b8-60928228',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560b6db9950088_50271809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560b6db9950088_50271809')) {function content_560b6db9950088_50271809($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="images/admin.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
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
<title><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
 - ��̨��������</title>
</head>
<body>
<div class="admin_logo_bg">
<div class="logoin_top"></div>
<div class="logoin_cont">
<div class="login_box">
<div class="logoin_c">
<div class="logoin_logo"><img src="images/logoin_logo.png"></div>
<div class="logoin_title"><div class=""></div>
	<div class="login_iptbox">
	<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
	<form action="" method="post" target="supportiframe">
    <ul class="logoin_list">
		<li><span><label for="username">�û�����</label></span><input type="text" class="ipt" size="10" name="username" value="" /></li>
		<li><span><label for="password">��&nbsp; �룺</label></span><input type="password" class="ipt" name="password" value="" /></li>
       
       <?php if (stripos($_smarty_tpl->tpl_vars['config']->value['code_web'],"��̨��½")) {?>
       <li>
		<span><label for="code">��֤�룺</label></span><input type="text" id="ipt_code" class="ipt_code" name="authcode" value="" />
        <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/app/include/authcode.inc.php" align="absmiddle" >
        </li>
        <?php }?>
        
		<li><span>&nbsp;</span><input type="submit" class="admin_login_sub" name="login_sub" value="��¼" /><input type="reset" class="admin_login_sub admin_login_sub1" name="login_sub" value="����" /></li>
      </ul>
	  <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	</form>
	</div>
</div>
</div>
</div>
</div>
</body>
</html><?php }} ?>
