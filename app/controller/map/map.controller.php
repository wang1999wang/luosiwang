<?php
class map_controller extends common{ 
	function map_tpl($tpl){
		$this->yuntpl(array('default/map/'.$tpl));
	}
}
?>