<?php
class makenews_controller extends common
{
	function index_action(){
		$this->yunset("type","news");
		$this->yuntpl(array('admin/admin_makenews'));
	}
	function makecache_action(){
		extract($_POST);
	}

}
?>