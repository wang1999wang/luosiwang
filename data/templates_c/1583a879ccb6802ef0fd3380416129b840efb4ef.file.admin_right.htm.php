<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-02 10:36:04
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_right.htm" */ ?>
<?php /*%%SmartyHeaderCode:29743560ded947a4442-57443373%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1583a879ccb6802ef0fd3380416129b840efb4ef' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_right.htm',
      1 => 1436322896,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29743560ded947a4442-57443373',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'nav_user' => 0,
    'dirname' => 0,
    'mruser' => 0,
    'db_config' => 0,
    'soft' => 0,
    'kongjian' => 0,
    'banben' => 0,
    'yonghu' => 0,
    'server' => 0,
    'pytoken' => 0,
    'base' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560ded94cb91f2_41752362',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560ded94cb91f2_41752362')) {function content_560ded94cb91f2_41752362($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\WWW\\luosiwang\\app\\include\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="images/reset.css" rel="stylesheet" type="text/css" /> 
<?php echo '<script'; ?>
 src="../js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript"><?php echo '</script'; ?>
> 
<title>��̨����</title>
<style>
<!--
.mainright a,.maincontent a:visited{color:#F00; text-decoration:none;}
.mainright a:hover{color:#900; text-decoration:underline;}
.mainleft a,.mainleft a:visited{color:#06C; text-decoration:none;}
.mainleft a:hover{color:#00F; text-decoration:underline;}
-->
</style>
<?php echo '<script'; ?>
> 
/*�������е�js����*/
function killerrors() {return true;}
window.onerror = killerrors;
function logout(){
	if (confirm("��ȷ��Ҫ�˳����������"))
	top.location = 'index.php?c=logout';
	return false;
}
var integral_pricename='<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
';  
<?php echo '</script'; ?>
>
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="./js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
  DD_belatedPNG.fix('.png,.header .logo,.header .nav li a,.header .nav li.on,.left_menu h3 span.on');
<?php echo '</script'; ?>
>
<![endif]-->
</head>
<body style="font-size:12px; padding-bottom:0; " onLoad="version_msg();">
<div id="sysinfobox" class="sysinfobox" style="display:none;">
	<?php echo '<script'; ?>
>
    	setTimeout("document.getElementById('sysinfobox').style.display='none'",10000);
    <?php echo '</script'; ?>
>
	<div class="sysinfoboxtop" id="sysinfoboxtop"><strong style="float:left;margin-left:10px;">��������</strong><span style="float:left;">(10����Զ��˳�)</span><span style="float:right;margin-right:10px;"><a href="#" onclick="javascript:document.getElementById('sysinfobox').style.display='none';">[�ر�]</a></span></div> 
</div>
<div style="height:455px;">
<div class="admin_index_center">
<div class="admin_message_left">
<div class="admin_message_left_cont">
<div class="admin_message_name"><span class="admin_message_up">��ã�</span><span class="admin_message_yun"><?php echo $_smarty_tpl->tpl_vars['nav_user']->value['name'];?>
</span><a  href="javascript:void(0)" onclick="layer_logout('index.php?m=index&c=logout');" class="admin_message_zh">[�����ʻ�]</a></div>
<div class="admin_message_login">���ĵ�½�ʻ���<strong><?php echo $_smarty_tpl->tpl_vars['nav_user']->value['username'];?>
</strong>
������ɫ��<strong><?php echo $_smarty_tpl->tpl_vars['nav_user']->value['group_name'];?>
</strong> �ϴε�¼ʱ�䣺<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['nav_user']->value['lasttime'],'%Y-%m-%d %H:%M:%S');?>
</div>
<div class="admin_message_jy">
    <?php if ($_smarty_tpl->tpl_vars['dirname']->value||$_smarty_tpl->tpl_vars['mruser']->value==1) {?><div>
        <?php if ($_smarty_tpl->tpl_vars['dirname']->value) {?>
     <p>ǿ�ҽ��齫 <?php echo $_smarty_tpl->tpl_vars['dirname']->value;?>
 �ļ�������Ϊ�������ƣ�
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['mruser']->value==1) {?>
       û�и���Ĭ�ϵĹ���Ա���ƺ�����!<a href="index.php?m=admin_user&c=pass">�������޸ġ�</a></p><?php }?>
        </div>
	<?php }?></div>
</div>
</div>

</div>
<div class="mainright">
    <div class="maininfo" style="height:180px">
    	<div class="mainboxtop"><h6>ϵͳ��Ϣ</h6></div>
        <div class="maincontent">
        <p style="float:left;">PHPYun����汾�� <?php echo $_smarty_tpl->tpl_vars['db_config']->value['version'];?>
 [ <div id="version_msg" style="float:left;">�������!</div>]</p>
		<p style="clear:both;">�����������<?php echo $_smarty_tpl->tpl_vars['soft']->value;?>
</p>
        <p>���ÿռ�(������)��<?php echo $_smarty_tpl->tpl_vars['kongjian']->value;?>
&nbsp;M</p>
		<p>MySQL �汾��<?php echo $_smarty_tpl->tpl_vars['banben']->value;?>
</p>
		<p>�û� - ��������<?php echo $_smarty_tpl->tpl_vars['yonghu']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['server']->value;?>
</p>
        </div>
    </div>
  </div>
</div>
<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
<?php echo '<script'; ?>
>
function clicktb(name){$("#tbrightMain").attr("src","index.php?m=admin_right&c="+name);}
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="http://init.phpyun.com/site.php?site=<?php echo $_smarty_tpl->tpl_vars['base']->value;?>
">//�˴���ΪԶ�̻�ȡ������֪ͨ���벻Ҫɾ��<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
