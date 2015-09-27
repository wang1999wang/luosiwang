<?php
/*
* $Author ��PHPYUN�����Ŷ�
*
* ����: http://www.phpyun.com
*
* ��Ȩ���� 2009-2015 ��Ǩ�γ���Ϣ�������޹�˾������������Ȩ����
*
* ���������δ����Ȩǰ���£�����������ҵ��Ӫ�����ο����Լ��κ���ʽ���ٴη�����
 */
class teacher_controller extends common
{
	//���ø߼���������
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'���״̬',"value"=>array("1"=>"�����","3"=>"δ���","2"=>"δͨ��"));
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
 			$id?$this->ACT_layer_msg("��ѵʦ���(ID:".$aid.")���óɹ���",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("����ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("�Ƿ�������",9,$_SERVER['HTTP_REFERER']);
		}				
	/*	
		
		$id=$this->obj->DB_update_all("px_teacher","`status`='".$_POST['status']."',`statusbody`='".$_POST['statusbody']."'","`id`='".$_POST['id']."'");
		if($id)
		{
			$this->obj->admin_log("��ѵʦ���(ID:".$_GET['id'].")״̬���óɹ���");
			$this->ACT_layer_msg("������óɹ���",9,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("������óɹ���",9,$_SERVER['HTTP_REFERER']);
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
				$this->ACT_layer_msg("���³ɹ���",9,"index.php?m=teacher");
			}else{
				$this->ACT_layer_msg("����ʧ�ܣ�",8,"index.php?m=teacher");
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
			$del?$this->layer_msg('��ѵʦ(ID:'.$del.')ɾ���ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('��ѡ��Ҫɾ�������ݣ�',8,0,$_SERVER['HTTP_REFERER']);
		}
	}


}