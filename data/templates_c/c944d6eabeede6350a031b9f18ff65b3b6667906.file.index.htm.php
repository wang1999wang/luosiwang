<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-30 13:03:56
         compiled from "E:\WWW\luosiwang\app\template\default\index\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:24197560b6d3c9d05d4-19963653%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c944d6eabeede6350a031b9f18ff65b3b6667906' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\default\\index\\index.htm',
      1 => 1442793148,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24197560b6d3c9d05d4-19963653',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'style' => 0,
    'config' => 0,
    'lunbo' => 0,
    'adlist' => 0,
    'dongtai_class_list' => 0,
    'one' => 0,
    'two' => 0,
    'chache_class_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560b6d3d9865d7_04929701',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560b6d3d9865d7_04929701')) {function content_560b6d3d9865d7_04929701($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'E:\\WWW\\luosiwang\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_function_formatpicurl')) include 'E:\\WWW\\luosiwang\\app\\include\\libs\\plugins\\function.formatpicurl.php';
?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<!--[if lte IE 8]>
    <link href="css/iefixed.css" rel="stylesheet" type="text/css" />
<![endif]-->
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/swfobject.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/high.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/css/home.css" rel="stylesheet" type="text/css">
<link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/css/highlight.css" rel="stylesheet" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/slides.jquery.js" type="text/javascript"><?php echo '</script'; ?>
>

<?php $_smarty_tpl->tpl_vars['curr'] = new Smarty_variable(0, null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/top.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo '<script'; ?>
>
    $(function () {
        $("#slides img").width(document.body.clientWidth ? document.body.clientWidth : document.documentElement.clientHeight); 
        $("#slides").slides({
            preload: true,
            preloadImage: '<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/loading.gif',
            play: 5000,
            pause: 2500,
            hoverPause: true
        });
    });
<?php echo '</script'; ?>
>
<style>
    .slides_container{height:100%;}
.pagination {margin:6px 0 0;list-style: none;z-index:9999;position: absolute;bottom: 15px;right:15px;}
.pagination li {float: left;margin: 0 1px;}
.pagination li a {display: block;width: 13px;height: 0;padding-top: 13px;background-position: 0 0;float: left;overflow: hidden;background-image: url(../images/circle.png);}
.pagination li.current a, .pagination li.current a:hover { background-position: -16px -0px }
.pagination li a:hover { background-position: 0px -0px }
</style>
<div id="slides" class="s_lb" style="height:709px;">
    <div class="slides_container">
        <?php  $_smarty_tpl->tpl_vars["lunbo"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["lunbo"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$AdArr=array();$paramer=array();include(PLUS_PATH.'/pimg_cache.php');$add_arr = $ad_label[1];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = 0;$length = 0;
				foreach($add_arr as $key=>$value){
					if(1||(stripos($value['did'],$_SESSION['did'])!==false ||$value['did']=='0')&&$value['start']<time()&&$value['end']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value['name'] = mb_substr($value['name'],0,$length);
						}
						if($paramer['type']!=""){
							if($paramer['type'] == $value['type']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}$AdArr = $AdArr; if (!is_array($AdArr) && !is_object($AdArr)) { settype($AdArr, 'array');}
foreach ($AdArr as $_smarty_tpl->tpl_vars["lunbo"]->key => $_smarty_tpl->tpl_vars["lunbo"]->value) {
$_smarty_tpl->tpl_vars["lunbo"]->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars["lunbo"]->key;
?>
        <div class="slide"><a href="<?php echo $_smarty_tpl->tpl_vars['lunbo']->value['src'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['lunbo']->value['pic'];?>
" style="width:100%;height:100%;" /></a></div>
        <?php } ?>
    </div>
</div>
    <div id="vivo-contain" style="margin-top:250px;">
        <div class="focus-event">
            <div class="focus-event-box">
                <div class="key-event">
                    <ul>
                        <li class="pic"><a href="<?php echo $_smarty_tpl->tpl_vars['adlist']->value[32]['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['adlist']->value[32]['pic'];?>
" alt="画出最美的曲线"><i><b></b><h3>打开微信扫一扫</h3><p>打开微信扫一扫</p></i></a></li>
                        <li class="video">
                        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase=",0,19,0" width="367" height="240">
<param name="movie" value="http://player.youku.com/player.php/sid/XODgwMDg5MTQ4/v.swf">
<param name="quality" value="high">
<param name="wmode" value="transparent">
<embed src="http://player.youku.com/player.php/sid/XODgwMDg5MTQ4/v.swf" quality="high" pluginspage=""; type="application/x-shockwave-flash" width="367" height="240"/></embed>
</object>
                        <!--<embed src="http://player.youku.com/player.php/sid/XMTI4MzI5OTEwMA==/v.swf" allowfullscreen="true" quality="high" width="368" height="240" align="middle" allowscriptaccess="always" type="application/x-shockwave-flash"></embed>
                            <embed src="http://player.youku.com/player.php/sid/XODgwMDg5MTQ4/v.swf" allowfullscreen="true" quality="high" width="368" height="240" align="middle" allowscriptaccess="always" type="application/x-shockwave-flash"></embed>-->
                        </li>
                        <li class="pictext"><a href="<?php echo smarty_function_url(array('m'=>'cars'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['adlist']->value[34]['pic'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['adlist']->value[34]['ad_name'];?>
"><i><b></b><h3>产品 挑选器</h3><p>找到适合您工况的车型</p></i></a></li>
                    </ul>
                </div>
                <style>
                    .key-event .pic, .key-event .video, .key-event .pictext{float:left;display:inline-block;}
                </style>
                <div class="social-event">
                    <div class="social-section cl">
                        <div class="forum-views">
                            <h2><b></b><span>E叉动态</span></h2>
                            <div class="forum-high cl">
                                <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dongtai_class_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
                                <?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['two']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one']->value['pic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value) {
$_smarty_tpl->tpl_vars['two']->_loop = true;
?>
                                <a href="<?php echo smarty_function_url(array('m'=>'article','c'=>'show','id'=>$_smarty_tpl->tpl_vars['two']->value['id']),$_smarty_tpl);?>
" class="high-a"><img src="<?php echo smarty_function_formatpicurl(array('path'=>$_smarty_tpl->tpl_vars['two']->value['newsphoto']),$_smarty_tpl);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['two']->value['title'];?>
"></a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="forum-list">
                                <ul class="cl">
                                    <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dongtai_class_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
                                    <li class="list-a">
                                        <?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['two']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one']->value['nopic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value) {
$_smarty_tpl->tpl_vars['two']->_loop = true;
?>
                                        <a href="<?php echo smarty_function_url(array('m'=>'article','c'=>'show','id'=>$_smarty_tpl->tpl_vars['two']->value['id']),$_smarty_tpl);?>
"><span class="n"><?php echo $_smarty_tpl->tpl_vars['two']->value['class_name'];?>
</span><?php echo $_smarty_tpl->tpl_vars['two']->value['title'];?>
</a>
                                        <?php } ?>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="event-box">
                            <div class="event-switch">
                                <a href="#" class="prev"></a><strong></strong><a href="#" class="next"></a>
                            </div>
                            <ul>
                                <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['chache_class_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?>
                                <li class="media">
                                    <h2><b></b><span><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</span></h2>
                                    <div class="event-content">
                                        <dl class="cl">
                                            <?php  $_smarty_tpl->tpl_vars['two'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['two']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['one']->value['pic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['two']->key => $_smarty_tpl->tpl_vars['two']->value) {
$_smarty_tpl->tpl_vars['two']->_loop = true;
?>
                                            <dd class="first cl">
                                                <a href="<?php echo smarty_function_url(array('m'=>'school','c'=>'show','id'=>$_smarty_tpl->tpl_vars['two']->value['id']),$_smarty_tpl);?>
" class="event-pic"><img src="<?php echo smarty_function_formatpicurl(array('path'=>$_smarty_tpl->tpl_vars['two']->value['newsphoto']),$_smarty_tpl);?>
"></a>
                                              <h3><a href="<?php echo smarty_function_url(array('m'=>'school','c'=>'show','id'=>$_smarty_tpl->tpl_vars['two']->value['id']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['two']->value['title'];?>
</a></h3>
                                                <p><?php echo $_smarty_tpl->tpl_vars['two']->value['content'];?>
</p>
                                                <a href="<?php echo smarty_function_url(array('m'=>'school','c'=>'show','id'=>$_smarty_tpl->tpl_vars['two']->value['id']),$_smarty_tpl);?>
" class="join-now">查看详情</a>
                                            </dd>
                                            <?php } ?>
                                        </dl>
                                    </div>
                                </li>                                
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $_smarty_tpl->tpl_vars['isshowlink'] = new Smarty_variable(1, null, 0);?>    
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
