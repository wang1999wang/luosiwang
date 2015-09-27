<?php
class admin_subject_controller extends common
{
	//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"rec","name"=>'是否推荐',"value"=>array("1"=>"已推荐","2"=>"未推荐"));
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","3"=>"未审核","2"=>"未通过"));
		$search_list[]=array("param"=>"publish","name"=>'发布时间',"value"=>array("1"=>"今天","3"=>"最近三天","7"=>"最近七天","15"=>"最近半月","30"=>"最近一个月"));
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		$where = "1";
		if(trim($_GET['keyword'])){
			if($_GET['type']=='1'){
				$where .= " AND `name` like '%".trim($_GET['keyword'])."%' ";
			}
			if($_GET['type']=='2'){
				$where .= " AND `address` like '%".trim($_GET['keyword'])."%' ";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['status'])
		{
			if($_GET['status']=="1")
			{
				$where .= " and `status`='1'";
			}elseif($_GET['status']=="2"){
				$where .= " and `status`='2'";
			}else{
				$where .= " and `status`='0'";
			}
			$urlarr['status']=$_GET['status'];
		}
		if($_GET['publish']){
			if($_GET['publish']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.(int)$_GET['publish'].'day')."'";
			}
			$urlarr['publish']=$_GET['publish'];
		}
		if($_GET['rec'])
		{
			if($_GET['rec']=="2"){
				$where .= " and `rec`='0'";
			}else{
				$where .= " and `rec`='".$_GET['rec']."'";
			}
			$urlarr['rec']=$_GET['rec'];
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
        $M=$this->MODEL();
		$PageInfo=$M->get_page("px_subject",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $rows=$PageInfo['rows'];
		include PLUS_PATH."/city.cache.php";
		if(is_array($rows))
		{
			foreach($rows as $k=>$v)
			{
				$rows[$k]['provinceid']=$city_name[$v['provinceid']];
				$rows[$k]['cityid']=$city_name[$v['cityid']];
			}
		}
		$lotime=array('1'=>'一天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$this->yunset("lotime",$lotime);
		$this->yunset("rows",$rows);
		$this->yunset("get_type",$_GET);
		$this->yuntpl(array('admin/admin_subject'));
	}
	function status_action()
	{		
		extract($_POST);
		$id = @explode(",",$id);		
		if(is_array($id))
		{
			foreach($id as $value)
			{
				$idlist[] = $value;
			}
			$aid = @implode(",",$idlist);
			$id=$this->obj->DB_update_all("px_subject","`status`='$status',`statusbody`='".$statusbody."'","`id` IN ($aid)");
 			$id?$this->ACT_layer_msg("培训课程审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",9,$_SERVER['HTTP_REFERER']);
		}		
		
		
		
	/*	
		
		$id=$this->obj->DB_update_all("px_subject","`status`='".$_POST['status']."',`statusbody`='".$_POST['statusbody']."'","`id`='".$_POST['id']."'");
		if($id)
		{
			$this->obj->admin_log("培训课程审核(ID:".$_GET['id'].")状态设置成功！");
			$this->ACT_layer_msg("审核设置成功！",9,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("审核设置成功！",9,$_SERVER['HTTP_REFERER']);
		}
		*/
	}
	function rec_action()
	{
		$this->check_token();
		$nid=$this->obj->DB_update_all("px_subject","`".$_GET['type']."`='".$_GET['rec']."'","`id`='".$_GET['id']."'");
		$this->obj->admin_log("培训课程推荐(ID:".$_GET['id'].")设置成功");
		echo $nid?1:0;die;
	}

	function add_action()
	{
		if($_POST['update'])
		{
			$_POST=$this->post_trim($_POST);
			if($_FILES['pic']['tmp_name'])
			{
				$upload=$this->upload_pic("../data/upload/subject/",false);
				$pic=$upload->picture($_FILES['pic']);
				$this->picmsg($pic,$_SERVER['HTTP_REFERER']);
				$_POST['pic'] = str_replace("../data/upload/subject","data/upload/subject",$pic);
				$rows=$this->obj->DB_select_once("px_subject","`uid`='".$this->uid."' and `pic`<>''");
				if(is_array($rows))
				{
					$this->obj->unlink_pic("../".$rows['pic']);
				}
			}
			if($_POST['type'])
			{
				$_POST['type']=@implode(",",$_POST['type']);
			}
			$_POST['content']=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
			$where['id']=$_POST['id'];
			$nid=$this->obj->update_once("px_subject",$_POST,$where);
			if($nid)
			{
				$this->ACT_layer_msg("更新成功！",9,"index.php?m=admin_subject");
			}else{
				$this->ACT_layer_msg("更新失败！",8,"index.php?m=admin_subject");
			}
		}
		if($_GET['id'])
		{
			$row=$this->obj->DB_select_once("px_subject","`id`='".$_GET['id']."'");
			$row['type']=@explode(",",$row['type']);
			$this->yunset("row",$row);
		}
		$this->subject_cache();
		$this->subject_type_cache();
		$this->city_cache();
		$this->yuntpl(array('admin/admin_subject_add'));
	}
	function del_action()
	{
		if($_GET['del'])
		{
			$this->check_token();
			$del=$_GET['del'];
			if(is_array($del)){
				$del=@implode(',',$del);
				$layer_type=1;
			}else{
				$layer_type=0;
			}
			$id=$this->obj->DB_delete_all("px_subject","`id` in (".$del.")"," ");
			$del?$this->layer_msg('培训课程(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择要删除的内容！',8,0,$_SERVER['HTTP_REFERER']);
		}
	}


}