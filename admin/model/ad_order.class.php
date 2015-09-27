<?php
class ad_order_controller extends common
{
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","2"=>"未通过","-1"=>"未审核"));
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'订单时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}

	function index_action()
	{
		$this->set_search();
		if($_GET['keyword']!="")
		{
            if ($_GET['type']=='1'){
            	$orderinfo=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%'","`uid`");
            	if (is_array($orderinfo))
            	{
            		foreach ($orderinfo as $val)
            		{
            			$orderuids[]=$val['uid'];
            		}
            		$oruids=@implode(",",$orderuids);
            	}
            	$where.=" `comid` in (".$oruids.")";
            }elseif ($_GET['type']=='2'){
            	$where.=" `order_id` like '%".trim($_GET['keyword'])."%'";
            }elseif($_GET['type']=='3'){
            	$where.=" `adname` like '%".trim($_GET['keyword'])."%'";
            }elseif($_GET['type']=='4'){
            	$g_com=$this->obj->DB_select_all("company","`name` like '%".trim($_GET['keyword'])."%' ","`uid`");
            	if(is_array($g_com) && !empty($g_com)){
            		foreach($g_com as $v){
            		   $g_uid[]=$v['uid'];
            		}
            		$g_uids=@implode(",",$g_uid);
            	}
				$where.=" `comid` in ('".$g_uids."')";
            }
            $urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}else{
			$where=1;
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['status']){
			if($_GET['status']=="-1"){
				$where.=" and `status`='0'";
			}else{
				$where.=" and `status`='".$_GET['status']."'";
			}
			$urlarr['status']=$_GET['status'];
		}
		//分站--------
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
		if(is_array($com))
		{
			foreach($com as $v)
			{
				$uid[]=$v['uid'];
			}
		}
		$where.=" and `comid` in (".@implode(",",$uid).")";
		//分站--------

		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr["page"]="{{page}}";
		$pageurl=$this->url("index",$_GET["m"],$urlarr);
        $M=$this->MODEL();
		$PageInfo=$M->get_page("ad_order",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $rows=$PageInfo['rows'];
		include (APP_PATH."/config/db.data.php");
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$rows[$k][order_state_n]=$arr_data['paystate'][$v['order_state']];
				$classid[]=$v['comid'];
			}
		}
		if(is_array($classid))
		{
			$group=$this->obj->DB_select_all("member","uid in (".@implode(",",$classid).")","`uid`,`username`");
			$group_com=$this->obj->DB_select_all("company","`uid` in (".@implode(",",$classid).")","`uid`,`name`");
		}

		if(is_array($group)){
			foreach($group as $key=>$value){
				foreach($rows as $k=>$v){
					if($value['uid']==$v['comid']){
						$rows[$k]['username']=$value['username'];
					}
				}
			}
		}
		if(is_array($group_com)){
			foreach($group_com as $key=>$value){
				foreach($rows as $k=>$v){
					if($value['uid']==$v['comid']){
						$rows[$k]['comname']=$value['name'];
					}
				}
			}
		}
		$this->yunset("get_type", $_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_ad_order'));
	}
	function sbody_action(){
		$row=$this->obj->DB_select_once("ad_order","`id`=".$_GET['pid']);
		echo $row['statusbody'];die;
	}
	function status_action(){
		extract($_POST);
		$row=$this->obj->DB_select_once("ad_order","`id`=$pid");
		if($status=="1"){
			$value.="`ad_name`='".$row['ad_name']."',";
			$time_end=mktime()+3600*24*30*$row['buy_time'];
			$value.="`time_start`='".date("Y-m-d")."',";
			$value.="`time_end`='".date("Y-m-d",$time_end)."',";
			$value.="`ad_type`='pic',";
			$value.="`pic_url`='".$row['pic_url']."',";
			$value.="`pic_src`='".$row['pic_src']."',";
			$value.="`class_id`='".$row['aid']."',";
			$value.="`is_check`='1'";
			$id=$this->obj->DB_insert_once("ad",$value);
			$this->obj->DB_update_all("ad_order","ad_id='".$id."'","`id`=$pid");
			include_once("model/model/advertise_class.php");
			$adver = new advertise($this->obj);
			$adver->model_ad_arr_action();
		}else if($status=="2"){
			if($row['buytype']=="1"){
				$value="`pay`=`pay`+".$row['price']."";
			}else{
				$value="`integral`=`integral`+'".$row['integral']."'";
			}
			$this->obj->DB_update_all("company_statis",$value,"`uid`=".$row['comid']."");
		}
		$id=$this->obj->DB_update_all("ad_order","`status`='$status',`statusbody`='".$statusbody."'","`id`=$pid");
		$id?$this->ACT_layer_msg("广告订单(ID:".$pid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function del_action(){
		$this->check_token();
	    if($_GET['del']){

	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
			    	$pic_url=$this->obj->DB_select_all("ad_order","`id` in(".@implode(',',$del).")","`pic_url`");
					foreach($pic_url as $val){
						$this->obj->unlink_pic($val['pic_url']);
					}
					$this->obj->DB_delete_all("ad_order","`id` in(".@implode(',',$del).")","");
		    	}else{
		    		$this->obj->DB_delete_all("ad_order","`id`='$del'");
		    	}
				$this->layer_msg('广告订单(ID:'.@implode(',',$del).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的订单！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."'";
			$pic_url=$this->obj->DB_select_once("ad_order",$where,"`pic_url`");
			$this->obj->unlink_pic($pic_url['pic_url']);
			$result=$this->obj->DB_delete_all("ad_order", $where);
			isset($result)?$this->layer_msg('订单(ID:'.$_GET['id'].')删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作！',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>