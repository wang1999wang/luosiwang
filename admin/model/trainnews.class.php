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
class trainnews_controller extends common
{
	//���ø߼���������
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'���״̬',"value"=>array("1"=>"�����","3"=>"δ���","2"=>"δͨ��"));
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		if(trim($_GET['keyword']))
		{
			if($_GET['type']=="1"){
				$where=" and b.`name` like '%".trim($_GET['keyword'])."%'";
			}else{
				$where=" and a.`title` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		//��վ---
		if($_SESSION['admin_city'])
		{
			$where.=" and b.`cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['def_city'])
		{
			$where.=" and b.`cityid` in (".$_SESSION['def_city'].")";
		}
		//��վ---
		if($_GET['status']){
			if($_GET['status']=="3"){
				$where.=" and a.`status`='0'";
			}else{
				$where.=" and a.`status`='".$_GET['status']."'";
			}
			$urlarr['status']=$_GET['status'];
		}
		if($_GET['order']){
			$order=$_GET['order'];
		}else{
			$order="desc";
		}
		$urlarr['order']=$_GET['order'];
		include(LIB_PATH."page.class.php");
		$limit=$this->config['sy_listnum'];
		$page=$_GET['page']<1?1:$_GET['page'];
		$ststrsql=($page-1)*$limit;
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
		$count=$this->obj->DB_select_alls("px_train_news","px_train","a.`uid`=b.`uid` $where","a.uid");//��ȡ����
 		$num = count($count);
 		$page = new page($page,$limit,$num,$pageurl);
		$pagenav=$page->numPage();
		$rows=$this->obj->DB_select_alls("px_train_news","px_train","a.`uid`=b.`uid` $where order by a.`id` $order limit $ststrsql,$limit","b.name,a.*");
		$this->yunset("pagenav",$pagenav);
		$this->yunset("rows",$rows);
		$this->yunset("get_type", $_GET);
		$this->yuntpl(array('admin/admin_trainnews'));
	}
	function status_action()
	{
		extract($_POST);
		$id = @explode(",",$pid);
		//$status //0δ���,1ͨ����2�ѹ��ڣ�3δͨ��
		if(is_array($id))
		{
			foreach($id as $value)
			{
				$idlist[] = $value;
			}
			$aid = @implode(",",$idlist);
			$id=$this->obj->DB_update_all("px_train_news","`status`='$status',`statusbody`='".$statusbody."'","`id` IN ($aid)");
 			$id?$this->ACT_layer_msg("��ѵ�������(ID:".$aid.")���óɹ���",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("����ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("�Ƿ�������",9,$_SERVER['HTTP_REFERER']);
		}
	}
	function del_action()
	{
		$this->check_token();
	    if($_GET['del'])
	    {
	    	if(is_array($_GET['del']))
	    	{
	    		$del=@implode(",",$_GET['del']);
	    		$layer_type=1;
	    	}else{
	    		$del=$_GET['del'];
	    		$layer_type=0;
	    	}
	    	$id=$this->obj->DB_delete_all("px_train_news","`id` in (".$del.")","");
			$id?$this->layer_msg('��ѵ����(ID:'.$del.')ɾ���ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$layer_type,$_SERVER['HTTP_REFERER']);
	    }
	}
}
?>