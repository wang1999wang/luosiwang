<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-03 08:22:36
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_link_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:7232560f1fccc6b329-86989565%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56c2606ab8448ccd097ae484bc13e999def2aa76' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_link_list.htm',
      1 => 1434528046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7232560f1fccc6b329-86989565',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
    'linkrows' => 0,
    'key' => 0,
    'v' => 0,
    'pagenav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560f1fcd5fae33_47745560',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560f1fcd5fae33_47745560')) {function content_560f1fcd5fae33_47745560($_smarty_tpl) {?><?php if (!is_callable('smarty_function_searchurl')) include 'E:\\WWW\\luosiwang\\app\\include\\libs\\plugins\\function.searchurl.php';
if (!is_callable('smarty_modifier_date_format')) include 'E:\\WWW\\luosiwang\\app\\include\\libs\\plugins\\modifier.date_format.php';
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
>
$(document).ready(function(){
	$(".job_name").hover(function(){
		var job_name=$(this).attr('v'); 
		if($.trim(job_name)!=''){
			layer.tips(job_name, this, {guide: 1, style: ['background-color:#F26C4F; color:#fff;top:-7px', '#F26C4F']}); 
		} 
	},function(){
		var job_name=$(this).attr('v'); 
		if($.trim(job_name)!=''){
			layer.closeTips();
		} 
	});
	//�����򲿷�
		$(".status").click(function(){
  		var uid=$(this).attr("pid");
		var pytoken=$("#pytoken").val();
		var status=$(this).attr("status");
		$("#status_"+status).attr("checked",true);
		$("input[name=uid]").val(uid);
		status_div('�����û�','350','220');
	});
	$(".user_status").click(function(){
		var id=$(this).attr("pid");
		var status=$(this).attr("status");
		$("#status"+status).attr("checked",true);
		var pytoken=$("#pytoken").val();
		$("input[name=yesid]").val(id);
		$.layer({
			type : 1,
			title :'�����������', 
			closeBtn : [0 , true],
			border : [10 , 0.3 , '#000', true],
			area : ['350px','160px'],
			page : {dom :"#infobox2"}
		});
	});
	
	
	 
})
<?php echo '</script'; ?>
>
<title>��̨����</title>
</head>
<body class="body_ifm">
<div id="infobox2"  style="display:none; width: 350px; "> 
      <form action="index.php?m=link&c=status" target="supportiframe" method="post" id="formstatus">
	   <input name="yesid" type="hidden">
      <div class="admin_Operating_sh" style="margin:15px 10px 10px 10px;">
		<div class="admin_Operating_sh_h1" style="padding:5px;">��˲�����
        <label for="status0"><input type="radio" name="status" value="0" id="status0" >δ���</label>
        <label for="status1"><input type="radio" name="status" value="1" id="status1" >�����</label>
		</div>
		<div class="admin_Operating_sub" style="margin:15px 0 0 0;"> <input type="submit"  value='ȷ��' class="submit_btn ">
         <input type="button"  onClick="layer.closeAll();" class="cancel_btn" style="margin:5px 0 0 8px;" value='ȡ��'></div>
		</div>
		<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      </form> 
</div>
<div class="infoboxp">
<div class="infoboxp_top_bg"></div>
<div class="admin_Filter"> <span class="complay_top_span fl">���������б�</span>
  <form action="index.php" name="myform" method="get">
    <input name="m" value="link" type="hidden"/>
    <input name="status" value="<?php echo $_GET['status'];?>
" type="hidden"/>
    <span class="admin_Filter_span"> ���ӱ��⣺</span> 
    <input class="admin_Filter_search"  type="text" name="keyword"  size="25" style="float:left">
    <input class="admin_Filter_bth"  type="submit" name="news_search" value="����" style="float:left"/>
    <span class='admin_search_div'>
    <div class="admin_adv_search">
      <div class="admin_adv_search_bth">�߼�����</div>
    </div>
    </span> <a href="index.php?m=link&c=add" class="admin_infoboxp_tj">�������</a>
  </form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin/admin_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="table-list">
  <div class="admin_table_border">
    <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
    <form action="index.php?m=link&c=del" name="myform" method="post" id='myform' target="supportiframe">
      <input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      <table width="100%">
        <thead>
          <tr class="admin_table_top">
            <th><label for="chkall">
              <input type="checkbox" id='chkAll' onclick='CheckAll(this.form)' />
              </label></th>
            <th> <?php if ($_GET['t']=="id"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'id','m'=>'link','untype'=>'order,t'),$_smarty_tpl);?>
">���<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'id','m'=>'link','untype'=>'order,t'),$_smarty_tpl);?>
">���<img src="images/sanj2.jpg"/></a> <?php }?> </th>
            <th align="left">���ӱ���</th>
            <th align="left">���ӵ�ַ</th>
            <th align="left">ʹ�÷�Χ</th>
            <th> <?php if ($_GET['t']=="link_time"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'link_time','m'=>'link','untype'=>'order,t'),$_smarty_tpl);?>
">����ʱ��<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'link_time','m'=>'link','untype'=>'order,t'),$_smarty_tpl);?>
">����ʱ��<img src="images/sanj2.jpg"/></a> <?php }?> </th>
            <th>����</th>
            <th> <?php if ($_GET['t']=="link_sorting"&&$_GET['order']=="asc") {?> <a href="<?php echo smarty_function_searchurl(array('order'=>'desc','t'=>'link_sorting','m'=>'link','untype'=>'order,t'),$_smarty_tpl);?>
">����<img src="images/sanj.jpg"/></a> <?php } else { ?> <a href="<?php echo smarty_function_searchurl(array('order'=>'asc','t'=>'link_sorting','m'=>'link','untype'=>'order,t'),$_smarty_tpl);?>
">����<img src="images/sanj2.jpg"/></a> <?php }?> </th>
            <th>״̬</th>
            <th class="admin_table_th_bg" width="110">����</th>
          </tr>
        </thead>
        <tbody>
        
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['linkrows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
        <tr align="center"<?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?> id="list<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
          <td><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name='del[]' onclick='unselectall()' rel="del_chk" /></td>
          <td><span><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</span></td>
          <td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['link_name'];?>
</td>
          <td class="od" align="left"><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['link_url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['v']->value['link_url'];?>
</a></td>
          <td class="ud" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['d_title'];?>
</td>
          <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['link_time'],"%Y-%m-%d");?>
</td>
          <td> <?php if ($_smarty_tpl->tpl_vars['v']->value['link_type']==1) {?>��������<?php } else { ?>ͼƬ����<?php }?> </td>
          <td><?php echo $_smarty_tpl->tpl_vars['v']->value['link_sorting'];?>
</td>
          <td> <?php if ($_smarty_tpl->tpl_vars['v']->value['link_state']!=1) {?><span class="admin_com_noAudited">δ���</span><?php } else { ?><span class="admin_com_Audited">�����</span><?php }?></td>		  
          <td width="110"> <a href="javascript:void(0);" class="user_status admin_cz_sc"  pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" status="<?php echo $_smarty_tpl->tpl_vars['v']->value['link_state'];?>
">���</a>
		  | <a href="index.php?m=link&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"class="admin_cz_sc">�޸�</a> | <a href="javascript:void(0)" onClick="layer_del('ȷ��Ҫɾ����', 'index.php?m=link&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');" class="admin_cz_sc">ɾ��</a> </td>
        </tr>
        <?php } ?>
        <tr style="background: #f1f1f1;">
          <td align="center"><input type="checkbox" id='chkAll2' onclick='CheckAll2(this.form)' /></td>
          <td colspan="2" ><label for="chkAll2">ȫѡ</label>
            &nbsp;
            <input class="admin_submit4"  type="button" name="delsub" value="ɾ����ѡ"  onclick="return really('del[]')"/></td>
          <td colspan="7" class="digg"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</td>
        </tr>
        </tbody>
        
      </table>
    </form>
  </div>
</div>

</body>
</html>
<?php }} ?>
