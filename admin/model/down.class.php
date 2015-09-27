<?php
class down_controller extends common
{
		//设置高级搜索功能
	function set_search(){
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'下载时间',"value"=>$lo_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$where = "1";
		$this->set_search();
		if($_GET['keyword']){
			if($_GET['type']=="1"){
				$info=$this->obj->DB_select_all("member","`username` like '%".$_GET['keyword']."%'","`uid`");
				if(is_array($info)){
					foreach ($info as $v){
						$comid[]=$v['uid'];
					}
				}
				$where.=" and `comid` in (".@implode(",",$comid).")";
			}elseif ($_GET['type']=="2"){
				$info=$this->obj->DB_select_all("company","`name` like '%".$_GET['keyword']."%'","`uid`");
				if(is_array($info)){
					foreach ($info as $v){
						$comid[]=$v['uid'];
					}
				}
				$where.=" and `comid` in (".@implode(",",$comid).")";
			}elseif ($_GET['type']=="3"){
				$info=$this->obj->DB_select_all("member","`username` like '%".$_GET['keyword']."%'","`uid`");
				if(is_array($info)){
					foreach ($info as $v){
						$uid[]=$v['uid'];
					}
				}
				$where.=" and `uid` in (".@implode(",",$uid).")";
			}elseif ($_GET['type']=="4"){
				$info=$this->obj->DB_select_all("resume_expect","`name` like '%".$_GET['keyword']."%'","`uid`");
				if(is_array($info)){
					foreach ($info as $v){
						$eid[]=$v['uid'];
					}
				}
				$where.=" and `eid` in (".@implode(",",$eid).")";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and `downtime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `downtime` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET['sdate'])
		{
			$sdate=strtotime($_GET['sdate']);
			$where.=" and `downtime`>'$sdate'";
		}
		if($_GET['edate'])
		{
			$edate=strtotime($_GET['edate']);
			$where.=" and `downtime`<'$edate'";
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
		$list=$this->get_page("down_resume",$where,$pageurl,$this->config['sy_listnum']);
		if(is_array($list))
		{
			foreach($list as $v)
			{
				$eid[]=$v['eid'];
				$uid[]=$v['uid'];
				$uid[]=$v['comid'];
				$comid[]=$v['comid'];
			}
			$resume=$this->obj->DB_select_all("resume_expect","`id` in (".@implode(",",$eid).")","name,id");
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","username,uid,usertype");
			$company=$this->obj->DB_select_all("company","`uid` in (".@implode(",",$comid).")","name,uid");
			$statis=$this->obj->DB_select_all("company_statis","`uid` in (".@implode(",",$comid).")","rating,uid");
			$lt_statis=$this->obj->DB_select_all("lt_statis","`uid` in (".@implode(",",$comid).")","rating,uid");
			$lt=$this->obj->DB_select_all("lt_info","`uid` in (".@implode(",",$comid).")","realname,uid");
			foreach($list as $k=>$v)
			{
				foreach($company as $val)
				{
					if($v['comid']==$val['uid'])
					{
						$list[$k]['com_name']=$val['name'];
					}
				}
				foreach($statis as $val)
				{
					if($v['comid']==$val['uid'])
					{
						$list[$k]['rating']=$val['rating'];
					}
				}
				foreach($lt_statis as $val)
				{
					if($v['comid']==$val['uid'])
					{
						$list[$k]['rating']=$val['rating'];
					}
				}
				foreach($lt as $val)
				{
					if($v['comid']==$val['uid'])
					{
						$list[$k]['com_name']=$val['realname'];
					}
				}
				foreach($resume as $val)
				{
					if($v['eid']==$val['id'])
					{
						$list[$k]['resume']=$val['name'];
					}
				}
				foreach($member as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$list[$k]['username']=$val['username'];
					}
					if($v['comid']==$val['uid'])
					{
						$list[$k]['com_username']=$val['username'];
						$list[$k]['usertype']=$val['usertype'];
					}
				}
			}
		}
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/down'));
	}
	function del_action()
	{
		$this->check_token();
	    if($_GET['del']){
	    	if(is_array($_GET['del']))
	    	{
	    		$del=@implode(",",$_GET['del']);
	    		$layer_status=1;
	    	}else{
	    		$del=$_GET['del'];
	    		$layer_status=0;
	    	}
			$this->obj->DB_delete_all("down_resume","`id` in (".$del.")","");
			$this->layer_msg( "下载记录(ID:".$del.")删除成功！",9,$layer_status,$_SERVER['HTTP_REFERER']);
	   }else{
			$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
    	}
	}
}
?>