<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-08-12 05:57:31
         compiled from "E:\WWW\eforklift\app\template\admin\leaveword_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:1359955ca6dd273daa2-01736295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48eb329c1e1d0e0a9746e1a6976a2fc4582585ea' => 
    array (
      0 => 'E:\\WWW\\eforklift\\app\\template\\admin\\leaveword_list.htm',
      1 => 1439330244,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1359955ca6dd273daa2-01736295',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55ca6dd335da57_28925212',
  'variables' => 
  array (
    'config' => 0,
    'property' => 0,
    'property_row' => 0,
    'pytoken' => 0,
    'adminnews' => 0,
    'key' => 0,
    'v' => 0,
    'pagenav' => 0,
    'propertys' => 0,
    'pv' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55ca6dd335da57_28925212')) {function content_55ca6dd335da57_28925212($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'E:\\WWW\\eforklift\\app\\include\\libs\\plugins\\function.searchurl.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="js/show_pub.js"><?php echo '</script'; ?>
>
<title>后台管理</title>
</head>
<body class="body_ifm">
<div id="property" style="display:none;">
  <form action="index.php?m=admin_cars&c=savepro" method="post" target="supportiframe">
    <table class="table_form ">
      <tr>
        <td style="width:500px; " class="ui_content_wrap">属性：</td>
        <td> <?php  $_smarty_tpl->tpl_vars['property_row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['property_row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['property']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['property_row']->key => $_smarty_tpl->tpl_vars['property_row']->value) {
$_smarty_tpl->tpl_vars['property_row']->_loop = true;
?>
          <input type="checkbox" name="describe[]" value="<?php echo $_smarty_tpl->tpl_vars['property_row']->value['value'];?>
"/>
          <?php echo $_smarty_tpl->tpl_vars['property_row']->value['name'];?>

          <?php } ?></td>
      </tr>
      <tr>
        <td style="width:500px; " class="ui_content_wrap">文章编号：</td>
        <td><input size="40" type="text" id="proid" name="proid" value="" class="input-text"></td>
      </tr>
      <input type="hidden" id="protype" name="type" value="">
      <tr>
        <td colspan='2' style="text-align:center"><input type="submit" value="确 定" name="submit" class="admin_submit4 "></td>
      </tr>
    </table>
    <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
  </form>
</div>
<div class="infoboxp">
  <div class="infoboxp_top_bg"></div>
  <div class="admin_Filter"> <span class="complay_top_span fl">留言列表</span>
    <form action="index.php" name="myform" method="get" >
      <input name="m" value="admin_cars" type="hidden"/>
      <input name="cate" value="<?php echo $_GET['cate'];?>
" type="hidden"/>
      <span class="admin_Filter_span">检索类型：</span>
      <div class="admin_Filter_text formselect"  did='dtype'>
        <input type="button" value="<?php if ($_GET['type']=='1'||$_GET['type']=='') {?>标题<?php } else { ?>作者<?php }?>" class="admin_Filter_but"  id="btype">
        <input type="hidden" id='type' value="<?php if ($_GET['type']) {
echo $_GET['type'];
} else { ?>1<?php }?>" name='type'>
        <div class="admin_Filter_text_box" style="display:none" id='dtype'>
          <ul>
            <li><a href="javascript:void(0)" onClick="formselect('1','type','标题')">标题</a></li>
            <li><a href="javascript:void(0)" onClick="formselect('2','type','作者')">作者</a></li>
          </ul>
        </div>
      </div>
      <input class="admin_Filter_search"  type="text" name="keyword"  size="25" style=" float:left">
      <input class="admin_Filter_bth"  type="submit" name="news_search" value="检索"/>
      <span class='admin_search_div'>
      
      </span>
    </form>
     </div>
  <?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <div class="table-list">
    <div class="admin_table_border">
      <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
      <form action="index.php" target="supportiframe" name="myform" method="get" id='myform'>
        <input name="m" value="leaveword" type="hidden"/>
        <input name="c" value="delnews" type="hidden"/>
        <table width="100%">
          <thead>
            <tr class="admin_table_top">
              <th style="width:20px;"><label for="chkall">
                  <input type="checkbox" id='chkAll'  onclick='CheckAll(this.form)'/>
                </label></th>
              <th width="70"> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'admin_cars','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'admin_cars','untype'=>'order,t'),$_smarty_tpl);?>
">编号<img src="images/sanj2.jpg"/></a> <?php }?> </th>
              <th width="130" align="left">姓名</th>
              <th width="50" align="left">性别</th>
              <th align="left">电话</th>
              <th> QQ/Email </th>
              <th width="120">留言时间</th>
              <th width="360"> 内容 </th>
              <th  class="admin_table_th_bg">操作</th>
            </tr>
          </thead>
          <tbody>
          
          <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['adminnews']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
          <tr align="center"<?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  name='del[]' onclick='unselectall()' rel="del_chk" /></td>
            <td align="left" class="td1" style="text-align:center;" width="70"><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
            <td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
            <td class="od" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['sex'];?>
</td>
            <td class="gd" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['phone'];?>
</td>
            <td class="td"><?php echo $_smarty_tpl->tpl_vars['v']->value['qq_email'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['create_time'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</td>
            <td><a href="javascript:void(0)" onClick="layer_del('确定要删除？','index.php?m=leaveword&c=delnews&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');"class="admin_cz_sc">删除</a></td>
          </tr>
          <?php } ?>
            <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
            <td colspan="3"><label for="chkAll2">全选</label>
              &nbsp;
              <input class="admin_submit4"  type="button" name="delsub" value="删除所选" onClick="return really('del[]')" />
              </td>
            <td colspan="6" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
          </tr>
            </tbody>
        </table>
        <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      </form>
    </div>
  </div>
</div>
<div id="houtai_div" style=" width:470px; display:none;">
  <div class="subnav">
    <div class="content-menu ib-a blue line-x">
      <form name="myform" action="index.php?m=admin_cars&c=property" target="supportiframe" method="post" onSubmit="return check_form(this);" style="padding:10px;">
        名称：
        <input type="text" id="nameid" name="name" class="input-text">
        调用标识：
        <input type="text" id="valueid" name="value" class="input-text" size="10">
        <input type="hidden" id="upid" name="id" value="">
        <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
        <input class="admin_submit4" name="submit" id="submit" type="submit" value="添加">
      </form>
      <table width="100%" class="table_form" style="text-align:center">
        <tr>
          <th style="text-align:center;" width="10%">编号</th>
          <th style="text-align:center;" width="30%">名称</th>
          <th style="text-align:center;" width="35%">调用标识</th>
          <th style="text-align:center;" width="20%">操作</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['pv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['propertys']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pv']->key => $_smarty_tpl->tpl_vars['pv']->value) {
$_smarty_tpl->tpl_vars['pv']->_loop = true;
?>
        <tr id="pro<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
">
          <td class="od"><?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
</td>
          <td class="od"><?php echo $_smarty_tpl->tpl_vars['pv']->value['name'];?>
</td>
          <td class="od"><?php echo $_smarty_tpl->tpl_vars['pv']->value['value'];?>
</td>
          <td class="od"><a href="javascript:;" onClick="update('<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['pv']->value['name'];?>
','<?php echo $_smarty_tpl->tpl_vars['pv']->value['value'];?>
');">修改</a> | <a href="javascript:layer_del('确定要删除？','index.php?m=admin_cars&c=delpro&id=<?php echo $_smarty_tpl->tpl_vars['pv']->value['id'];?>
');">删除</a></td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>
<?php echo '<script'; ?>
> 
function showdiv(div){
	$("#upid").val("");
	$("#nameid").val("");
	$("#valueid").val("");
	$.layer({
		type : 1,
		title :'属性管理', 
		offset: ['100px', ''], 
		closeBtn : [0 , true], 
		area : ['470px','auto'],
		page : {dom :"#"+div}
	}); 
} 
function update(id,name,value){
	$("#upid").val(id);
	$("#nameid").val(name);
	$("#valueid").val(value);
	$("#submit").val('修改');
}
function check_form(myform){
	if (myform.name.value==""){ 
		parent.layer.msg('请填写名称！', 2, 8); 
		myform.name.focus();
		return (false);
	}	
	if (myform.value.value==""){
		parent.layer.msg('请填写标识符！', 2, 8); 
		myform.name.focus();
		return (false);
	}	
}
function add_pro(){
	var codewebarr="";
	$("input[type='checkbox']:checked").each(function(){ //由于复选框一般选中的是多个,所以可以循环输出 
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	}); 
	if(codewebarr==""){ 
		parent.layer.msg('您必须选择一个或多个！', 2, 8);
	}else{
		$("#protype").val('add');$("#proid").val(codewebarr); 
		$.layer({
			type : 1,
			title : '批量设置属性',
			closeBtn : [0 , true], 
			offset : ['20%' , '30%'],
			border : [10 , 0.3 , '#000', true],
			area : ['350px','auto'],
			page : {dom : '#property'}
		});  
	}
}
function del_pro(){
	var codewebarr="";
	$("input[type='checkbox']:checked").each(function(){ //由于复选框一般选中的是多个,所以可以循环输出 
		if(codewebarr==""){codewebarr=$(this).val();}else{codewebarr=codewebarr+","+$(this).val();}
	}); 
	if(codewebarr==""){
		parent.layer.msg('您必须选择一个或多个！', 2, 8);
	}else{
		$("#protype").val('del'); 
		$("#proid").val(codewebarr); 
		$.layer({
			type : 1,
			title : '批量取消属性',
			closeBtn : [0 , true], 
			offset : ['20%' , '30%'],
			border : [10 , 0.3 , '#000', true],
			area : ['350px','auto'],
			page : {dom : '#property'}
		});  
	}
}
<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
