<?php
class integral_controller extends common
{
	function index_action()
	{
		$this->yuntpl(array('admin/admin_integral_config'));
	}
	function user_action()
	{
		$this->yuntpl(array('admin/admin_integral_user'));
	}
	function com_action()
	{
		$this->yuntpl(array('admin/admin_integral_com'));
	}
	function lt_action()
	{
		$this->yuntpl(array('admin/admin_integral_lt'));
	}
	function save_action(){
 		if($_POST["config"]){
		 unset($_POST["config"]);
		   foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   if($config==false){
				$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			   }else{
					$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");

				   }
			 }
		 //$this->web_config();
		 $this->ACT_layer_msg($this->config['integral_pricename']."ÅäÖÃÐÞ¸Ä³É¹¦£¡",9,1,2,1);
		}
	}
}

?>