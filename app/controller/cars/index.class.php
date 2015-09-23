<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2015 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class index_controller extends cars_controller{ 
	function index_action(){	
        //1,热门；2,促销
        switch($_GET['id']){
            case 1:$seo='remenchexing';break;
            case 2:$seo='cuxiaochexing';break;
            default:$seo='chachejiazu';break;
        }
		$this->seo($seo);
		$this->news_tpl('index');
	} 
}
?>