<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-10-03 21:50:32
         compiled from "E:\WWW\luosiwang\app\template\admin\admin_link_add.htm" */ ?>
<?php /*%%SmartyHeaderCode:20128560fdd28a1fb15-34147784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '023f520da6d88c87fc07d2576b19c207f756fc49' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\admin\\admin_link_add.htm',
      1 => 1443880218,
      2 => 'file',
    ),
    'c7dbd406038454f5fedad410c70ea02973487dcd' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\\\app\\template\\admin\\rooter.htm',
      1 => 1443880088,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20128560fdd28a1fb15-34147784',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560fdd29706e68_40079014',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560fdd29706e68_40079014')) {function content_560fdd29706e68_40079014($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        

        
        <title>后台管理</title>
        
        
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
    function check_link(id) {
        if (id == 2) {
            $("#photo").show();
            $(".pic").show();
        }
        if (id == 1) {
            $("#photo").hide();
            $(".pic").hide();
        }
    }
    function photo_change(id) {
        if (id == 1) {
            $("#image1").show();
            $("#image2").hide();
        }
        if (id == 2) {
            $("#image1").hide();
            $("#image2").show();
        }
    }
    function checkform(myform) {
        if (myform.title.value == "") {
            parent.layer.msg('请填写链接标题！', 2, 2);
            return (false);
        }
        if (myform.url.value == "") {
            parent.layer.msg('请填写链接地址！', 2, 2);
            return (false);
        }
    }
    $(document).ready(function () {
        $("#did").click(function () {
            var checked = $("#did").attr("checked");
            if (checked == "checked") {
                $(".did").attr("checked", "checked");
            } else {
                $(".did").attr("checked", false);
            }
        })
        $(".did").click(function () {
            if (document.getElementById('did').checked) {
                document.getElementById('did').checked = document.getElementById('did').checked & 0;
            }
        })
    })
<?php echo '</script'; ?>
>

        
        <link href="images/reset.css" rel="stylesheet" type="text/css" />
        <link href="images/system.css" rel="stylesheet" type="text/css" />
        <link href="images/table_form.css" rel="stylesheet" type="text/css" />
        
        

    </head>

    <body class="body_ifm">

        
<div class="infoboxp">
    <div class="infoboxp_top_bg"></div>
    <div class="admin_Prompt">
        <div class="admin_Prompt_span">
            注意：添加链接时，请正确选择链接类型。
        </div>
        <div class="admin_Prompt_close"></div>
    </div>

    <div class="infoboxp_top">
        <h6>添加链接</h6>
        <a href="index.php?m=link" class="infoboxp_tj">友情链接列表</a>
    </div>
    <div class="admin_table_border">
        <iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
        <form name="myform" target="supportiframe" action="index.php?m=link&c=save" method="post" enctype="multipart/form-data" onsubmit="return checkform(this);">
            <input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
            <table width="100%" class="table_form" style="background:#fff;">
                <tr>
                    <th width="120">链接类型：</th>
                    <td>
                        <select name="type" onchange="check_link(this.value);">
                            <option value="1" <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['link_type']==1) {?>selected<?php }?>>文字链接</option>
                            <option value="2" <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['link_type']==2) {?>selected<?php }?>>图片链接</option>
                        </select>
                    </td>
                </tr>
                <tr class="admin_table_trbg">
                    <th width="120">链接标题：</th>
                    <td>
                        <input class="input-text" type="text" name="title" size="40" value="<?php echo $_smarty_tpl->tpl_vars['linkrow']->value['link_name'];?>
" />
                        <font color="gray">例：phpyun</font>
                    </td>
                </tr>
                <tr>
                    <th width="120">链接地址：</th>
                    <td>
                        <input class="input-text" type="text" name="url" size="30" value="<?php echo $_smarty_tpl->tpl_vars['linkrow']->value['link_url'];?>
" />
                        <font color="gray">例：http://www.phpyun.com</font>
                    </td>
                </tr>
                <tr>
                    <th>使用范围：</th>
                    <td><input type="button" value="<?php if ($_smarty_tpl->tpl_vars['domainname']->value!=" ") {
echo $_smarty_tpl->tpl_vars['domainname']->value;
} else { ?>全站<?php }?>" class="city_news_but" onclick="domain_show();"></td>
                </tr>
                <tr>
                    <th width="120">站点下使用范围：</th>
                    <td>
                        <select name="tem_type">
                            <option value='1' <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['tem_type']==1) {?>selected<?php }?>>全站使用</option>
                            <option value="2" <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['tem_type']==2) {?>selected<?php }?>>仅在首页使用</option>
                        </select>
                    </td>
                </tr>
                <tr id="photo" <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['link_type']!=2) {?>style="display:none;"<?php }?>>
                <th width="120">缩 略 图：</th>
                <td>
                    <input type="radio" name="phototype" value="1" onclick="photo_change(this.value)"
                           <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['img_type']==1) {?>checked<?php }?>/> 上传图片 &nbsp;
                    <input type="radio" name="phototype" value="2" onclick="photo_change(this.value)" <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['img_type']==2) {?>checked<?php }?>/> 远程图片
                    <br />
                    <div style="height:10px;"></div>
                    <div id="image1" <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['img_type']!="1") {?>style="display:none"<?php }?>>
                    <input name="uplocadpic" type="file" size="40" class="input-text" />例：http://www.phpyun.com/yun.jpg
    </div>
    <div id="image2" <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['img_type']!="2") {?>style="display:none"<?php }?>>
    <input name="uplocadpic" type="text" size="40" value="<?php echo $_smarty_tpl->tpl_vars['linkrow']->value['pic'];?>
" class="input-text" />
    例：http://www.hr135.com/yun.jpg
</div>
		</td>
	</tr>
    <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['link_type']==2) {?>
        <?php if ($_smarty_tpl->tpl_vars['linkrow']->value['img_type']==1) {?>
<tr class="pic">
    <th width="120">图片预览：</th>
    <td><img src="../<?php echo $_smarty_tpl->tpl_vars['linkrow']->value['pic'];?>
" width="150" height="80" /></td>
</tr>
        <?php } elseif ($_smarty_tpl->tpl_vars['linkrow']->value['img_type']==2) {?>
<tr class="pic">
    <th width="120">图片预览：</th>
    <td><img src="<?php echo $_smarty_tpl->tpl_vars['linkrow']->value['pic'];?>
" width="150" height="80" /></td>
</tr>
        <?php }?>
	<?php }?>
<tr class="admin_table_trbg">
    <th width="120">排序：</th>
    <td>
        <input class="input-text" type="text" name="sorting" size="20" value="<?php echo $_smarty_tpl->tpl_vars['linkrow']->value['link_sorting'];?>
" />
        <font color="gray">例：大前小后</font>
    </td>
</tr>
<tr>
    <td align="center" colspan="2">
        <?php if (is_array($_smarty_tpl->tpl_vars['linkrow']->value)) {?>
        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['linkrow']->value['id'];?>
" />
        <input type="hidden" name="lasturl" value="<?php echo $_smarty_tpl->tpl_vars['lasturl']->value;?>
">
        <input class="admin_submit4" type="submit" name="link_update" value="&nbsp;修 改&nbsp;" />
        <?php } else { ?>
        <input class="admin_submit4" type="submit" name="link_add" value="&nbsp;添 加&nbsp;" />
        <?php }?>
        <input class="admin_submit4" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" />
    </td>
</tr>
</table>
</form>
</div></div>
<div id="domainlist" style="display:none;">
    <div class="fz_city_news_cont" style="padding:10px;">
        <span class="fz_city_news"><label class="fz_label"><input type="radio" name="did" onclick="check_domain('全站')" value="0" checked class="fz_city_news_check">全站</label></span>
        <?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['domain']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
        <span class="fz_city_news"><label class="fz_label"><input type="radio" name="did" onclick="check_domain('<?php echo $_smarty_tpl->tpl_vars['list']->value['title'];?>
')" <?php if ($_smarty_tpl->tpl_vars['list']->value['id']==$_smarty_tpl->tpl_vars['linkrow']->value['did']) {?>checked<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
" class="fz_city_news_check"><?php echo $_smarty_tpl->tpl_vars['list']->value['title'];?>
</label></span>
        <?php } ?>
    </div>
</div>


        

        

        

        

    </body>
</html><?php }} ?>
