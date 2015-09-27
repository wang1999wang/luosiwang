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
class admin_lt_cert_controller extends common
{
	//���ø߼���������
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'���״̬',"value"=>array("1"=>"�����","2"=>"δͨ��","0"=>"δ���"));
		$ad_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$search_list[]=array("param"=>"end","name"=>'����ʱ��',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		if($_GET['status']!=""){
			$where=" and a.`status`='".$_GET['status']."'";
			$urlarr['status']=$_GET['status'];
		}
		if($_GET['keyword']){
			$where.=" and b.`realname` like '%".$_GET['keyword']."%'";
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		//��վ---
		if($_SESSION['admin_city']){
			$where.=" and b.`cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['admin_tcity']){
			$where.=" and b.`three_cityid`='".$_SESSION['admin_tcity']."'";
		}
		if($_SESSION['def_city'] || $_SESSION['def_tcity'])
		{
			if($_SESSION['def_city']){
				$session[]="b.`cityid` in (".$_SESSION['def_city'].")";
			}
			if($_SESSION['def_tcity']){
				$session[]="b.`three_cityid` in (".$_SESSION['def_tcity'].")";
			}
			$where.=" and (".@implode(" or ",$session).")";
		}
		//��վ---
		if($_GET['order'])
		{
			$where.=" order by a.".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by a.`id` desc";
		}

		include(LIB_PATH."page.class.php");
		$limit=$this->config["sy_listnum"];
		$page=$_GET['page']<1?1:$_GET['page'];
		$ststrsql=($page-1)*$limit;
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
		$count=$this->obj->DB_select_alls("company_cert","lt_info","a.`uid`=b.`uid` and a.`type`='4' $where","a.uid");//��ȡ����
 		$num = count($count);
 		$page = new page($page,$limit,$num,$pageurl);
		$pagenav=$page->numPage();
		$rows=$this->obj->DB_select_alls("company_cert","lt_info","a.`uid`=b.`uid` and a.`type`='4' $where limit $ststrsql,$limit","b.realname,a.*");

		$this->yunset("pagenav",$pagenav);

		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_lt_cert'));
	}
	function status_action()
	{
		if($_POST['uid'])
		{
			$ltlist=$this->obj->DB_select_all("lt_info","`uid` in (".$_POST['uid'].")","`email`,`uid`,`realname`,`rzid`");
		}else{
			$this->ACT_layer_msg("�Ƿ�������",8,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['status']!="1"){
			$cert_status=0;
		}else{
			$cert_status=1;
		}
		if(is_array($ltlist))
		{
			foreach($ltlist as $v)
			{
				$ulen=9-strlen($v['uid']);
				$uid=$v['uid'];
				for($a=1;$a<$ulen;$a++){
					$uid="0".$uid;
				}
				$rzid="YLT".$uid;
				$this->obj->DB_update_all("lt_info","`yyzz_status`='".$cert_status."',`rzid`='".$rzid."'","`uid`='".$uid."'");
				$this->send_msg_email(array("uid"=>$v['uid'],"name"=>$v['realname'],"email"=>$v['email'],"certinfo"=>$_POST['statusbody'],"comname"=>$v['realname'],"type"=>"comcert"));
 				if($v['rzid']=="" && $_POST['status']=="1")
 				{
 					$this->get_integral_action($v['uid'],"integral_ltcert","��ͷִ����֤");
 				}
			}
		}
		$this->obj->DB_update_all("friend_info","`iscert`='".$_POST['status']."'","`uid` in (".$_POST['uid'].")");
		$id=$this->obj->DB_update_all("company_cert","`status`='".$_POST['status']."',`statusbody`='".$_POST['statusbody']."'","`uid` IN (".$_POST['uid'].") and `type`='4'");
		if($id)
		{
			$this->ACT_layer_msg("��ͷ��֤(UID:".$_POST['status'].")���óɹ���",9,$_SERVER['HTTP_REFERER'],2,1);
		}else{
			$this->ACT_layer_msg("����ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function lockinfo_action(){
		$userinfo = $this->obj->DB_select_once("company_cert","`uid`='".$_POST['uid']."' and `type`='4'","`statusbody`");
		echo $userinfo['statusbody'];die;
	}
	function del_action(){
		extract($_POST);
		if(is_array($del)){
			$linkid=@implode(',',$del);
			$layer_type='1';
		}else{
			$this->check_token();
			$linkid=$_GET['id'];
			$layer_type='0';
		}
		if($linkid==""){
			$this->layer_msg("��ѡ����Ҫɾ������Ϣ��",8,1,$_SERVER['HTTP_REFERER']);
		}
	    $cert=$this->obj->DB_select_all("company_cert","`id` in (".$linkid.") and `type`='4'");
	    if(is_array($cert)){
	     	foreach($cert as $v){
	     		$this->obj->unlink_pic("../".$v['check']);
	     		$uid[]=$v['uid'];
	     	}
	    }
	    $this->obj->DB_update_all("lt_info","`yyzz_status`='0'","`uid` in (".$uid.")");
		$delid=$this->obj->DB_delete_all("company_cert","`id` in (".$linkid.")","");
 		isset($delid)?$this->layer_msg('��ͷ��֤(ID:'.$linkid.')ɾ���ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}

}

?>