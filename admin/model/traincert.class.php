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
class traincert_controller extends common
{
	//���ø߼���������
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'���״̬',"value"=>array("1"=>"�����","3"=>"δ���","2"=>"δͨ��"));
		$search_list[]=array("param"=>"apply","name"=>'����ʱ��',"value"=>array("1"=>"����","3"=>"�������","7"=>"�������","15"=>"�������","30"=>"���һ����"));
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		if($_GET['status']){
			if($_GET['status']=='3'){
				$where=" and a.`status`='0'";
				$urlarr['status']='3';
			}else{
				$where=" and a.`status`='".$_GET['status']."'";
				$urlarr['status']=$_GET['status'];
			}
		}
		if(trim($_GET['keyword'])){
			$where.=" and b.`name` like '%".trim($_GET['keyword'])."%'";
			$urlarr['keyword']=trim($_GET['keyword']);
		}
		if($_GET['apply']){
			if($_GET['apply']=='1'){
				$where.=" and a.`ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and a.`ctime` >= '".strtotime('-'.(int)$_GET['apply'].'day')."'";
			}
			$urlarr['apply']=$_GET['apply'];
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
		if($_GET['order'])
		{
			$where.=" order by a.`".$_GET['t']."` ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by a.`id` desc";
		}
		include(LIB_PATH."page.class.php");
		$limit=$this->config['sy_listnum'];
		$page=$_GET['page']<1?1:$_GET['page'];
		$ststrsql=($page-1)*$limit;
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
		$count=$this->obj->DB_select_alls("company_cert","px_train","a.`uid`=b.`uid` and a.`type`='3' $where","a.uid");//��ȡ����
 		$num = count($count);
 		$page = new page($page,$limit,$num,$pageurl);
		$pagenav=$page->numPage();
		$rows=$this->obj->DB_select_alls("company_cert","px_train","a.`uid`=b.`uid` and a.`type`='3' $where $order limit $ststrsql,$limit","b.name,a.*");
		$this->yunset("pagenav",$pagenav);
		$lotime=array('1'=>'һ��','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$this->yunset("lotime",$lotime);
		$this->yunset("rows",$rows);
		$this->yunset("get_type",$_GET);
		$this->yuntpl(array('admin/admin_train_cert'));
	}
	function sbody_action(){
		$userinfo = $this->obj->DB_select_once("company_cert","`id`=".$_POST['pid'],"`statusbody`");
		echo $userinfo['statusbody'];die;
	}
	function status_action()
	{
		extract($_POST);
		if($pid)
		{
			$company=$this->obj->DB_select_once("px_train","`uid`='".$uid."'","`cert`,`linkmail`,`name`");
			if($status!="1")
			{
				$yyzz_status="0";
			}else{
				$yyzz_status="1";
			}
			$this->obj->DB_update_all("px_train","`yyzz_status`='".$yyzz_status."'","`uid`='".$uid."'");
			$this->obj->DB_update_all("friend_info","`iscert`='".$status."'","`uid`='".$uid."'");
			$id=$this->obj->DB_update_all("company_cert","`status`='".$status."',`statusbody`='".$statusbody."'","`id`='".$pid."'");
			if($this->config['sy_email_comcert']=='1')
			{
				$this->send_msg_email(array("email"=>$company['linkmail'],"certinfo"=>$statusbody,"comname"=>$company['name'],'uid'=>$uid,'name'=>$company['name'],"type"=>"comcert"));
			}
			if($id)
			{
				$this->ACT_layer_msg("��ѵ������֤���(UID:".$uid.")���óɹ���",9,$_SERVER['HTTP_REFERER'],2,1);
			}else{
				$this->ACT_layer_msg("����ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->ACT_layer_msg("�Ƿ�������",8,$_SERVER['HTTP_REFERER']);
		}
	}

	function del_action()
	{
		if(is_array($_POST['del'])){
			$linkid=@implode(',',$_POST['del']);
			$type=1;
		}else{
			$this->check_token();
			$linkid=$_GET['uid'];
			$type=0;
		}
		if($linkid==""){
			$this->layer_msg('��ѡ����Ҫɾ�������ݣ�',8,1,$_SERVER['HTTP_REFERER']);
		}
		$this->obj->DB_update_all("px_train","`yyzz_status`='0'","`uid` in (".$linkid.")");
		$this->obj->DB_update_all("friend_info","`iscert`='0'","`uid` in (".$linkid.")");
	    $cert=$this->obj->DB_select_all("company_cert","`uid` in (".$linkid.") and `type`='3'","`check`");
	    if(is_array($cert))
	    {
	     	foreach($cert as $v)
	     	{
	     		$this->obj->unlink_pic("../".$v['check']);
	     	}
	    }
		$delid=$this->obj->DB_delete_all("company_cert","`uid` in (".$linkid.")  and `type`='3'","");
		$delid?$this->layer_msg('��ѵ������֤(UID:'.$linkid.')ɾ���ɹ���',9,$type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$type,$_SERVER['HTTP_REFERER']);
	}
}

?>