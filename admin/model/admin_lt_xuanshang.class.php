<?php
class admin_lt_xuanshang_controller extends common
{
	//���ø߼���������
	function set_search(){
		$search_list[]=array("param"=>"look","name"=>'��Ϣ״̬',"value"=>array("1"=>"�Ѳ鿴","0"=>"δ�鿴"));
		$da_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$re_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$search_list[]=array("param"=>"end","name"=>'�Ƽ�ʱ��',"value"=>$da_time);
		$search_list[]=array("param"=>"reply","name"=>'�ظ�ʱ��',"value"=>$re_time);
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
        //��վ--------
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
		//��վ--------
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
		//����ɾ��
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$this->obj->DB_delete_all("rebates","`id` in(".@implode(',',$del).")","");
		    	}else{
		    		$this->obj->DB_delete_all("rebates","`id`='".$del."'");
		    	}
	    		$this->layer_msg( "��ͷ����(ID:".@implode(',',$del).")ɾ���ɹ���",9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "��ѡ����Ҫɾ������Ϣ��",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
		//ɾ��
	    if(isset($_GET['id'])){
			$result=$this->obj->DB_delete_all("rebates","`id`='".$_GET['id']."'" );
 			isset($result)?$this->layer_msg('��ͷ����(ID:'.$_GET['id'].')ɾ���ɹ���',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('�Ƿ�������',3);
		}
	}

}
?>