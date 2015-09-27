<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2015 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class teacher_controller extends common
{
	//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","3"=>"未审核","2"=>"未通过"));
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		$where = "1";
		if(trim($_GET['keyword'])){
			$where .= " AND `name` like '%".trim($_GET['keyword'])."%' ";
			$urlarr['keyword']=trim($_GET['keyword']);
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
		$rows=$this->get_page("px_teacher",$where,$pageurl,$this->config['sy_listnum']);
		$this->yunset("rows",$rows);
		$this->city_cache();
		$this->industry_cache();
		$this->subject_cache();
		$this->yunset("get_type",$_GET);
		$this->yuntpl(array('admin/admin_teacher'));
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
			$id=$this->obj->DB_update_all("px_teacher","`status`='$status',`statusbody`='".$statusbody."'","`id` IN ($aid)");
 			$id?$this->ACT_layer_msg("培训师审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",9,$_SERVER['HTTP_REFERER']);
		}				
	/*	
		
		$id=$this->obj->DB_update_all("px_teacher","`status`='".$_POST['status']."',`statusbody`='".$_POST['statusbody']."'","`id`='".$_POST['id']."'");
		if($id)
		{
			$this->obj->admin_log("培训师审核(ID:".$_GET['id'].")状态设置成功！");
			$this->ACT_layer_msg("审核设置成功！",9,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("审核设置成功！",9,$_SERVER['HTTP_REFERER']);
		}
		*/
	}

	function add_action()
	{
		if($_POST['update'])
		{
			$_POST=$this->post_trim($_POST);
			if($_FILES['pic']['tmp_name'])
			{
				$upload=$this->upload_pic("../data/upload/team/",false);
				$pic=$upload->picture($_FILES['pic']);
				$this->picmsg($pic,$_SERVER['HTTP_REFERER']);
				$_POST['pic'] = str_replace("../data/upload/team","upload/team",$pic);
				$rows=$this->obj->DB_select_once("px_teacher","`uid`='".$this->uid."' and `pic`<>''");
				if(is_array($rows))
				{
					$this->obj->unlink_pic("../".$rows['pic']);
				}
			}
			$_POST['content']=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'background-color:','background-color:','white-space:'),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
			$where['id']=$_POST['id'];
			$nid=$this->obj->update_once("px_teacher",$_POST,$where);
			if($nid)
			{
				$this->ACT_layer_msg("更新成功！",9,"index.php?m=teacher");
			}else{
				$this->ACT_layer_msg("更新失败！",8,"index.php?m=teacher");
			}
		}
		if($_GET['id'])
		{
			$row=$this->obj->DB_select_once("px_teacher","`id`='".$_GET['id']."'");
			$this->yunset("row",$row);
		}
		$this->subject_cache();
		$this->industry_cache();
		$this->city_cache();
		$this->yuntpl(array('admin/admin_teacher_add'));
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
			$id=$this->obj->DB_delete_all("px_teacher","`id` in (".$del.")"," ");
			$del?$this->layer_msg('培训师(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择要删除的内容！',8,0,$_SERVER['HTTP_REFERER']);
		}
	}


}