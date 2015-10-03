<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-03 10:13:24
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_userclass.htm" */ ?>
<?php /*%%SmartyHeaderCode:6389560f39c4338127-17802063%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5192ded1bbad72ab7e770f7e563eaa60523a523f' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_userclass.htm',
      1 => 1434528046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6389560f39c4338127-17802063',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'id' => 0,
    'position' => 0,
    'key' => 0,
    'v' => 0,
    'class1' => 0,
    'class2' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560f39c509c486_12700870',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560f39c509c486_12700870')) {function content_560f39c509c486_12700870($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
<?php echo '<script'; ?>
>
function checksort(id){
	$("#sort"+id).hide();
	$("#input"+id).show();
	$("#input"+id).focus();
}
function subsort(id){
	var sort=$("#input"+id).val();
	var pytoken=$("#pytoken").val();
	$.post("index.php?m=userclass&c=ajax",{id:id,sort:sort,pytoken:pytoken},function(data){
		$("#sort"+id).html(sort);
		$("#sort"+id).show();
		$("#input"+id).hide();
		if(data!='1'){config_msg(data);}else{location.reload();}
	})
}
function checkname(id){
	$("#name"+id).hide();
	$("#inputname"+id).show();
	$("#inputname"+id).focus();
}
function subname(id){
	var name=$("#inputname"+id).val();
	if($.trim(name)==""){
		parent.layer.msg("类别名称不能为空！",2,8,function(){location.reload();});return false;
	}
	var pytoken=$("#pytoken").val();
	$.post("index.php?m=userclass&c=ajax",{id:id,name:name,pytoken:pytoken},function(data){
		$("#name"+id).html(name);
		$("#name"+id).show();
		$("#inputname"+id).hide();
		if(data!='1'){config_msg(data);}else{location.reload();}
	})
}
<?php echo '</script'; ?>
>
<title>后台管理</title>
</head>
<body class="body_ifm">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['adminstyle']->value)."/add_class.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<span id="temp"></span>
<div class="infoboxp"><div class="infoboxp_top_bg"></div>
<div class="infoboxp_top">
<span class="admin_title_span">个人会员分类</span>
 <a  href="javascript:void(0)" onClick="add_class('个人会员分类','300','280','#wname','index.php?m=userclass&c=save')" class="admin_infoboxp_tj">添加类别</a>
</div>
<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
<div class="table-list">
<div class="admin_table_border">
<form action="index.php?m=userclass&c=del" method="post" id='myform' target="supportiframe">
<table width="100%">
	<thead>
	<tr class="admin_table_top">
        <th width="50"><label for="chkall"> <input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' /></label></th>
		<th width="60">分类编号</th>
        <th width="400">分类名称<span class="clickup">(点击修改)</span></th>
		<th>
		 <?php if (empty($_smarty_tpl->tpl_vars['id']->value)) {?>
		分类变量名
        <?php } else { ?>
        分类排序
        <?php }?>
		</th>
		<th width="180" class="admin_table_th_bg">操作</th>
	</tr>
	</thead>
	<tbody>
    <?php if (empty($_smarty_tpl->tpl_vars['id']->value)) {?>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['position']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
        <tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
            <td class="ud"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
            <td align="left">一级分类：<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
            <input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"></td>
            <td class="ud"><input type="text" name="variable" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['variable'];?>
" size="20" disabled/></td>
            <td class="ud">
            	<A href="index.php?m=userclass&c=up&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="admin_cz_sc">分类管理</A> | 
                <A href="javascript:void(0)" onClick="layer_del('确定要删除？', '?m=userclass&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_cz_sc">删除</A></td>
        </tr>
    	<?php } ?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['id']->value) {?>
	<tr align="center">
    	<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['class1']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
		<td class="ud" width="60"><?php echo $_smarty_tpl->tpl_vars['class1']->value['id'];?>
</td>
		<td align="left">一级分类：<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['class1']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['class1']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['class1']->value['name'];?>
</span>
        <input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['class1']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['class1']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['class1']->value['id'];?>
');"></td>
        <td class="ud"></td>
		<td class="ud" width="180"><A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=userclass&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['class1']->value['id'];?>
');"class="admin_cz_sc">删除</A></td>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['class2']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
	<tr align="center" id="msg<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
    	<td width="50"><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
		<td class="ud"><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗<span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
        <input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"></td>
        <td><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</span>
        <input class="input-text hidden" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
" onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"></td>
		<td class="ud"><A href="javascript:void(0)" onClick="layer_del('确定要删除？', 'index.php?m=userclass&c=del&delid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"class="admin_cz_sc">删除</A></td>
	</tr>

	<?php } ?>
	<?php }?>
  <tr style="background:#f1f1f1;">
    <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
    <td colspan="4" >
    <label for="chkAll2">全选</label>&nbsp;
      <input class="admin_submit4"  type="button" name="delsub" value="删除所选"  onclick="return really('del[]')"/></td>
    </tr>
	</tbody>
</table>
<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
</form>
</div>
</div>
</div>
</body>
</html><?php }} ?>
