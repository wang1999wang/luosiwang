<?php
class friend_im_list_controller extends common
{
	function set_search(){
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'聊天时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		include(PLUS_PATH."user.cache.php");
		include(PLUS_PATH."com.cache.php");
		$this->set_search();
		$where = "1";
		if(trim($_GET['keyword'])){
			if($_GET['type']==3){
				$where.=" and `username` like '%".$_GET['keyword']."%'";
			}elseif ($_GET['type']=='2'){
				$where.=" and `content` like '%".$_GET['keyword']."%'";
			}elseif ($_GET['type']=='1'){
				$friendinfo=$this->obj->DB_select_all("member","`username` like '%".$_GET['keyword']."%'","`uid`");
				if (is_array($friendinfo)){
					foreach ($friendinfo as $key=>$val){
						$friuids[]=$val['uid'];
					}
					$listuids=@implode(",",$friuids);
				}
				$where.=" and `touid` in (".$listuids.")";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
 		//分站---
		$wheres=1;
		if($_SESSION['admin_city']){
			$wheres.=" and `cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['admin_hy']){
			$wheres.=" and `hy`='".$_SESSION['admin_hy']."'";
		}
		if($_SESSION['def_city'] || $_SESSION['def_hy'])
		{
			if($_SESSION['def_city']){
				$session[]="`cityid` in (".$_SESSION['def_city'].")";
			}
			if($_SESSION['def_hy']){
				$session[]="`hy` in (".$_SESSION['def_hy'].")";
			}
			$wheres.=" and (".@implode(" or ",$session).")";
		}
		$com=$this->obj->DB_select_all("company",$wheres,"`uid`");
		$ltwheres=1;
		if($_SESSION['admin_city']){
			$ltwheres.=" and `cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['admin_tcity']){
			$ltwheres.=" and `three_cityid`='".$_SESSION['admin_tcity']."'";
		}
		if($_SESSION['def_city'] || $_SESSION['def_tcity'])
		{
			if($_SESSION['def_city']){
				$session[]="`cityid` in (".$_SESSION['def_city'].")";
			}
			if($_SESSION['def_tcity']){
				$session[]="`three_cityid` in (".$_SESSION['def_tcity'].")";
			}
			$ltwheres.=" and (".@implode(" or ",$session).")";
		}
		$lt=$this->obj->DB_select_all("lt_info",$ltwheres,"`uid`");
		if(is_array($com)){
			foreach($com as $v){
				$uid[]=$v['uid'];
			}
		}
		if(is_array($lt)){
			foreach($lt as $v){
				$uid[]=$v['uid'];
			}
		}
		$where.=" AND (`uid` in (".@implode(",",$uid).") and `touid` in (".@implode(",",$uid)."))";
		//分站---
		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
		$mes_list=$this->get_page("friend_im_list",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($mes_list)&&$mes_list){
			$tuid=array();
			foreach($mes_list as $val){
				$tuid[]=$val['touid'];
			}
			$statis =$this->obj->DB_select_all("member","`uid` in(".@implode(',',$tuid).")","username,uid");
			foreach($mes_list as $key=>$value){
				foreach($statis as $k=>$v){
					if($value['touid']==$v['uid']){
						$mes_list[$key]['name'] = $v['username'];
					}
				}
			}
		}
		$this->yunset("get_type", $_GET);
		$this->yunset("mes_list",$mes_list);
		$this->yuntpl(array('admin/friend_im_list'));
	}

	function del_action(){
		$this->check_token();
		//批量删除
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($_GET['del']){
	    		if(is_array($_GET['del'])){
					$this->obj->DB_delete_all("friend_im_list","`id` in(".@implode(',',$_GET['del']).")","");
					$del=@implode(',',$_GET['del']);
		    	}else{
		    		$this->obj->DB_delete_all("friend_im_list","`id`='$del'");
		    	}
	    		$this->layer_msg( "聊天记录(ID:".$del.")删除成功！",9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
		//删除
	    if(isset($_GET['id'])){
			$result=$this->obj->DB_delete_all("friend_im_list","`id`='".$_GET['id']."'" );
			isset($result)?$this->layer_msg('聊天记录(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作！',3,0,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>