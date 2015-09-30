<?php
class web_config_controller extends common
{
	function index_action()
	{
		$this->yuntpl(array('admin/web_config'));
	}
	function save_action()
	{
 		if($_POST['config'])
 		{
		    unset($_POST['config']);
		    foreach($_POST as $key=>$v)
		    {
		        $config=$this->obj->DB_select_num("admin_config","`name`='".$key."'");
			    if($config==false)
			    {
				    $this->obj->DB_insert_once("admin_config","`name`='".$key."',`config`='".iconv("utf-8", "gbk", $v)."'");
			  	}else{
					$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='".$key."'");
				}
			}
			//$this->web_config();
			$this->ACT_layer_msg("页面设置修改成功！",9,1,2,1);
		}
	}
}

?>