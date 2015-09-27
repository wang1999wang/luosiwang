<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-28 07:35:10
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_cache.htm" */ ?>
<?php /*%%SmartyHeaderCode:1042456087d2e5ddb43-04323877%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2a75e397a681385255e2dd0497e52a485f764a8' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_cache.htm',
      1 => 1434528046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1042456087d2e5ddb43-04323877',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'type' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_56087d2e8faa03_46708017',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56087d2e8faa03_46708017')) {function content_56087d2e8faa03_46708017($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
<div class="admin_Prompt">
<div class="admin_Prompt_span">
    注意事项：
    生成请确保/plus,/cache目录有可写权限，否则无法生成。生成所有的类别，时间较长，建议分批更新
</div>
<div class="admin_Prompt_close"></div>
</div>
    <div class="infoboxp_top">
        <h6>生成缓存</h6>
    </div>
<div class="main_tag" >
<div class="tag_box">
<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
    <form action="index.php?m=cache&c=cache" target="supportiframe" method="post">
<table width="100%" class="table_form">
    <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      <tr>
    	<td class="ud" align="center" style="background-color: #ffffed;">
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <input type="checkbox" class="checkbox" name="cache[]" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" id="cache_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
            	<label for="cache_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</label>&nbsp;&nbsp;
            <?php } ?>
	   </td>
      </tr>
    <tr>
    	<td class="ud" align="center">
			<input class="admin_submit4" type="button" name="select" value="全选"/>&nbsp;&nbsp;
            <input class="admin_submit4" type="submit" name="madeall" value="更新"/>&nbsp;&nbsp;
        </td>
      </tr>
  </table>
 </form>
  </div></div></div>
  <div style="clear:both"></div>
  <?php echo '<script'; ?>
>
      var checked_all = false;
    $(document).ready(function(){
	    $("input[name=select]").click(function(){
	        var codewebarr = "";
	        checked_all = !checked_all;
		    $(".checkbox").each(function () {
		        $(this).attr("checked", checked_all);
		    });
	    })
	    $("input[name=madeall]").click(function(){
		    var codewebarr="";
		    $(".checkbox:checked").each(function(){
			    if(codewebarr==""){codewebarr=1;}else{codewebarr++;}
		    });
		    if(!codewebarr){
			    parent.layer.alert('至少选择一项', 8);
			    return false;
		    }
	    })
    })
    <?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
