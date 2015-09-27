<?php
class index_controller extends common{
	function index_action(){
        $this->seo("echahehuoren");
		$this->yun_tpl(array('index'));
	}
}
?>