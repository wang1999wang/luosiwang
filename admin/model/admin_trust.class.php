<?php
class admin_trust_controller extends common
{
		//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","3"=>"未审核","2"=>"未通过"));
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"time","name"=>'发布时间',"value"=>$lo_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		$where='1';
		if($_GET["status"] ){
			if($_GET["status"]==3){
				$where.=" and `status`=0";
			}else{
				$where.=" and `status`='".$_GET["status"]."'";
			}
			$urlarr["status"]=$_GET["status"];
		}
		if($_GET['time']){
			if($_GET['time']=='1'){
				$where.=" and `add_time` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `add_time` >= '".strtotime('-'.(int)$_GET['time'].'day')."'";
			}
			$urlarr['time']=$_GET['time'];
		}
		if($_GET["keyword"]!=""){
			if ($_GET['type']=='1'){
				$where.=" and `username` like '%".trim($_GET["keyword"])."%'";
			}elseif ($_GET['type']=='2'){
				$trustinfo=$this->obj->DB_select_all("resume_expect","`name` like '%".trim($_GET["keyword"])."%'","`uid`");
				if (is_array($trustinfo)){
					foreach ($trustinfo as $val){
						$trustuids[]=$val['uid'];
					}
					$trustuid=@implode(",",$trustuids);
				}
				$where.=" and `uid` in (".$trustuid.") ";
			}
			$urlarr["type"]=$_GET["type"];
			$urlarr["keyword"]=$_GET["keyword"];
		}
		//分站---
		$wheres.=1;
		if($_SESSION['admin_city']){
			$wheres.=" and `cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['admin_tcity']){
			$wheres.=" and `three_cityid`='".$_SESSION['admin_tcity']."'";
		}
		if($_SESSION['admin_hy']){
			$wheres.=" and `hy`='".$_SESSION['admin_hy']."'";
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
			$wheres.=" and (".@implode(" or ",$session).")";
		}
		$resume_expect=$this->obj->DB_select_all("resume_expect",$wheres,"`id`,`name`");
		if(is_array($resume_expect))
		{
			foreach($resume_expect as $v)
			{
				$eid[]=$v['id'];
			}
			$eid=@implode(",",$eid);
		}
		$where.=" and `eid` in (".$eid.")";
		//分站---
		if($_GET['order']){
			$where.=" order by `".$_GET['order']."`";
			$urlarr["order"]=$_GET["order"];
		}else{
			$where.=" order by `add_time` ";
		}
		if($_GET['desc']){
			$where.=$_GET['desc'];
			$urlarr["desc"]=$_GET["desc"];
		}else{
			$where.=" desc";
		}
		$urlarr["page"]="{{page}}";
		$pageurl=$this->url("index",$_GET["m"],$urlarr);
        $M=$this->MODEL();
		$PageInfo=$M->get_page("user_entrust",$where,$pageurl,$this->config["sy_listnum"]);
        $this->yunset($PageInfo);
        $rows=$PageInfo['rows'];
		if(is_array($rows))
		{
			foreach($rows as $key=>$value)
			{
				foreach($resume_expect as $val)
				{
					if($value['eid']==$val['id'])
					{
						$rows[$key]['name']=$val['name'];
					}
				}
			}
		}
		$this->yunset("get_info",$_GET);
		$this->yunset("rows",$rows);
		$this->yuntpl(array('admin/admin_trust'));
	}
	function status_action(){
		extract($_POST);
		$user_entrust = $this->obj->DB_select_once("user_entrust","`id`='".$pid."'");
		if($status=='2'){
			$this->obj->DB_update_all("resume_expect","`is_entrust`='0'","`uid`='".$user_entrust['uid']."' and `id`='".$user_entrust['eid']."'");
			if($user_entrust['0']){
				$this->obj->DB_update_all("member_statis","`pay`=`pay`+'".$user_entrust['price']."'","`uid`='".$user_entrust['uid']."'");
			}
		}else{
			$this->obj->DB_update_all("resume_expect","`is_entrust`=".$status,"`uid`='".$user_entrust['uid']."' and `id`='".$user_entrust['eid']."'");
		}
		$id=$this->obj->DB_update_all("user_entrust","`status`='$status'","`uid`='".$user_entrust['uid']."' and `id`='".$pid."'");
 		$id?$this->ACT_layer_msg( "委托简历审核(ID:".$user_entrust['id'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function recom_action(){
		$CacheArr['job'] =array('job_index','job_type','job_name');
		$CacheArr['com'] =array('comdata','comclass_name');
		$CacheArr['city'] =array('city_index','city_type','city_name');
		$this->CacheInclude($CacheArr);
		$urlarr['c']='recom';
		$row=$this->obj->DB_select_once("resume_expect","`id`='".$_GET['eid']."'");
		$user_entrust=$this->obj->DB_select_once("user_entrust","`id`='".$_GET['id']."'");
		$record=$this->obj->DB_select_all("user_entrust_record","`eid`='".$_GET['eid']."'","`jobid`");
		if(is_array($record))
		{
			foreach($record as $v)
			{
				$jobid[]=$v['jobid'];
			}
		}
		$where="`state`='1' and `edate`>'".time()."'";
		$urlarr['eid']=$_GET['eid'];
		$urlarr['id']=$_GET['id'];
		if($row['provinceid']){
			$where.=" and `provinceid`='".$row['provinceid']."'";
			$urlarr['provinceid']=$_GET['provinceid'];
		}

		if(is_array($jobid)){
			$where.=" and `id` not in (".@implode(",",$jobid).")";
		}
		if($_GET['salary']){
			$where.=" and `salary`='".$_GET['salary']."'";
			$urlarr['salary']=$_GET['salary'];
		}
		$urlarr["page"]="{{page}}";
		$pageurl=$this->url('index','admin_trust',$urlarr);
        $M=$this->MODEL();
		$rows=$M->get_page("company_job",$where,$pageurl,$this->config['sy_listnum'],"`uid`,`name`,`hy`,`job1`,`job1_son`,`provinceid`,`cityid`,`salary`,`job_post`,`id`");
		if($rows&&is_array($rows)){
			foreach($rows as $val){
				$uids[]=$val['uid'];
			}
			$company=$M->DB_select_all("company","`uid` in(".@implode(',',$uids).")","`uid`,`name`,`linkmail`");
			foreach($rows as $key=>$val){
				foreach($company as $value){
					if($val['uid']==$value['uid']){
						$rows[$key]['bname']=$value['name'];
						$rows[$key]['mail']=$value['linkmail'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("row",$row);
		$this->yuntpl(array('admin/admin_trust_recom'));
	}
	function directrecom_action()
	{//charge 收费推荐 direct 直接推荐
		$smtp = $this->email_set();
		$smtpusermail =$this->config['sy_smtpemail'];
		
 		if($_GET['eid']&&$_GET['jobid'])
 		{
 			$row=$this->obj->DB_select_once("user_entrust_record","`jobid`='".$_GET['jobid']."' and `eid`='".$_GET['eid']."'");
			if(!empty($row)){
				$arr['msg']=iconv('gbk','utf-8','请勿重复推荐！');
				$arr['type']='8';
			}
			$linkmail=$this->obj->DB_select_once("company","`uid`='".$_GET['comid']."'","`linkmail`,`uid`");

			if($this->config["sy_smtpserver"]=="" || $this->config["sy_smtpemail"]=="" || $this->config["sy_smtpuser"]==""){

				$this->obj->get_admin_msg($_SERVER['HTTP_REFERER'],"您还没有配置邮件服务器！");
			}
			$contents=file_get_contents($this->config['sy_weburl']."/index.php?m=resume&c=sendresume&id=".$_GET['eid']."&type=charge");
			$sendid = $smtp->sendmail($linkmail['linkmail'],$smtpusermail,$this->config['sy_webname']."向您推荐了简历！",$contents,"HTML");
			if($sendid){
				$this->obj->DB_insert_once("user_entrust_record","`jobid`='".$_GET['jobid']."',`eid`='".$_GET['eid']."',`comid`='".$_GET['comid']."',`ctime`='".time()."'");
				$arr['msg']=iconv('gbk','utf-8','邮件发送成功！');
				$arr['type']='9';
			}else{
				$arr['msg']=iconv('gbk','utf-8','邮件发送错误(原因：1邮箱不可用；2网站关闭邮件服务)');
				$arr['type']='8';
			}

			echo json_encode($arr);die;
		}
	}
	function del_action(){
		$this->check_token();
		if(is_array($_GET['del'])){
			$linkid=@implode(',',$_GET['del']);
			$layer_type=1;
		}else if($_GET["id"]){
			$linkid=$_GET["id"];
			$layer_type=0;
		}
		$eid=$this->obj->DB_select_all("user_entrust","`id` in (".$linkid.")","`eid`");

		if(is_array($eid)&&$eid){
			foreach($eid as $val){
				$eids[]=$val['eid'];
			}
			$this->obj->DB_update_all("resume_expect","`is_entrust`='0'","`id` in(".@implode(',',$eids).")");
		}
		$del=$this->obj->DB_delete_all("user_entrust","`id` in (".$linkid.")","");
		$del?$this->layer_msg('委托简历(ID:'.$linkid.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	}

}

?>