<?php
class admin_lt_xuanshang_controller extends common
{
	//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"look","name"=>'信息状态',"value"=>array("1"=>"已查看","0"=>"未查看"));
		$da_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$re_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'推荐时间',"value"=>$da_time);
		$search_list[]=array("param"=>"reply","name"=>'回复时间',"value"=>$re_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		include(PLUS_PATH."user.cache.php");
		include(PLUS_PATH."com.cache.php");
		$where = "1";
		if($_GET['keyword']!="")
		{
			if($_GET['type']=="1" || $_GET['type']=="4")
			{
				$infouid = $this->obj->DB_select_all("member","`username` like '%".$_GET['keyword']."%'","`uid`");
				if(is_array($infouid))
				{
					foreach($infouid as $k=>$v)
					{
						$info_uids[] = $v['uid'];
					}
					$uids = @implode(",",$info_uids);
				}
				if ($_GET['type']=="1")
				{
					$where.=" and `uid` in (".$uids.")";
				}else{
					$where.=" and `job_uid` in (".$uids.")";
				}
			}elseif ($_GET['type']=="2"){
				$where.=" and `content` like '%".$_GET['keyword']."%'";
			}elseif ($_GET['type']=="3"){
				$where.=" and `reply` like '%".$_GET['keyword']."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['reply']){
			if($_GET['reply']=='1'){
				$where.=" and `reply_time` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `reply_time` >= '".strtotime('-'.(int)$_GET['reply'].'day')."'";
			}
			$urlarr['reply']=$_GET['reply'];
		}
        if($_GET['look']=='1'){
       	   $where.=" and `status`='1'";
        }elseif ($_GET['look']=='0'){
       	   $where.=" and  `status`='0'";
        }
        //分站--------
        $ltwhere=1;
		if($_SESSION['admin_city']){
			$ltwhere.=" and `cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['admin_tcity']){
			$ltwhere.=" and `three_cityid`='".$_SESSION['admin_tcity']."'";
		}
		if($_SESSION['def_city'] || $_SESSION['def_tcity'] || $_SESSION['def_hy'])
		{
			if($_SESSION['def_city']){
				$session[]="`cityid` in (".$_SESSION['def_city'].")";
			}
			if($_SESSION['def_tcity']){
				$session[]="`three_cityid` in (".$_SESSION['def_tcity'].")";
			}
			$ltwhere.=" and (".@implode(" or ",$session).")";
		}
		$lt=$this->obj->DB_select_all("lt_info",$ltwhere,"uid");
		if(is_array($lt))
		{
			foreach($lt as $v)
			{
				$uid[]=$v['uid'];
			}
		}
		$where.=" and job_uid in (".@implode(",",$uid).")";
		//分站--------
        if($_GET['status']=="1")
        {
			$where = "`edate`>'".time()."'";
		}elseif($_GET['status']=="2"){
			$where = "`edate`<'".time()."'";
		}elseif($_GET['status']=="3"){
			$where = "`status`='3'";
		}elseif($_GET['status']=="4"){
			$where = "`status`='0'";
		}
		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr["page"]="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
        $M=$this->MODEL();
		$PageInfo=$M->get_page("rebates",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $list=$PageInfo['rows'];
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$uid[]=$v['job_uid'];
				$uid[]=$v['uid'];
			}
		    $statis =$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","`username`,`uid`");
			foreach($list as $key=>$value)
			{
				foreach($statis as $k=>$v)
				{
					if($value['job_uid']==$v['uid'])
					{
						  $list[$key]['name'] = $v['username'];
					}
					if($value['uid']==$v['uid'])
					{
						  $list[$key]['username'] = $v['username'];
					}
				}
			}
		}
		$this->yunset("get_type", $_GET['type']);
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_lt_xuanshang'));
	}

	function del_action(){
		$this->check_token();
		//批量删除
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$this->obj->DB_delete_all("rebates","`id` in(".@implode(',',$del).")","");
		    	}else{
		    		$this->obj->DB_delete_all("rebates","`id`='".$del."'");
		    	}
	    		$this->layer_msg( "猎头悬赏(ID:".@implode(',',$del).")删除成功！",9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
		//删除
	    if(isset($_GET['id'])){
			$result=$this->obj->DB_delete_all("rebates","`id`='".$_GET['id']."'" );
 			isset($result)?$this->layer_msg('猎头悬赏(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作！',3);
		}
	}

}
?>