<?php
class height_user_controller extends common
{
	//���ø߼���������
	function set_search(){
		include PLUS_PATH."/user.cache.php";
        foreach($userdata['user_salary'] as $k=>$v){
               $ltarr[$v]=$userclass_name[$v];
        }
        foreach($userdata['user_type'] as $k=>$v){
               $ltar[$v]=$userclass_name[$v];
        }
        foreach($userdata['user_report'] as $k=>$v){
               $ltarry[$v]=$userclass_name[$v];
        }
        $search_list[]=array("param"=>"rec","name"=>'�Ƽ�״̬',"value"=>array("1"=>"���Ƽ�","2"=>"δ�Ƽ�"));
        $search_list[]=array("param"=>"searchtype","name"=>'��������',"value"=>$ltar);
        $search_list[]=array("param"=>"status","name"=>'���״̬',"value"=>array("1"=>"δ���","2"=>"�����","3"=>"δͨ��"));
        $lo_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
        $search_list[]=array("param"=>"verify","name"=>'���ʱ��',"value"=>$lo_time);
        $search_list[]=array("param"=>"searchreport","name"=>'����ʱ��',"value"=>$ltarry);
		$search_list[]=array("param"=>"searchsalary","name"=>'����Ҫ��',"value"=>$ltarr);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		//����
		$where="`height_status`<>'0'";
		if ($_GET['searchsalary']!=""){
			$where.=" and `salary`='".$_GET['searchsalary']."'";
			$urlarr['searchsalary']=$_GET['searchsalary'];
		}
		if ($_GET['searchtype']!=""){
			$where.=" and `type`='".$_GET['searchtype']."'";
			$urlarr['searchtype']=$_GET['searchtype'];
		}
		if ($_GET['searchreport']!=""){
			$where.=" and `report`='".$_GET['searchreport']."'";
			$urlarr['searchreport']=$_GET['searchreport'];
		}
		if($_GET['news_search']!=""){
			if ($_GET['keyword']!=''){
				if ($_GET['searchrname']=='2'){
				    $where.=" and `name` like '%".$_GET['keyword']."%'";
			     }elseif ($_GET['searchrname']=='1'){
				     $meminfo=$this->obj->DB_select_all("member","`username` like '%".$_GET['keyword']."%'","`uid`");
					  if (is_array($meminfo)){
					         foreach ($meminfo as $k=>$v){
						     $memuids[]=$v['uid'];
					     }
					  $mems=@implode(",",$memuids);
				    }
				   $where.=" and `uid` in (".$mems.")";
			      }
			      $urlarr['keyword']=$_GET['keyword'];
			      $urlarr['searchrname']=$_GET['searchrname'];
			}
			$urlarr['news_search']=$_GET['news_search'];
		}
		if($_GET['status']){
			$where.=" and `height_status`='".$_GET['status']."'";
			$urlarr['status']=$_GET['status'];
		}
		if($_GET['rec']){
			if($_GET['rec']=='2'){
				$where.=" and `rec`='0'";
				$urlarr['rec']=0;
			}else{
				$where.=" and `rec`='".$_GET['rec']."'";
				$urlarr['rec']=$_GET['rec'];
			}
		}
		if($_GET['verify']){
			if($_GET['verify']=='1'){
				$where.=" and `status_time` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `status_time` >= '".strtotime('-'.(int)$_GET['verify'].'day')."'";
			}
			$urlarr['verify']=$_GET['verify'];
		}
		//��վ---
		if($_SESSION['admin_city']){
			$where.=" and `cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['admin_tcity']){
			$where.=" and `three_cityid`='".$_SESSION['admin_tcity']."'";
		}
		if($_SESSION['admin_hy']){
			$where.=" and `hy`='".$_SESSION['admin_hy']."'";
		}
		if($_SESSION['def_city'] || $_SESSION['def_tcity'] || $_SESSION['def_hy'])
		{
			if($_SESSION['def_city']){
				$session[]="`cityid` in (".$_SESSION['def_city'].")";
			}
			if($_SESSION['def_tcity']){
				$session[]="`three_cityid` in (".$_SESSION['def_tcity'].")";
			}
			if($_SESSION['def_hy']){
				$session[]="`hy` in (".$_SESSION['def_hy'].")";
			}
			$where.=" and (".@implode(" or ",$session).")";
		}
		//��վ---
		if($_GET['order']){
			if($_GET['t']=="time"){
				$where.=" order by `status_time` ".$_GET['order'];
			}else{
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
			}
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by `id` desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
		$rows=$this->get_page("resume_expect",$where,$pageurl,$this->config['sy_listnum']);
		include PLUS_PATH."/job.cache.php";
		include PLUS_PATH."/user.cache.php";
		include PLUS_PATH."/city.cache.php";
		if(is_array($rows)){
			foreach($rows as $k=>$v){
				$rows[$k]['edu_n']=$userclass_name[$v['edu']];
				$rows[$k]['exp_n']=$userclass_name[$v['exp']];
				$rows[$k]['cityid_n']=$city_name[$v['cityid']];
				$rows[$k]['salary_n']=$userclass_name[$v['salary']];
				$rows[$k]['report_n']=$userclass_name[$v['report']];
				$rows[$k]['type_n']=$userclass_name[$v['type']];
				$lt_job = @explode(",",$v['job_classid']);
				$uids[]=$v['uid'];
				if(is_array($lt_job)){
					foreach($lt_job as $key=>$v){
						$jobname[$key]=$v;
					}
					$rows[$k]['jobname']=$job_name[$jobname[0]];
				}

			}
			$member=$this->obj->DB_select_all("member","`uid` in(".@implode(',',$uids).")","`uid`,`username`");
			foreach($rows as $key=>$val){
				foreach($member as $v){
					if($val['uid']==$v['uid']){
						$rows[$key]['username']=$v['username'];
					}
				}
			}
		}
		$this->user_cache();
		$this->yunset("get_type", $_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_height_user'));
	}
	function status_action()
	{
		if($_POST['pid'])
		{
			$this->obj->DB_update_all("resume_expect","`height_status`='".$_POST['status']."',`statusbody`='".$_POST['statusbody']."',`status_time`='".time()."'","`id` IN (".$_POST['pid'].")");
			$this->obj->admin_log("�߼��˲�(ID:".$_POST['pid'].")������óɹ�");
			$this->ACT_layer_msg("������óɹ���",9,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("�������ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function recommend_action(){
		$nid=$this->obj->DB_update_all("resume_expect","`rec`='".$_GET['rec']."'","`id`='".$_GET['id']."'");
		$this->obj->admin_log("�߼��˲�(ID:".$_GET['id'].")�Ƽ��ɹ�");
		echo $nid?1:0;die;
	}

	function del_action(){
		$this->check_token();
		//����ɾ��
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($del)){
					$this->obj->DB_update_all("resume_expect","`height_status`='0'","`id` in(".@implode(',',$del).")");
					$del=@implode(',',$del);
					$layer_type='1';
		    	}else{
		    		$this->obj->DB_update_all("resume_expect","`height_status`='0'","`id`='".$_GET['del']."'");
					$layer_type='0';
		    	}
				$this->layer_msg('�߼��˲�(ID:'.$del.')ɾ���ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('��ѡ����Ҫɾ���ĸ߼��˲ţ�',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
}
?>