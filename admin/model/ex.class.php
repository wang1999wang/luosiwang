<?php
class config_controller extends common
{
	function index_action(){

		$this->yunset("adminusergroup",$adminusergroup);
		$this->yuntpl(array('admin/admin_user_list'));
	}


}

?>