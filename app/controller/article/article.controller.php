<?php
class article_controller extends common{ 
	function news_tpl($tpl){
        $this->yunset('get',$_GET);
		$this->yuntpl(array('default/article/'.$tpl));
	}
}
?>