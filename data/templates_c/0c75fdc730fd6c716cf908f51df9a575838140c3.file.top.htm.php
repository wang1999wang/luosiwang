<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-30 13:03:57
         compiled from "E:\WWW\luosiwang\\app\template\default\top.htm" */ ?>
<?php /*%%SmartyHeaderCode:26512560b6d3d9f3be7-92270154%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c75fdc730fd6c716cf908f51df9a575838140c3' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\\\app\\template\\default\\top.htm',
      1 => 1441151247,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26512560b6d3d9f3be7-92270154',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'style' => 0,
    'nav_list1' => 0,
    'one' => 0,
    'curr' => 0,
    'key' => 0,
    'two' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560b6d3deb6904_35604127',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560b6d3deb6904_35604127')) {function content_560b6d3deb6904_35604127($_smarty_tpl) {?>
</head>

<body class="home">

    <div class="header">
        <div class="header_in">
            <div id="vivo-airbox"></div>
            <div id="vivo-wrap">
                <div id="vivo-head">
                    <div class="vivo-search">
                        <div class="search-box">
                            <form action='/search' method='get' onSubmit="if ($.trim($(this).find('input').val()) == '') {alert('请输入关键词'); return false;} return true;">
                            <select name="type" style=" height:37px;">
                                <option value="article">E叉动态</option>
                                <option value="school">E叉学堂</option>
                                <option value="cars">叉车家族</option>
                            </select>
                            <select name="range" style=" height:37px;">
                                <option value="title">标题</option>
                                <option value="content">全文</option>
                            </select>
                            <input style="width:400px;" type="text" placeholder="如:E叉车租赁" name='q' class='data_q' autocomplete="off" /><button>搜索</button><a class="close"></a></form>
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
   <?php }} ?>
