<?php
class regset_controller extends common{
	function index_action(){
		$this->yunset("config",$this->config);
		$this->yuntpl(array('admin/admin_regset'));
	}
	function save_action(){
 		if($_POST['config']){
			unset($_POST['config']);
			foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   if($config==false){
				$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			   }else{
				$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");
			   }
		 	}
			//$this->web_config();
			$this->layer_msg("×¢²áÉèÖÃ³É¹¦£¡",9,1);
		 }
	}
}
?>