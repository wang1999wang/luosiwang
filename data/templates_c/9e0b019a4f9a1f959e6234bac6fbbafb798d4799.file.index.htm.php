<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-08-12 05:44:45
         compiled from "E:\WWW\eforklift\app\template\default\contact\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:958055ca6b00b43d15-01084608%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9e0b019a4f9a1f959e6234bac6fbbafb798d4799' => 
    array (
      0 => 'E:\\WWW\\eforklift\\app\\template\\default\\contact\\index.htm',
      1 => 1439329478,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '958055ca6b00b43d15-01084608',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_55ca6b013cdc74_41400355',
  'variables' => 
  array (
    'style' => 0,
    'config' => 0,
    'nav_list1' => 0,
    'one' => 0,
    'curr' => 0,
    'key' => 0,
    'two' => 0,
    'navlist_app' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55ca6b013cdc74_41400355')) {function content_55ca6b013cdc74_41400355($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	
<?php $_smarty_tpl->tpl_vars['curr'] = new Smarty_variable(6, null, 0);?>
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/css/tianjia.css" rel="stylesheet" type="text/css" />
 <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/jquery.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/jquery-1.10.2.min.js" ><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/common.js"><?php echo '</script'; ?>
>
</head>
<body>
<div class="header">
        <div class="header_in">
            <div id="vivo-airbox"></div>
            <div id="vivo-wrap">
                <div id="vivo-head">
                    <div class="vivo-search">
                        <div class="search-box">
                            <form action='/search' method='get' onSubmit="if ($.trim($(this).find('input').val()) == '') {alert('请输入关键词'); return false;} return true;"><input type="text" placeholder="如:E叉车租赁" name='q' class='data_q' autocomplete="off" /><button>搜索</button><a class="close"></a></form>
                            <div class="qk-results">
                                <ul></ul>
                                <div class="other-results"><a href="#">其他搜索结果</a></div>
                            </div>
                        </div>
                    </div><div class="wd">
                              <div class="vivo-nav cl" style="height:0px;">
                                  <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
" class="vivo-logo" title="vivo" style="background-image:none;"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/picture/logo.png" alt="E叉车租赁" /></a>
                                  <div id="menu">
                                      <ul>
                                          <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['nav_list1']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
                                          <li data-ref="<?php echo $_smarty_tpl->tpl_vars['one']->value['id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['curr']->value==$_smarty_tpl->tpl_vars['key']->value) {?>curr<?php }?>">
                                              <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['one']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</a>
                                              <ul class="sub_menu">
                                                  <?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['two']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one']->value['sonlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value) {
$_smarty_tpl->tpl_vars['two']->_loop = true;
?>
                                                  <li><a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['two']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['two']->value['name'];?>
</a></li>
                                                  <?php } ?>
                                              </ul>
                                          </li>
                                          <?php } ?>
                                      </ul>
                                  </div>
                                  <div class="search-user"><a href="#" class="search"><b></b></a></div>
                              </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<div class="fixed_r">
	<ul>
		<li>1</li>
		<li>2</li>
		<li>3</li>
		<li>4</li>
	</ul>
</div>
<div class="num_box">
	<div class="num lxwm-banner1" id="num_0 au1" ></div>
	<div class="num lxwm-banner2" id="num_1 au2" ></div>
	<div class="num lxwm-banner3" id="num_2 au3" ></div>
  <div class="num" id="num_3 au4"> 
  <div style="height:80px; width:100%;"> </div>
        <div class="area-sixth tianjia-one">
        	<div class="tianjia-two">
            <div class="areasix-wrap">
                <div class="areasix-top">
                    <div class="areasix-tit">
                        <span class="linebd"></span>
                        <strong>在线留言</strong>
                        <span class="linebd"></span>
                        <div class="clear"></div>
                    </div>
                    <span class="en">LEAVE A MESSAGE</span>
                </div>
                <div class="areasix-form">
                    <iframe id="supportiframe"  name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe> 
                    <form target="supportiframe"action="index.php?m=contact&c=save_leaveword" method="post" accept-charset="utf-8" class="" id="feedback" name="feedback" onSubmit="return vilidate()">
                        <div style="display:none">
                            <input type="hidden" name="_scfs" value="8160bf24666a2adcea7aae88f2a57160" />
                        </div>                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="90">姓&nbsp;&nbsp;&nbsp;&nbsp;名：</td>
                                <td class="form-inputfir"><input type="text" name="username" required></td>
                                <td colspan="2" class="form-inputthi">先生<input type="radio" name="sex" value="先生" checked required>女士<input type="radio" name="sex" required value="女士"></td>
                            </tr>
                            <tr>
                                <td colspan="4" height="10"></td>
                            </tr>
                            <tr>
                                <td>电&nbsp;&nbsp;&nbsp;&nbsp;话：</td>
                                <td class="form-inputfir"><input type="text" name="tel" required></td>
                                <td width="142" align="center">QQ/EMAIL：</td>
                                <td class="form-inputfir"><input type="text" name="email" required></td>
                            </tr>
                            <tr>
                                <td colspan="4" height="10"></td>
                            </tr>
                            <tr>
                                <td valign="top" height="80">留言：</td>
                                <td colspan="3" valign="top" class="form-text">
                                    <textarea name="content" id="content" class="mesfont" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" height="10"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3" height="45" class="form-inputfif">
                                    <input type="submit" value="提交留言">
                                </td>
                            </tr>
                        </table>
                    </form>

                </div>
                </div>
            </div>
        </div>
    
     <div class="footerall">
    <div class="footer">
        <div class="wd footer_allone">
            <p class="footer-nav">
                <?php  $_smarty_tpl->tpl_vars['navlist_app'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['navlist_app']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
global $db,$db_config,$config;include(PLUS_PATH."/menu.cache.php");$Navlist=array();
		if(is_array($menu_name)){
            eval('$paramer=array("item"=>"\'navlist_app\'","hovclass"=>"\'nav_list_hover\'","nid"=>"2","key"=>"\'key\'","nocache"=>"")
;');
			$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];
			foreach($menu_name[12] as $key=>$val){
				if($val['type']=='2'){
					if($config['sy_seo_rewrite']=="1" && $val[furl]!=''){
						$menu_name[12][$key][url] = $val[furl];
					}else{
						$menu_name[12][$key][url] = $val[url];
					}
					$menu_name[12][$key][navclass] = navcalss($val,$paramer[hovclass]);
				}
			}
			foreach($menu_name[1] as $key=>$value){
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value[furl]!=''){
						$menu_name[1][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[1][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[1][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[2] as $key=>$value){
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value[furl]!=''){
						$menu_name[2][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[2][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[2][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
            $isCurrentFind=false;
			foreach($menu_name[4] as $key=>$value){
				if($value['type']=='1' && $value[furl]!=''){
					if($config['sy_seo_rewrite']=="1"){
						$menu_name[4][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[4][$key][url] = $config[sy_weburl]."/".$value[url];
					}
				}
                if($isCurrentFind==false){
				    $menu_name[4][$key][navclass] = navcalss($value,$paramer[hovclass]);
                }
                if($menu_name[4][$key][navclass]){
                    $isCurrentFind=true;
                }
			}
			foreach($menu_name[5] as $key=>$value){
				if($value['type']=='1'){
					if($config['sy_seo_rewrite']=="1" && $value[furl]!=''){
						$menu_name[5][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[5][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[5][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
		}
		if($paramer[nid]){
			$Navlist =$menu_name[$paramer[nid]];
		}else{
			$Navlist =$menu_name[1];
		}$Navlist = $Navlist; if (!is_array($Navlist) && !is_object($Navlist)) { settype($Navlist, 'array');}
foreach ($Navlist as $_smarty_tpl->tpl_vars['navlist_app']->key => $_smarty_tpl->tpl_vars['navlist_app']->value) {
$_smarty_tpl->tpl_vars['navlist_app']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['navlist_app']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['key']->value>0) {?>|<?php }?><a href="<?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['navlist_app']->value['name'];?>
</a>
                <?php } ?>

            </p>
            <p class="footer_alltwo"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webcopyright'];?>
</p>
            <p class="footer_alltwo"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webrecord'];?>
</p>
            <div class="footer_icno">
                <p class="footer_icno_p">
                    <span>关注： </span>
                    <a class="footer_a1"></a>
                    <a class="footer_a2"></a>
                    <a class="footer_a3" id="fooo">
                    </a>
                    <div class="footer-weixin" id="foooo"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/picture/liantu.jpg" width="113" height="113" /></div>
                </p>
                <p class="footer_icno_tel">全国服务热线：<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_freewebtel'];?>
</p>
            </div>
        </div>
    <?php echo '<script'; ?>
 type="text/javascript"> 
$(".footer_a3").hover(function(){
        (".footer-weixin").toggle();
});
        function returnmessage(frame_id){
    if(frame_id==''||frame_id==undefined){
        frame_id='supportiframe';
    }
    var message = $(window.frames[frame_id].document).find("#layer_msg").val();
    if(message != null){
        var url=$(window.frames[frame_id].document).find("#layer_url").val();
        var layer_time=$(window.frames[frame_id].document).find("#layer_time").val();
        var layer_st=$(window.frames[frame_id].document).find("#layer_st").val();
        if(url=='1'){
            parent.layer.msg(message, layer_time, Number(layer_st),function(){ location.reload();});
        }else if(url==''){
            parent.layer.msg(message, layer_time, Number(layer_st));
        }else{
            parent.layer.msg(message, layer_time, Number(layer_st),function(){location.href = url;});
        }
    }
}
<?php echo '</script'; ?>
>   
  </div>
</div>
</div>
<input type="hidden" value="0" class="ddw"/>
<input type="hidden" value="0" class="ddw2"/>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/lanrenzhijia.js" ><?php echo '</script'; ?>
> 
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/jquery.mousewheel.js" ><?php echo '</script'; ?>
>
</body>
</html>
<?php }} ?>
