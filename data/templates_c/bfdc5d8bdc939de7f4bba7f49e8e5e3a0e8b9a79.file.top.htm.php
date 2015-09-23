<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-08-04 06:38:56
         compiled from "E:\WWW\eforklift\\app\template\default\top.htm" */ ?>
<?php /*%%SmartyHeaderCode:987655bfed80db6109-04185519%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfdc5d8bdc939de7f4bba7f49e8e5e3a0e8b9a79' => 
    array (
      0 => 'E:\\WWW\\eforklift\\\\app\\template\\default\\top.htm',
      1 => 1438349696,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '987655bfed80db6109-04185519',
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
  'unifunc' => 'content_55bfed811fa351_41121314',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55bfed811fa351_41121314')) {function content_55bfed811fa351_41121314($_smarty_tpl) {?>
</head>

<body class="home">

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
   <?php }} ?>
