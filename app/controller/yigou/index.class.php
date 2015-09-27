<?php
class index_controller extends common{
	function index_action(){
        $this->seo("echayigou");
		$this->yun_tpl(array('index'));
	}
}
?>