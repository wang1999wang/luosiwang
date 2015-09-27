<?php
class index_controller extends article_controller{ 
	function index_action(){		
		$this->seo("echadongtai");
		$this->news_tpl('index');
	} 
}
?>