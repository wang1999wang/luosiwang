<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-28 08:02:37
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_evaluate_group.htm" */ ?>
<?php /*%%SmartyHeaderCode:22125608839d478264-15718825%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1cbab526e47048dc64fca068c4c8da83ecc6ec9a' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_evaluate_group.htm',
      1 => 1434528046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22125608839d478264-15718825',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'evaluate_group' => 0,
    'v' => 0,
    'key' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5608839d977d68_48695483',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5608839d977d68_48695483')) {function content_5608839d977d68_48695483($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="js/admin_public.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
> 
function check_form(){
	var classname = $.trim($("#classname").val());
	if(classname==""){ 
		parent.layer.msg("类别名称不能为空！",2,2);
		return false; 
	}
}	
function checksort(id){
	$("#sort"+id).hide();
	$("#input"+id).show();
	$("#input"+id).focus();
}	
function subsort(id){
	var sort=$("#input"+id).val();
	var pytoken=$("#pytoken").val(); 
	$.post("index.php?m=admin_evaluate&c=ajax",{id:id,sort:sort,pytoken:pytoken},function(data){
		$("#sort"+id).html(sort);
		$("#sort"+id).show();
		$("#input"+id).hide();
		if(data!=1){config_msg(data);}else{location.reload();}
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
	$.post("index.php?m=admin_evaluate&c=ajax",{id:id,name:name,pytoken:pytoken},function(data){
		$("#name"+id).html(name);
		$("#name"+id).show();
		$("#inputname"+id).hide();
		if(data!=1){config_msg(data);}else{location.reload();}
	})
}
function change_f(){
	var f_id=$("#f_id").val();
	if(f_id=='0'){
		$("#is_rec").show();
	}else{$("#is_rec").hide();} 
}

<?php echo '</script'; ?>
>
<title>后台管理-测评类别管理</title>
</head>
<body class="body_ifm">
<iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>


<!--添加类别 弹窗-->
<div id="houtai_div" style=" width:298px; display:none;">
	<form name="myform" target="supportiframe" action="index.php?m=admin_evaluate&c=addgroup" method="post" onSubmit="return check_form();">
		<table class="table_form "style="width:100%">
			<tbody>
				<tr class="ui_td_11">
					<td style="text-align: right;" class="ui_content_wrap">类别名称：</td>
					<td><input type="text" name="classname" value=""  class="input-text" id="classname"/></td>
				</tr>
				<tr class="ui_td_11">
					<td  class="ui_content_wrap" colspan='2' style="border-bottom:none"><input class="admin_submit4" type="submit" name="sub" value=" 添加 "  /></td>
				</tr> 
			</tbody>
		</table>
		<input type="hidden" name="pytoken" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	</form>
</div>
<!--end div id="houtai_div"-->



<div class="infoboxp">

<div class="infoboxp_top_bg"></div>

<div class="infoboxp_top">
    <span class="admin_title_span">测评分类</span> 
    <em class="admin-tit_line"></em>
    <a href="javascript:void(0);" onClick="add_class('添加类别','300','130','#houtai_div','')" class="admin_infoboxp_nav admin_infoboxp_tj">添加类别</a>
    <em class="admin-tit_line"></em>
    <a href="index.php?m=admin_evaluate" class="admin_infoboxp_nav admin_infoboxp_gl">测评试卷列表</a>
    <em class="admin-tit_line"></em>
    <a href="index.php?m=admin_evaluate&c=examup" class="admin_infoboxp_nav admin_infoboxp_tj">添加试卷</a>
</div>

<div class="clear"></div>

<div class="table-list" style="min-height:300px;">
    <div class="admin_table_border">
        <?php if (empty($_GET['id'])) {?>

		<form action="index.php" name="myform" method="get" target="supportiframe" id='myform'>
			<input name="m" value="admin_evaluate" type="hidden"/>
			<input name="c" value="delgroup" type="hidden"/>
            
<!--测评类别列表-->
<table width="100%" style="text-align: center;">
<thead>
	<tr class="admin_table_top">
		<th>编号</th>
		<th width="200">类别名称<span class="clickup">(点击修改)</span></th>
        <th>记录数</th>
        <th>排序<span class="clickup">(点击修改)</span></th>
		<th class="admin_table_th_bg">操作</th>
	</tr>
</thead>
<tbody>
	    
	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['evaluate_group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
    <?php if ($_smarty_tpl->tpl_vars['v']->value['keyid']==0) {?>
	<tr align="center"<?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?>>
		<td><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
		<td class="ud"><span onClick="checkname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="name<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span>
        	<input class="input-text hidden" type="text" id="inputname<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" onBlur="subname('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" ></td>
		<td class="od">
		 共有试卷 <font color="#0033FF">
         <?php if ($_smarty_tpl->tpl_vars['v']->value['count']!=0) {?>
         	<?php echo $_smarty_tpl->tpl_vars['v']->value['count'];?>

         <?php } else { ?>
         	0
         <?php }?></font> 篇</td>
        <td><span onClick="checksort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" id="sort<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" style="cursor:pointer;"><?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
</span>
        	<input class="input-text hidden" type="text" id="input<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" size="10" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sort'];?>
" onBlur="subsort('<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" ></td>
		<td><a href="javascript:void(0)" class="admin_cz_sc" onClick="layer_del('删除该分组，将删除该分组下的所有的试卷，确定要删除吗？', 'index.php?m=admin_evaluate&c=delgroup&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');">删除</a></td>
	</tr>
    <?php }?>
	<?php } ?>
    <tr>
    	<td colspan="8" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
    </tr>
</table> 
<!--end 测评类别列表-->

		</form>
<?php }?>


</div>
<!--end div class="table-list"-->

</div> 
<!--end div class="infoboxp"-->
</body>
</html><?php }} ?>
