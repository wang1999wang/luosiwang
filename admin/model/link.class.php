<?php
class link_controller extends common {
	function set_search() {
		include(PLUS_PATH . "domain_cache.php");
		$domain = array();
		foreach($site_domain as $val) {
			$domain[$val['id']] = $val['cityname'];
		} 
		$lo_time = array('1' => '今天', '3' => '最近三天', '7' => '最近七天', '15' => '最近半月', '30' => '最近一个月');
		$search_list[] = array("param" => "did", "name" => '使用范围', "value" => $domain);
		$search_list[] = array("param" => "type", "name" => '类型', "value" => array("1" => "文字连接", "2" => "图片连接"));
		$search_list[] = array("param" => "state", "name" => '审核状态', "value" => array("1" => "已审核", "2" => "未审核"));
		$search_list[] = array("param" => "link", "name" => '发布时间', "value" => $lo_time);
		$this -> yunset("search_list", $search_list);
	} 
	function index_action() {
		$this -> set_search();
		extract($_GET);
		$where = 1;
		if ($state == '1') {
			$where .= " and `link_state`='1'";
			$urlarr['state'] = '1';
		} elseif ($state == '2') {
			$urlarr['state'] = '2';
			$where .= " and `link_state`='0'";
		} 
		if ($_GET['did']) {
			$urlarr['did'] = $_GET['did'];
			$where .= " and `did`='" . $_GET['did'] . "'";
		} 
		if ($_GET['link']) {
			if ($_GET['link'] == '1') {
				$where .= " and `link_time` >='" . strtotime(date("Y-m-d 00:00:00")) . "'";
			} else {
				$where .= " and `link_time`>'" . strtotime('-' . intval($_GET['link']) . ' day') . "'";
			} 
			$urlarr['link'] = $_GET['link'];
		} 
		if ($_GET['news_search'] != '') {
			if ($_GET['type'] == '1') {
				$where .= " and `link_name` like '%" . $_GET['keyword'] . "%' and `link_type`='1'";
			} elseif ($_GET['type'] == '2') {
				$where .= " and `link_name` like '%" . $_GET['keyword'] . "%' and `link_type`='2'";
			} else {
				$where .= " and `link_name` like '%" . $_GET['keyword'] . "%'";
			} 
			$urlarr['type'] = $_GET['type'];
			$urlarr['keyword'] = $_GET['keyword'];
			$urlarr['news_search'] = $_GET['news_search'];
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
		$linkrows = $this -> get_page("admin_link", $where, $pageurl, $this -> config['sy_listnum']);
		foreach($linkrows as $key => $value) {
			$domain = $this -> obj -> DB_select_all("domain", "1", "`id`,`title`");

			$linkrows[$key]['d_title'] = '全站';
			if (!empty($domain)) {
				foreach($domain as $v) {
					if ($value['did'] == $v['id']) {
						$linkrows[$key]['d_title'] = $v['title'];
					} 
				} 
			} 
		} 
		$this -> yunset("get_type", $_GET);
		$this -> yunset("linkrows", $linkrows);
		$this -> yuntpl(array('admin/admin_link_list'));
	} 

	function add_action() {
		$domain = $this -> obj -> DB_select_all("domain", "1", "`id`,`title`");
		$this -> yunset("domain", $domain);
		if ($_GET['id']) {
			$linkarr = $this -> obj -> DB_select_once("admin_link", "id='" . $_GET['id'] . "'");
			if ($linkarr['did'] > 0) {
				$domainone = $this -> obj -> DB_select_once("domain", "`id`='" . $linkarr['did'] . "'", "`title`");
				$this -> yunset("domainname", $domainone['title']);
			} 
			$this -> yunset("linkrow", $linkarr);
			$this -> yunset("lasturl", $_SERVER['HTTP_REFERER']);
		} 
		$this -> yuntpl(array('admin/admin_link_add'));
	} 
	function del_action() {
		if (is_array($_POST['del'])) {
			$linkid = @implode(',', $_POST['del']);
			$layer_type = 1;
		} else {
			$this -> check_token();
			$linkid = $_GET['id'];
			$layer_type = 0;
		} 
		$row = $this -> obj -> DB_select_all("admin_link", "`id` in (" . $linkid . ") and `pic`<>''");
		if (is_array($row)) {
			foreach($row as $v) {
				unlink_pic("../" . $v['pic']);
			} 
		} 
		$delid = $this -> obj -> DB_delete_all("admin_link", "`id` in (" . $linkid . ")", "");
		$this -> get_cache();
		$delid?$this -> layer_msg('友情连接(ID:' . $linkid . ')删除成功！', 9, $layer_type, $_SERVER['HTTP_REFERER']):$this -> layer_msg('删除失败！', 8, $layer_type, $_SERVER['HTTP_REFERER']);
	} 
	function status_action() {
		extract($_POST);
		if ($yesid) {
			$update = $this -> obj -> DB_update_all("admin_link", "`link_state`='" . $status . "'", "id='" . $yesid . "'");
			$this -> get_cache();
			$update?$this -> ACT_layer_msg("友情链接审核成功！", 9, $_SERVER['HTTP_REFERER'], 2, 1):$this -> ACT_layer_msg("友情链接审核失败！", 8, $_SERVER['HTTP_REFERER']);
		} else {
			$this -> ACT_layer_msg("非法操作！", 8, $_SERVER['HTTP_REFERER']);
		} 
	} 
	function save_action() {
		extract($_POST);
		$upload = $this -> upload_pic("../data/upload/link/", "22");
		if ($link_add) {
			if (preg_match("/[^\d-., ]/", $sorting)) {
				$this -> ACT_layer_msg("请正确填写，排序是数字！", 8, $_SERVER['HTTP_REFERER']);
			} else {
				if ($sorting == "") {
					$sorting = "0";
				} 
				if ($phototype == "") {
					$phototype = "0";
				} 

                $values=array();
                $values['did']=$did;
                $values['link_name']=trim($title);
                $values['link_url']=$url;
                $values['link_type']=$type;
                $values['tem_type']=$tem_type;
                $values['img_type']=$phototype;
                $values['link_sorting']=$sorting;
                $values['link_state']=1;
                $values['link_time']=time();

				if ($phototype == 1) {
					$pictures = $upload -> picture($_FILES['uplocadpic']);
					$values['pic']= str_replace("../", "", $pictures);
				} else {
					$values['pic']= $uplocadpic;
				} 
				$nbid = $this -> obj -> insert_into("admin_link", $values);
				$this -> get_cache();
				isset($nbid)?$this -> ACT_layer_msg("友情连接(ID:" . $nbid . ")添加成功！", 9, "index.php?m=link", 2, 1):$this -> ACT_layer_msg("添加失败！", 8, "index.php?m=link");
			} 
		} 
		if ($link_update) {
            $values=array();
            $values['did']=$did;
            $values['link_name']=trim($title);
            $values['link_url']=$url;
            $values['link_type']=$type;
            $values['tem_type']=$tem_type;
            $values['img_type']=$phototype;
            $values['link_sorting']=$sorting;
            $values['link_state']=1;
			if ($phototype == 1) {
				if ($_FILES['uplocadpic']['tmp_name'] != "") {
					$pictures = $upload -> picture($_FILES['uplocadpic']);
					$values['pic']= str_replace("../", "", $pictures);
					$row = $this -> obj -> DB_select_once("admin_link", "`id`='$id' and `pic`!=''");
					if (is_array($row)) {
						unlink_pic("../" . $row["pic"]);
					} 
				} 
			} else {
				$values['pic']= $uplocadpic;
			} 
			$nbid = $this -> obj -> update_once("admin_link", $values, "`id`='$id'");
			$lasturl = str_replace("&amp;", "&", $lasturl);
			$this -> get_cache();
			isset($nbid)?$this -> ACT_layer_msg("友情连接(ID:" . $id . ")修改成功！", 9, $lasturl, 2, 1):$this -> ACT_layer_msg("修改失败！", 8, $lasturl);
		} 
	} 
	function get_cache() {
		include(LIB_PATH . "cache.class.php");
		$cacheclass = new cache(PLUS_PATH, $this -> obj);
		$makecache = $cacheclass -> link_cache("link.cache.php");
	} 
} 

?>