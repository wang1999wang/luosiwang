<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-28 08:02:34
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_evaluate_examup.htm" */ ?>
<?php /*%%SmartyHeaderCode:262375608839a266704-86529187%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e67808275754a1bf583fa083fb311f4c99e7bca' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_evaluate_examup.htm',
      1 => 1435283202,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '262375608839a266704-86529187',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'info' => 0,
    'group_all' => 0,
    'v' => 0,
    'ask' => 0,
    'fullscore' => 0,
    'key' => 0,
    'pytoken' => 0,
    'value' => 0,
    'k' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5608839b3cdd25_72243297',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5608839b3cdd25_72243297')) {function content_5608839b3cdd25_72243297($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="images/reset.css" rel="stylesheet" type="text/css" />
<link href="images/system.css" rel="stylesheet" type="text/css" />
<link href="images/table_form.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
> var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 charset="utf-8" src="../js/kindeditor/kindeditor-min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 charset="utf-8" src="../js/kindeditor/lang/zh_CN.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="../js/kindeditor/themes/default/default.css" />
<?php echo '<script'; ?>
 src="js/admin_public.js" language="javascript" type="text/javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 language="javascript" type="text/javascript">
KindEditor.ready(function(K) {
	var editor = K.editor({
		allowFileManager : false
	}); 
	K('#insertfile').click(function() {
		editor.loadPlugin('images', function() {
			editor.plugin.imageDialog({
				imageUrl : K('#pic_url').val(),
				clickFn : function(url, title, width, height, border, align) {
					K('#pic_url').val(url);
					K('#news_pic').html(url);
					editor.hideDialog();
				}
			});
		});
	});
});
  
//���ѡ�� ��ť
function createOption(tableNameId){
	//�Ȼ�ȡ��������ѡ��ĸ���
	var optionArray = $("input[name='option["+tableNameId+"][]']");
	var optionId = Number(optionArray.length)+1;
	var oTr=
		'<tr>'
			+'<th>ѡ��'+optionId+'��</th>'
			+'<td><input type="text" name="option['+tableNameId+'][]" size="50" class="input-text"/>��ֵ��<input type="text" name="score['+tableNameId+'][]" class="input-text" size="5"/></td>'
		+'</tr>'
	$("#actionTr"+tableNameId).before(oTr);
	$("#delOption"+tableNameId).css({opacity: "1",filter: "alpha(opacity=100)"});
}

//ɾ��ѡ�� ��ť
function delOption(tableNameId){
	var optionArray = $("input[name='option["+tableNameId+"][]']");
	var scoreArray = $("input[name='score["+tableNameId+"][]']");
	if(Number(optionArray.length)==Number(scoreArray.length) && Number(optionArray.length) > 1){
		$("#actionTr"+tableNameId).prev().remove();
	}else{
		$("#delOption"+tableNameId).css({opacity: "0.4",filter: "alpha(opacity=40)"});
	}
}

//ɾ������ ��ť
//�ڿͻ�����������ɾ����������
function delQuestion(tableNameId){
	$("table[name='tQuestion["+tableNameId+"]']").remove();
	$(".showAddQuestionBtn").show();
}

$(document).ready(function() {
	/*��� �������*/
    $(".showAddQuestionBtn").click(function(){
		if($("#divSeparat").prev().attr("name")){var tableNameId=Number(($("#divSeparat").prev().attr("name")).match(/\d+/g))+1; }else{var tableNameId=1;}
		var quesId = Number($("table[name^='tQuestion']").length)+1;
		var tpl=
		'<table name="tQuestion['+tableNameId+']" class="table_form" width="100%" style="border: 1px solid;">'
      		+'<tr>'
            	+'<th width="120" name="th_que_id">���� '+quesId+'��</th>'
                +'<td>'
                	+'<textarea name="question['+tableNameId+']" rows="2" cols="100"></textarea> '
                    +'<input id="createOption'+tableNameId+'" type="button" name="createOption'+tableNameId+'" value="���ѡ��" class="admin_submit4" onclick="createOption('+tableNameId+')"/> '
                	+'<input id="delOption'+tableNameId+'" type="button" name="delOption'+tableNameId+'" value="ɾ��ѡ��" class="admin_submit4" onclick="delOption('+tableNameId+')"/> '
                    +'<input id="delQuestion'+tableNameId+'" type="button" name="delQuestion'+tableNameId+'" value="ɾ������" class="admin_submit4" onclick="delQuestion('+tableNameId+')"/> '
					+'<input id="saveNewQuestion'+tableNameId+'" type="button" name="saveNewQuestion'+tableNameId+'" value="�������" class="admin_submit4" onclick="saveNewQuestion('+tableNameId+')"/> '
                +'</td>'
            +'</tr>'
            +'<tr>'
            	+'<th>ѡ��1��</th>'
                +'<td><input type="text" name="option['+tableNameId+'][]" size="50" class="input-text"/>��ֵ��<input type="text" name="score['+tableNameId+'][]" class="input-text" size="5"/></td>'
            +'</tr>'
             +'<tr>'
            	+'<th>ѡ��2��</th>'
                +'<td><input type="text" name="option['+tableNameId+'][]" size="50" class="input-text"/>��ֵ��<input type="text" name="score['+tableNameId+'][]" class="input-text" size="5"/></td>'
            +'</tr>'
            +'<tr id="actionTr'+tableNameId+'">'
        	+'</tr>'
         +'</table>';
		 
		 $("#divSeparat").before(tpl);		
		 $(".showAddQuestionBtn").hide();

	}); 
	
	/*���� ��ֵ Ϊ����*/
	$("input[name^='score']").live("keyup",function(){
		//this.value = this.value.replace(/([\D]+)|^([0].+)|(^[^1][\d]{2,})|(^[1][^0][^0])|(^[1][0][^0])|(^[1][^0][0])|([\d]{4,})/igm,"");
		setNumber(this);
	});
	 
	/*�������*/
	$(".newcommentbtn").click(function(){
		var newtr = '<tr>'
				+'<th>�ɼ���</th>'
				+'<td>'
            	+'<input type="text" size="4" class="input-text" name="fromscore[]" />�ֵ�'
                +'<input type="text" size="4" name="toscore[]" class="input-text"/>��'
				+'</td>'
            	+'<td>���</td>'
            	+'<td><textarea name="comment[]" cols="80" rows="3"></textarea></td></tr>';
		$("#newCommentTr").before(newtr);
		$("input[name='delcomment']").css({opacity: "1",filter: "alpha(opacity=100)"});
	});
	
	/*ɾ������*/
	$(".delcommentbtn").click(function(){
		var commentSet=$("input[name='fromscore[]']");
		if(commentSet.length<=2){
			parent.layer.msg('��ɾ��û������',2,8);return false;
			//$(".delcommentbtn").css({opacity: "0.4",filter: "alpha(opacity=40)"});
		}else{
			$("#newCommentTr").prev().remove();
		}
	});
	/*���� ���������� Ϊ����*/
	$("input[name='fromscore[]']").live("keyup",function(){setNumber(this);});
	$("input[name='toscore[]']").live("keyup",function(){setNumber(this);	});
	$("input[name='sort']").live("keyup",function(){ this.value = this.value.replace(/([\D]+)|^([0].+)/igm,"");});
	
}); 
 
/*���÷�ֵΪ��λ��������*/
function setNumber(obj){obj.value=obj.value.replace(/([\D]+)|^([0].+)|([\d]{4,})/igm,"");};

/*������⣬�༭�޸�*/
function editquestion(id){
	$("table[name='lookQuestion["+id+"]']").hide();
	$("table[name='tQuestion["+id+"]']").show();
}
/*�����޸�����*/
function abandonSave(id){
	$("table[name='lookQuestion["+id+"]']").show();
	$("table[name='tQuestion["+id+"]']").hide();
}

/*���¸���*/
function saveQuestion(id){
	var questid = id;
	var question = $("textarea[name='question["+id+"]']").val();
	var option_arr = $("input[name='option["+id+"][]']");
	var option=new Array();
	var score_arr = $("input[name='score["+id+"][]']");
	var score=new Array();
	for(var i=0; i<option_arr.length; i++){
		if(option_arr[i].value){
			option[i] = option_arr[i].value;
		}
		if(score_arr[i].value){
			score[i] = score_arr[i].value;
		} 
	}
	if(question==''||option==''||score==''){
		layer.msg("���⡢�𰸡���ֵ������Ϊ�գ���",2,2);return false;
	} 
	var url="index.php?m=admin_evaluate&c=ajaxsave";
	var sendinfo={
		questid:questid,
		question:question,
		option:option,
		score:score,
		status:"up",
		pytoken:$("#pytoken").val()
	};
	loadlayer();
	$.post(url,sendinfo,function(data){
		parent.layer.closeAll();
		if(data!=1){config_msg(data);}else{location.reload();}
	});
}
  
/*�������*/
<?php if ($_smarty_tpl->tpl_vars['info']->value['id']) {?>
function saveNewQuestion(tableNameId){
	var examid = <?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
;
	var question = $.trim($("textarea[name='question["+tableNameId+"]']").val());
	var option_arr = $("input[name='option["+tableNameId+"][]']");
	var score_arr = $("input[name='score["+tableNameId+"][]']");
	var option = new Array();
	var score = new Array();
	for(var i=0; i<option_arr.length; i++){
		option[i] = option_arr[i].value;
		score[i] = score_arr[i].value;
	};
	var url="index.php?m=admin_evaluate&c=ajaxsave";
	var sendinfo={
		examid:examid,
		question:question,
		option:option,
		score:score,
		status:"savenewquestion",
		pytoken:$("#pytoken").val()
	};
	loadlayer();
	$.post(url,sendinfo,function(data){
		parent.layer.closeAll();
		if(data!=1){config_msg(data);}else{location.reload();}
	});
} 
<?php }?> 
function checkform(){
	var examtitle=$.trim($("#examtitle").val());
	var pic_url=$.trim($("#pic_url").val());
	var selectgroup=$.trim($("#selectgroup").val());
	var description=$.trim($("#description").val());
	parent.layer.closeAll();
	if(pic_url==''){
		layer.msg('��ѡ��ͼƬ��',2,2);return false;
	}
	if(description==''){
		layer.msg('��ѡ��������飡',2,2);return false;
	}
	if(examtitle==''){
		layer.msg('����д�������ƣ�',2,2);return false;
	}
}
<?php echo '</script'; ?>
>
<title>��̨����</title>
</head>
<body class="body_ifm">

<div class="infoboxp">
<div class="infoboxp_top_bg"></div>
 
  <div class="infoboxp_top">
     <span class="admin_title_span">�޸Ĳ����Ծ�</span>
        <a href="index.php?m=admin_evaluate" class="admin_infoboxp_nav admin_infoboxp_gl">�����б�</a>
          <em class="admin-tit_line"></em>
        <a href="index.php?m=admin_evaluate&c=group" class="admin_infoboxp_nav admin_infoboxp_lb">������</a>
  </div>
  <div class="clear"></div>
  <div class="admin_table_border">
    <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"> </iframe>
   <form name="myform" target="supportiframe" action="index.php?m=admin_evaluate&c=examupsave" method="post" onsubmit="return checkform();"> 
      <table class="table_form" width="100%">
		<tr>
			<th width="120">����ͼ��</th>
			<td colspan="3">  
				<span id='news_pic'><?php echo $_smarty_tpl->tpl_vars['info']->value['pic'];?>
</span>	
				<input type="hidden" class="input-text" name="uplocadpic" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['pic'];?>
" id='pic_url'/>
				<input   type="button" id="insertfile" value="ѡ��ͼƬ" />
			</td>
		</tr>
		<?php if ($_smarty_tpl->tpl_vars['info']->value['pic']) {?> 		
		<tr>
			<th width="120">��ʹ��ͼƬ��</th>
			<td colspan="3">  
				<img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['info']->value['pic'];?>
" width='200' height='100'/>
			</td>
		</tr> 
		<?php }?> 
        <tr>
          <th width="120">�����Ծ���飺</th>
          <td colspan="3">
          	<select name="selectgroup"  id="selectgroup">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group_all']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['info']->value['keyid']==$_smarty_tpl->tpl_vars['v']->value['id']) {?> selected="selected" <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                <?php } ?>
            </select>
          </td>
        </tr> 
      	<tr>
        	<th width="120">�����Ծ����ƣ�</th>
            <td colspan="4"><input type="text" id="examtitle" name="examtitle" class="input-text" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
"/> <label style="font-size:20px; color:red;">��<?php echo count($_smarty_tpl->tpl_vars['ask']->value);?>
���⣬<?php echo $_smarty_tpl->tpl_vars['fullscore']->value;?>
��</label></td>
        </tr>  
		<tr>
			<th width="120">�Ծ�����</th>
			<td colspan="3"> 
				<input type="text" name="sort"  size="5" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['sort'];?>
" class="input-text" />
			</td>
		</tr> 
		<tr>
			<th width="120">�Ծ����ԣ�</th>
			<td colspan="3">
				<input id="top" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['info']->value['top']=='1') {?>checked="checked"<?php }?> value="1" name="top">
				<label for="top">��ҳ�õ�</label>
				<input id="hot" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['info']->value['hot']=='1') {?>checked="checked"<?php }?> value="1" name="hot">
				<label for="hot">ͷ��</label>
				<input id="recommend" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['info']->value['recommend']=='1') {?>checked="checked"<?php }?> value="1" name="recommend">
				<label for="recommend">�Ƽ�</label> 
			</td> 
		</tr> 
          <tr>
              <th  width="120">�衡������</th>
              <td colspan="3"><textarea name="description" cols="100" rows="3" id='description'><?php echo $_smarty_tpl->tpl_vars['info']->value['description'];?>
</textarea>
              </td>
          </tr>
		  <tr><td colspan="4"> 
			<span style="float:left"><font style="color:#3a6ea5;">�������</font> </span>
			<span style="float:left;margin-left:20px;">
			<a class="admin_infoboxp_nav admin_infoboxp_tj newcommentbtn" href="javascript:void(0)">�������</a> 
			<a class="admin_infoboxp_nav admin_infoboxp_sc delcommentbtn" href="javascript:void(0)">ɾ������</a>  
			</span>
		  </td></tr> 
      <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['info']->value['fromscore']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
	  <tr>
		  <th width="120">�ɼ���</th>
		  <td width="140">
			  <input type="text" class="input-text" size='4' name="fromscore[]" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['fromscore'][$_smarty_tpl->tpl_vars['key']->value];?>
"/>�ֵ�<input type="text" name="toscore[]" class="input-text" size='4' value="<?php echo $_smarty_tpl->tpl_vars['info']->value['toscore'][$_smarty_tpl->tpl_vars['key']->value];?>
"/>��
		   </td>
		   <td>���</td>
		  <td>
			<textarea name="comment[]" cols="80" rows="3"><?php echo $_smarty_tpl->tpl_vars['info']->value['comment'][$_smarty_tpl->tpl_vars['key']->value];?>
</textarea>
			
		  </td>
	  </tr> 
      <?php } ?>
		<tr id="newCommentTr"> 
		  <td colspan='3'></td>
			  <td>
				<?php if ($_smarty_tpl->tpl_vars['info']->value['id']) {?>	
				  <input type="submit" value="����" name="submit" class="admin_submit4"/> 
				  <?php } else { ?>	
				  <input type="submit" value="��һ��" name="submit" class="admin_submit4"/> 
				  <?php }?>	
			  </td>
		</tr>
      </table>    
      <input id="pytoken" type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
      <input type="hidden" name="examid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
">      
	</form>   
		<div class='table_form' style="padding: 10px 0 10px 6px;background: #f1f1f1 none repeat scroll 0 0;float:left;width:100%">
			<span style="float:left"><font style="color:#3a6ea5;">��Ŀ����</font> </span>
			<span style="float:left;margin-left:20px;">
			<a class="admin_infoboxp_nav admin_infoboxp_tj showAddQuestionBtn" href="javascript:void(0)">�����Ŀ</a>   
			</span>
		</div>     
      <!--������� ����-->
      <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ask']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
		<table id="lookQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" name="lookQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" class="table_form" width="100%" style=" border:1px solid;">
      		<tr>
            	<th width="120">���⡡<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
��</th>
                <td><?php echo $_smarty_tpl->tpl_vars['value']->value['question'];?>
 </td>
                <td width="240"><input type="button" value="�޸ĸ���" onClick="editquestion(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)"/></td>
            </tr>
            <!--ѡ��ͷ�ֵ-->
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <tr style="display:none;" >
            	<th>ѡ��<?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
��</th>
                <td><?php echo $_smarty_tpl->tpl_vars['ask']->value[$_smarty_tpl->tpl_vars['key']->value]['option'][$_smarty_tpl->tpl_vars['k']->value];?>
</td>
                <td>��ֵ��(<?php echo $_smarty_tpl->tpl_vars['ask']->value[$_smarty_tpl->tpl_vars['key']->value]['score'][$_smarty_tpl->tpl_vars['k']->value];?>
��)</td>
            </tr>
            <?php } ?>
		</table>
   
      <!--�޸�����-->
		<table id="tQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" name="tQuestion[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" class="table_form hidden" width="100%" style=" border:1px solid; display:none;">
      		<tr>
            	<th width="120" name="th_que_id">���⡡<?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
��</th>
                <td>
                	<textarea id="textarea<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" name="question[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
]" rows="2" cols="100"><?php echo $_smarty_tpl->tpl_vars['value']->value['question'];?>
</textarea>
                    <input id="createOption<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="button" name="createOption<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="���ѡ��" class="admin_submit4" onclick="createOption(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)"/>
                	<input id="delOption<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="button" name="delOption<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="ɾ��ѡ��" class="admin_submit4" onclick="delOption(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)"/>
                    <input id="delQuestion<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="button" name="delQuestion<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="ɾ������" class="admin_submit4" onclick="layer_del('ȷ��Ҫɾ����', 'index.php?m=admin_evaluate&c=delquestion&qid=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
');" />
                    <input id="saveQuestion<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="button" name="saveQuestion<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="���¸���" class="admin_submit4" onclick="saveQuestion(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)"/>
                    <input id="abandonSave<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" type="button" name="abandonSave<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="�����޸�" class="admin_submit4" onclick="abandonSave(<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
)"/>
                </td>
            </tr>
            <!--ѡ��ͷ�ֵ-->
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['value']->value['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <tr>
            	<th>ѡ��<?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
��</th>
                <td><input type="text"  class="input-text" name="option[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
][]" value="<?php echo $_smarty_tpl->tpl_vars['ask']->value[$_smarty_tpl->tpl_vars['key']->value]['option'][$_smarty_tpl->tpl_vars['k']->value];?>
" size="50"/>��ֵ��<input type="text" name="score[<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
][]" value="<?php echo $_smarty_tpl->tpl_vars['ask']->value[$_smarty_tpl->tpl_vars['key']->value]['score'][$_smarty_tpl->tpl_vars['k']->value];?>
" size='5' class="input-text"/>
				</td>
            </tr>
            <?php } ?>
            <tr id="actionTr<?php echo $_smarty_tpl->tpl_vars['ask']->value[$_smarty_tpl->tpl_vars['key']->value]['id'];?>
"></tr>
      </table>
      <?php } ?> 
      <div id="divSeparat"></div>
      <table  class="table_form" width="100%"  height="50px" style="border-top: 1px solid black;">
			<tr >
          		<td colspan="2" align="center">
                </td>
        	</tr>
      </table>
      <input id="pytoken" type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
"> 
      <input type="hidden" name="examid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
">
   </div>
</div> 
<div id="divExamInfo" style="position: fixed; text-align: center; bottom: 15px; font-size: 14px; cursor: pointer; right: 40px; border: 2px solid red; padding:5px; background-color: white; width:84px;">
    <table>
    	<tr><td>���⣺</td><th><?php echo count($_smarty_tpl->tpl_vars['ask']->value);?>
��</th></tr>
        <tr><td>�ܷ֣�</td><th><?php echo $_smarty_tpl->tpl_vars['fullscore']->value;?>
��</th></tr>
    </table>
</div>

</body>
</html><?php }} ?>
