<?php
class school_controller extends common{ 
	function news_tpl($tpl){
        $this->yunset('get',$_GET);
		$this->yuntpl(array('default/school/'.$tpl));
	}
}
?>