<?php
class index_controller extends common{
	function index_action(){ 
		$this->get_moblie();
		$this->seo("index");
		$this->yuntpl(array('wap/index'));
	}
	function loginout_action(){
		$this->unset_cookie();
		$this->wapheader('index.php');
	} 
}
?>