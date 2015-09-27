<?php
class friend_message_controller extends common
{
	function set_search(){
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'留言时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		include(PLUS_PATH."user.cache.php");
		include(PLUS_PATH."com.cache.php");
		$this->set_search();
		$where = "1";

		if($_GET['usertype']){
			$where.=" AND `usertype`='".$_GET['usertype']."'";
			$urlarr['usertype']=$_GET['usertype'];
		}
		if($_GET['status']=="1"){
			$where.=" AND `status`='".$_GET['status']."'";
			$urlarr['status']=$_GET['status'];
		}elseif($_GET['status']=="2"){
			$where.=" AND `status`='0'";
			$urlarr['status']=$_GET['status'];
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
 		if($this->config['sy_web_site']=='1'){
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
			$uid=array();
			if(is_array($com))
			{
				foreach($com as $v)
				{
					$uid[]=$v['uid'];
				}
			}
			if(is_array($lt))
			{
				foreach($lt as $v)
				{
					$uid[]=$v['uid'];
				}
			}
			$where.=" AND (`uid` in (".@implode(",",$uid).") and `fid` in (".@implode(",",$uid)."))";
 		}
		//分站---
		if(trim($_GET['keyword'])){
			if($_GET['type']==1){
				if($uid&&is_array($uid)){
					$infouid = $this->obj->DB_select_all("member","`username` like '%".$_GET['keyword']."%' and `uid` in(".@implode(',',$uid).")","`uid`,`username`");
				}else{
					$infouid = $this->obj->DB_select_all("member","`username` like '%".$_GET['keyword']."%'","`uid`,`username`");
				}
				if(is_array($infouid)){
					foreach($infouid as $k=>$v){
						$info_uids[] = $v['uid'];
					}
					$uids = @implode(",",$info_uids);
				}
				$where.=" and `uid` in ($uids)";
			}else{
				$where.=" and `content` like '%".$_GET['keyword']."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
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
		$mes_list=$this->get_page("friend_message",$where,$pageurl,$this->config['sy_listnum']);

		if(is_array($mes_list)){
			if($infouid==''){
				$uids=array();
				foreach($mes_list as $value){
					$uids[]=$value['uid'];
				}
				$infouid = $this->obj->DB_select_all("member","`uid` in (".@implode(',',$uids).")","`uid`,`username`");
			}
			foreach($mes_list as $key=>$value){
				foreach($infouid as $k=>$v)
				{
					if($value['uid']==$v['uid'])
					{
						 $mes_list[$key]['username'] = $v['username'];
					}

				}
			}
		}
        $this->yunset("get_type", $_GET);
		$this->yunset("mes_list",$mes_list);
		$this->yuntpl(array('admin/friend_message'));
	}

	function del_action(){
		$this->check_token();
		//批量删除
	    if($_GET['del']){
	    	if($_GET['del']){
	    		if(is_array($_GET['del'])){
					$this->obj->DB_delete_all("friend_message","`id` in(".@implode(',',$_GET['del']).")","");
					$del=@implode(',',$_GET['del']);
					$layer_type='1';
		    	}else{
		    		$this->obj->DB_delete_all("friend_message","`id`='$del'");
					$layer_type='0';
		    	}
	    		$this->layer_msg( "留言(ID:".$del.")删除成功！",9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
		//删除
	    if(isset($_GET['id'])){
			$result=$this->obj->DB_delete_all("friend_message","`id`='".$_GET['id']."'" );
			isset($result)?$this->layer_msg('留言(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作！',3,0,$_SERVER['HTTP_REFERER']);
		}
	}
}