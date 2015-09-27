<?php
class index_controller extends school_controller{ 
	function index_action(){		
		$this->seo("echaxuetang");
		$this->news_tpl('index');
	} 
}
?>