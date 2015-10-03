<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-03 10:13:25
         compiled from "E:\WWW\luosiwang\\app\template\admin\add_class.htm" */ ?>
<?php /*%%SmartyHeaderCode:12903560f39c50e2991-02302797%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c242d07a111dce2f0a9c92579a5d2be821e2845' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\\\app\\template\\admin\\add_class.htm',
      1 => 1434528046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12903560f39c50e2991-02302797',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'position' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560f39c51d8b41_13408890',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560f39c51d8b41_13408890')) {function content_560f39c51d8b41_13408890($_smarty_tpl) {?><!--弹出框-->
<div id="wname"  style="display:none; width: 300px; "> 
	<div style="height: 160px;" class="job_box_div">  
	   <div class="job_box_inp">
		<table class="table_form "style="width:100%">
			<tr ><td colspan='2' class='ui_content_wrap'><input name='ctype' type='radio' value='1' checked='checked'>一级分类<input name='ctype' type='radio' value='2'>二级分类</td></tr>
			<tr class='sclass'  style="display:none;"><td style="text-align: right;">父类:</td><td><select name="nid" id='nid'> 
							 <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['position']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
							<?php } ?>
						</select> </td></tr>
			<tr><td style="text-align: right;">类别名称:</td><td><input type="text" name="position" id='position' class="input-text" /></td></tr>
			<tr class='variable ' ><td style="text-align: right;">调用变量名:</td><td><input type="text" name="variable" id='variable' class="input-text" size="16"/></td></tr> 
			<tr class='sclass'  style="display:none;"><td style="text-align: right;">排序:</td><td><input type="text" name="sort" id='sort' value="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" class="input-text" size="5" /></td></tr>		
			<tr><td colspan='2' class='ui_content_wrap' style="border-bottom:none"><input class="admin_submit4" type="button" value="添加 " onclick="save_class()"/></td></tr>
		</table> 
	   </div>
	</div>
</div> 

<!--弹出框end-->
<?php echo '<script'; ?>
 type="text/javascript"> 
$(document).ready(function(){
	$("input[name='ctype']").click(function(){
		var val=$(this).val();
		if(val=='1'){
			$(".variable").show();
			$(".sclass").hide();
		}else if(val=='2'){
			$(".variable").hide();
			$(".sclass").show();
		}
	})
})
function save_class(){
	var ctype=$('input[name="ctype"]:checked').val();
	var nid=$('#nid').val();
	var url=$('#surl').val();
	var position=$('#position').val();
	var variable=$('#variable').val();
	var sort=$('#sort').val();
	if(ctype==''||ctype==null){
		parent.layer.msg('请选择类型！', 2, 8);return false;
	}
	if($.trim(position)==''){
		parent.layer.msg('类别名称不能为空！', 2, 8);return false;
	}
	if(ctype=='1'&&$.trim(variable)==''){
		parent.layer.msg('调用变量名不能为空！', 2, 8);return false;
	}
	$.post(url,{ctype:ctype,nid:nid,position:position,variable:variable,sort:sort,pytoken:$('#pytoken').val()},function(msg){
		if(msg==1){
			parent.layer.msg('该类分类已存在！', 2, 8);return false;
		}else if(msg==2){
			parent.layer.msg('添加成功！', 2,9,function(){location=location ;});return false;
		}else{
			parent.layer.msg('添加失败！', 2,8,function(){location=location ;});return false;
		} 
	}); 
} 
<?php echo '</script'; ?>
><?php }} ?>
