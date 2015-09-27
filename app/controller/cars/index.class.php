<?php
class index_controller extends cars_controller{ 
	function index_action(){	
        //1,ÈÈÃÅ£»2,´ÙÏú
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