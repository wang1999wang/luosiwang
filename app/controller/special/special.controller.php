<?php
class special_controller extends common{
	function spetpl($tpl){ 
		$this->yuntpl(array('default/special/'.$tpl));
	}
}
?>