<?php
class admin_announcement_controller extends common {
	function set_search() {
		$ad_time = array('1' => '今天', '3' => '最近三天', '7' => '最近七天', '15' => '最近半月', '30' => '最近一个月');
		$search_list[] = array("param" => "end", "name" => '发布时间', "value" => $ad_time);
		$this -> yunset("search_list", $search_list);
	} 
	function index_action() {
		$this -> set_search();
		if ($_GET['keyword']) {
			$where = "`title` like '%" . $_GET['keyword'] . "%'";
			$urlarr['keyword'] = $_GET['keyword'];
		} else {
			$where = 1;
		} 
		if ($_GET['end']) {
			if ($_GET['end'] == '1') {
				$where .= " and `datetime` >= '" . strtotime(date("Y-m-d 00:00:00")) . "'";
			} else {
				$where .= " and `datetime` >= '" . strtotime('-' . (int)$_GET['end'] . 'day') . "'";
			} 
			$urlarr['end'] = $_GET['end'];
		} 
		if ($_GET['order']) {
			$where .= " order by " . $_GET['t'] . " " . $_GET['order'];
			$urlarr['order'] = $_GET['order'];
			$urlarr['t'] = $_GET['t'];
		} else {
			$where .= " order by id desc";
		} 
		$urlarr['page'] = "{{page}}";
		$pageurl = Url($_GET['m'], $urlarr, 'admin');
		$M = $this -> MODEL();
		$announcement = $M -> get_page("admin_announcement", $where, $pageurl, $this -> config['sy_listnum'], '*', 'announcement');
		$this -> yunset($announcement);
		$this -> yuntpl(array('admin/admin_announcement_list'));
	} 
	function add_action() {
		$domain = $this -> obj -> DB_select_all("domain", "1", "`id`,`title`");
		$this -> yunset("domain", $domain);
		if ($_GET['id']) {
			$announcement = $this -> obj -> DB_select_once("admin_announcement", "`id`='" . $_GET['id'] . "'");
			$announcement['content'] = str_replace("&", "&amp;", $announcement['content']);
			$this -> yunset("announcement", $announcement);
			$this -> yunset("lasturl", $_SERVER['HTTP_REFERER']);
			if ($announcement['did'] > 0) {
				$domainone = $this -> obj -> DB_select_once("domain", "`id`='" . $announcement['did'] . "'", "`title`");
				$this -> yunset("domainname", $domainone['title']);
			} 
		} 
		$this -> yuntpl(array('admin/admin_announcement_add'));
	} 
	function save_action() {
		if ($_POST['update']) {
			$time = time();
			if ($_POST['did'] == "") {
				$_POST['did'] = 0;
			} 
            $values=array();
			$values['did'] =  $_POST['did'];
            $values['title'] =  $_POST['title'];
            $values['datetime'] =  $time;
            $values['keyword'] =  $_POST['keyword'];
            $values['description'] =  $_POST['description'];
			$content = str_replace("&amp;", "&", html_entity_decode($_POST['content'], ENT_QUOTES, "GB2312"));
            $values['content'] =  $content;
			$nbid = $this -> obj -> update_once("admin_announcement", $values, "`id`='" . $_POST['id'] . "'");
			$lasturl = str_replace("&amp;", "&", $_POST['lasturl']);
			isset($nbid)?$this -> ACT_layer_msg("公告(ID:" . $_POST['id'] . ")更新成功！", 9, $lasturl, 2, 1):$this -> ACT_layer_msg("更新失败！", 8, $lasturl, 2, 1);
		} 
		if ($_POST['add']) {
			$time = time();
			if ($_POST['did'] == "") {
				$_POST['did'] = 0;
			} 
            $values=array();
            $values['did'] =  $_POST['did'];
            $values['title'] =  $_POST['title'];
            $values['datetime'] =  $time;
            $values['keyword'] =  $_POST['keyword'];
            $values['description'] =  $_POST['description'];
			$content = str_replace("&amp;", "&", html_entity_decode($_POST['content'], ENT_QUOTES, "GB2312"));
            $values['content'] =  $content;
			$nbid = $this -> obj -> insert_into("admin_announcement", $values);
			isset($nbid)?$this -> ACT_layer_msg("公告(ID:" . $nbid . ")添加成功！", 9, "index.php?m=admin_announcement", 2, 1):$this -> ACT_layer_msg("添加失败！", 8, "index.php?m=admin_announcement", 2, 1);
		} 
	} 
	function del_action() {
		$this -> check_token();
		if ($_GET['del']) {
			$del = $_GET['del'];
			if ($del) {
				if (is_array($del)) {
					$this -> obj -> DB_delete_all("admin_announcement", "`id` in(" . @implode(',', $del) . ")", "");
				} else {
					$this -> obj -> DB_delete_all("admin_announcement", "`id`='$del'");
				} 
				$this -> layer_msg('公告(ID:' . @implode(',', $del) . ')删除成功！', 9, 1, $_SERVER['HTTP_REFERER']);
			} else {
				$this -> layer_msg('请选择您要删除的公告！', 8, 1, $_SERVER['HTTP_REFERER']);
			} 
		} 
		if (isset($_GET['id'])) {
			$where = "`id`='" . $_GET['id'] . "'";
			$result = $this -> obj -> DB_delete_all("admin_announcement", $where);
			isset($result)?$this -> layer_msg('公告(ID:' . $_GET['id'] . ')删除成功！', 9, 0, $_SERVER['HTTP_REFERER']):$this -> layer_msg('删除失败！', 8, 0, $_SERVER['HTTP_REFERER']);
		} else {
			$this -> layer_msg('非法操作！', 8, 0, $_SERVER['HTTP_REFERER']);
		} 
	} 
} 

?>