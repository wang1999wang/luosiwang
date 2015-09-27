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
class admin_lt_member_controller extends common
{
	//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"rec","name"=>'推荐状态',"value"=>array("1"=>"已推荐","2"=>"未推荐"));
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","3"=>"未通过","2"=>"未审核"));
		$re_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"register","name"=>'注册时间',"value"=>$re_time);
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"login","name"=>'登录时间',"value"=>$lo_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		if($_GET['username']!=""){
			if($_GET['type']=="1"){
				$where="and b.`username` LIKE'%".$_GET['username']."%'";
			}elseif($_GET['type']=="2"){
				$where="and a.`com_name` LIKE '%".$_GET['username']."%'";
			}elseif($_GET['type']=="3"){
				$where="and b.`email` LIKE '%".$_GET['username']."%'";
			}else{
				$where="and a.`moblie` LIKE '%".$_GET['username']."%'";
			}
			$urlarr['username']=$_GET['username'];
			$urlarr['type']=$_GET['type'];
		}
		if($_GET['login']){
			if($_GET['login']=='1'){
				$where.=" and b.`login_date` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and b.`login_date` >= '".strtotime('-'.(int)$_GET['login'].'day')."'";
			}
			$urlarr['login']=$_GET['login'];
		}
		if($_GET['register']){
			if($_GET['register']=='1'){
				$where.=" and b.`reg_date` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and b.`reg_date` >= '".strtotime('-'.(int)$_GET['register'].'day')."'";
			}
			$urlarr['register']=$_GET['register'];
		}
		if ($_GET['rec']=='1'){
			$where.="and a.`rec`='1'";
			$urlarr['rec']=$_GET['rec'];
		}elseif ($_GET['rec']=='2'){
			$where.="and a.`rec`='0'";
			$urlarr['rec']='2';
		}
		if($_GET['status']){
			if ($_GET['status']=='2'){
				$where.="and b.`status`='0'";
				$urlarr['status']=$_GET['status'];
			}else{
				$where.="and b.`status`='".$_GET['status']."'";
				$urlarr['status']=$_GET['status'];
			}
		}
		//分站---
		if($_SESSION['admin_city']){
			$where.=" and a.`cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['admin_tcity']){
			$where.=" and a.`three_cityid`='".$_SESSION['admin_tcity']."'";
		}
		if($_SESSION['def_city'] || $_SESSION['def_tcity'])
		{
			if($_SESSION['def_city']){
				$session[]="a.`cityid` in (".$_SESSION['def_city'].")";
			}
			if($_SESSION['def_tcity']){
				$session[]="a.`three_cityid` in (".$_SESSION['def_tcity'].")";
			}
			$where.=" and (".@implode(" or ",$session).")";
		}
		//分站---
		if($_GET['order'])
		{
			$where.="order by b.`".$_GET['t']."` ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.="order by b.`uid` desc";
		}
		include(LIB_PATH."page.class.php");
		$limit=$this->config["sy_listnum"];
		$page=$_GET['page']<1?1:$_GET['page'];
		$ststrsql=($page-1)*$limit;
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index","admin_lt_member",$urlarr);
		$count=$this->obj->DB_select_alls("lt_info","member","a.`uid`=b.`uid` and b.usertype='3' $where","a.uid");//获取总数
 		$num = count($count);
 		$page = new page($page,$limit,$num,$pageurl);
		$pagenav=$page->numPage();
		$userrows=$this->obj->DB_select_alls("lt_info","member","a.`uid`=b.`uid` and b.usertype='3' $where limit $ststrsql,$limit","a.*,b.*");
		$this->yunset("pagenav",$pagenav);
		if(is_array($userrows)){
			foreach($userrows as $key=>$value){
				$uid[]=$value['uid'];
			}
			$uid=@implode(",",$uid);
			$statis =$this->obj->DB_select_all("lt_statis","`uid` in ($uid)");
			foreach($userrows as $key=>$value){
				foreach($statis as $k=>$v){
					if($value['uid']==$v['uid']){
						$userrows[$key]['rat_name'] = $v['rating_name'];
						$userrows[$key]['rating'] = $v['rating'];
					}
				}
			}
		}
		$this->yunset("get_type", $_GET['type']);
		$this->yunset("userrows",$userrows);
		$this->yuntpl(array('admin/admin_member_ltlist'));
	}
	function lock_action(){
		$email=$this->obj->DB_select_once("member","`uid`='".$_POST['uid']."'","email");
		$this->obj->DB_update_all("lt_job","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$this->obj->DB_update_all("lt_info","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$id=$this->obj->DB_update_all("member","`status`='".$_POST['status']."',`lock_info`='".$_POST['lock_info']."'","`uid`='".$_POST['uid']."'");
		$name=$this->obj->DB_select_once("lt_info","`uid`='".$_POST['uid']."'","`realname`");
		$this->send_msg_email(array("uid"=>$_POST['uid'],"name"=>$name['realname'],"email"=>$email['email'],"lock_info"=>$_POST['lock_info'],"type"=>"lock"));
		$id?$this->ACT_layer_msg("猎头用户锁定(ID:".$_POST['uid'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function lockinfo_action(){
		$userinfo = $this->obj->DB_select_once("member","`uid`=".$_POST['uid'],"`lock_info`");
		echo $userinfo['lock_info'];die;
	}
	function status_action(){
		$_POST['uid']=(int)$_POST['uid'];
 		$id=$this->obj->DB_update_all("member","`status`='".$_POST['status']."',`lock_info`='".$_POST['statusbody']."'","`uid`='".$_POST['uid']."'");
		$userinfo = $this->obj->DB_select_once("member","`uid`='".$_POST['uid']."'","`email`");
		$name=$this->obj->DB_select_once("lt_info","`uid`='".$_POST['uid']."'","`realname`");
		$this->send_msg_email(array("uid"=>$_POST['uid'],"name"=>$name['realname'],"email"=>$userinfo['email'],"status_info"=>$_POST['statusbody'],"date"=>date("Y-m-d H:i:s"),"type"=>"userstatus"));
 		$id?$this->ACT_layer_msg("猎头用户审核(ID:".$_POST['uid'].")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function edit_action(){
		if((int)$_GET['id']){
			$com_info = $this->obj->DB_select_once("member","`uid`='".$_GET['id']."'");
			$row = $this->obj->DB_select_once("lt_info","`uid`='".$_GET['id']."'");
			$rating_list = $this->obj->DB_select_all("company_rating","`category`='2'");
			$stati = $this->obj->DB_select_once("lt_statis","`uid`='".$_GET['id']."'");
			$this->yunset("statis",$stati);
			$this->yunset("row",$row);
			$this->yunset("rating_list",$rating_list);
			$this->yunset("rating",$_GET['rating']);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
			$this->yunset("com_info",$com_info);
			$CacheArr['ltjob'] =array('ltjob_index','ltjob_type','ltjob_name');
			$CacheArr['city'] =array('city_index','city_type','city_name');
			$CacheArr['lt'] =array('ltdata','ltclass_name');
			$this->CacheInclude($CacheArr);
		}
		if($_POST['com_update']){
			$this->obj->DB_update_all("lt_info","`r_status`='".$_POST["status"]."'","`uid`=".$_POST['uid']." ");
			$this->obj->DB_update_all("lt_job","`r_status`='".$_POST['status']."',`com_name`='".$_POST['com_name']."'","`uid`=".$_POST['uid']." ");
			$post['uid']=$_POST['uid'];
			$post['password']=$_POST['password'];
			$post['email']=$_POST['email'];
			$post['moblie']=$_POST['moblie'];
			$post['status']=$_POST['status'];
			$nid = $this->uc_edit_pw($post,1,"index.php?m=admin_lt_member");
			$values .= "lt_job_num='".$_POST['lt_job_num']."',";
			$values .= "lt_editjob_num='".$_POST['lt_editjob_num']."',";
			$values .= "lt_breakjob_num='".$_POST['lt_breakjob_num']."',";
			$values .= "lt_down_resume='".$_POST['lt_down_resume']."'";
			$this->obj->DB_update_all("lt_statis",$values,"`uid`='".$post['uid']."'");
			unset($_POST['rating_name']);unset($_POST['username']);unset($_POST['password']);unset($_POST['status']);unset($_POST['uid']);unset($_POST['lasturl']);unset($_POST['com_update']);
			unset($_POST[lt_job_num]);unset($_POST[lt_editjob_num]);unset($_POST[lt_breakjob_num]);unset($_POST[lt_down_resume]);
			$this->obj->update_once("lt_info",$_POST,array("uid"=>$post['uid']));
			$lasturl=str_replace("&amp;","&",$_POST['lasturl']);
			$this->ACT_layer_msg("猎头用户(ID:".$post['uid'].")修改成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		$this->yuntpl(array('admin/admin_member_ltedit'));
	}

	function rating_action(){
		$rating_name = $_POST['rat'];
		$rat_arr = @explode("+",$rating_name);
		$statis = $this->obj->DB_select_all("lt_statis","`uid`='".$_POST['uid']."'");
		if(is_array($statis)){
			$value=$this->rating_info($rat_arr[0]);
			$this->obj->DB_update_all("lt_statis",$value,"`uid`='".$_POST['uid']."'");
		}else{
			$value="`uid`='".$_POST['uid']."',";
			$value.=$this->rating_info($rat_arr[0]);
			$this->obj->DB_insert_once("lt_statis",$value);
		}
		echo "1";die;

	}

	function add_action()
	{
		$rating_list = $this->obj->DB_select_all("company_rating","`category`='2'");
		if($_POST['submit'])
		{
			extract($_POST);
			if($username==""||strlen($username)<6||strlen($username)>15)
			{
				$msg = "会员名不能为空或不符合要求！";$type=8;
			}elseif($password==""||strlen($username)<6||strlen($username)>15){
				$msg = "密码不能为空或不符合要求！";$type=8;
			}else{
				if($this->config['sy_uc_type']=="uc_center"){
					$this->obj->uc_open();
					$user = uc_get_user($username);
				}else{
					$user = $this->obj->DB_select_once("member","`username`='$username' OR `email`='$email'");
				}

				if(is_array($user)){
					$msg = "用户名或邮箱已存在！";$type=8;
				}else{
					$ip = $this->obj->fun_ip_get();
					$time = time();
					if($this->config['sy_uc_type']=="uc_center")
					{
						$uid=uc_user_register($_POST['username'],$_POST['password'],$_POST['email']);
						if($uid<0)
						{
							$this->ACT_layer_msg("该邮箱已存在！",8,"index.php?m=admin_lt_member&c=add");
						}else{
							list($uid,$username,$email,$password,$salt)=uc_get_user($username);
							$value = "`username`='$username',`password`='$password',`email`='$email',`usertype`='3',`address`='$address',`status`='$satus',`salt`='$salt',`moblie`='$moblie',`reg_date`='$time',`reg_ip`='$ip'";
						}
					}else{
						$salt = substr(uniqid(rand()), -6);
						$pass = md5(md5($password).$salt);
						$value = "`username`='$username',`password`='$pass',`email`='$email',`usertype`='3',`address`='$address',`status`='$satus',`salt`='$salt',`moblie`='$moblie',`reg_date`='$time',`reg_ip`='$ip'";

					}
					$nid = $this->obj->DB_insert_once("member",$value);
					$new_info = $this->obj->DB_select_once("member","`username`='$username'");
					$uid = $new_info["uid"];
					if($uid>0)
					{
						$this->obj->DB_insert_once("lt_info","`uid`='$uid',`moblie`='$moblie',`email`='$email'");
						$rat_arr = @explode("+",$rating_name);
						$value = "`uid`='$uid',";
						$value.=$this->rating_info($rat_arr[0]);
						$this->obj->DB_insert_once("lt_statis",$value);
						$this->obj->DB_insert_once("friend_info","`uid`='".$uid."',`nickname`='$username',`usertype`='3'");
						$msg="猎头会员(ID:".$uid.")添加成功";$type=9;
					}
				}
			}
			$this->ACT_layer_msg($msg,$type,"index.php?m=admin_lt_member&c=add",2,1);
			die;
		}
		$this->yunset("rating_list",$rating_list);
		$this->yuntpl(array('admin/admin_member_ltadd'));
	}
	function rating_info($id)
	{
		$row = $this->obj->DB_select_once("company_rating","`id`='$id'");
		$value="`rating`='$id',";
		$value.="`integral`='".$this->config['integral_reg']."',";
		$value.="`rating_name`='".$row['name']."',";
		$value.="`rating_type`='".$row['type']."',";
		$value.="`lt_job_num`='".$row['lt_job_num']."',";
		$value.="`lt_down_resume`='".$row['lt_resume']."',";
		$value.="`lt_editjob_num`='".$row['lt_editjob_num']."',";
		$value.="`lt_breakjob_num`='".$row['lt_breakjob_num']."',";
		if($row['service_time']>0)
		{
			$time=time()+86400*$row['service_time'];
		}else{
			$time=0;
		}
		$value.="`vip_etime`='$time'";
		//赠送优惠券
		if($row['coupon']>0)
		{
			$coupon=$this->obj->DB_select_once("coupon","`id`='".$row['coupon']."'");
			$data.="`uid`='".$this->uid."',";
			$data.="`number`='".time()."',";
			$data.="`ctime`='".time()."',";
			$data.="`coupon_id`='".$coupon['id']."',";
			$data.="`coupon_name`='".$coupon['name']."',";
			$validity=time()+$coupon['time']*86400;
			$data.="`validity`='".$validity."',";
			$data.="`coupon_amount`='".$coupon['amount']."',";
			$data.="`coupon_scope`='".$coupon['scope']."'";
			$this->obj->DB_insert_once("coupon_list",$data);
		}
		return $value;
	}

	function del_action()
	{
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if($del){
	    		if(is_array($_GET['del'])){
					$layer_type='1';
	    			$uids = @implode(",",$_GET['del']);
					$del=$uids ;
					$photo = $this->obj->DB_select_all("lt_info","`uid` in (".$uids.") and `photo`<>''");
					if(is_array($photo))
					{
				    	foreach($photo as $val)
				    	{
				    		$this->obj->unlink_pic(".".$val['photo']);
				    		$this->obj->unlink_pic(".".$val['thumb']);
				    	}
					}
					$friend_pic = $this->obj->DB_select_all("friend_info","`uid` in (".$uids.") and `pic`<>''");
					if(is_array($friend_pic))
					{
				    	foreach($friend_pic as $val)
				    	{
				    		$this->obj->unlink_pic($val['pic']);
				    		$this->obj->unlink_pic($val['pic_big']);
				    	}
					}
					$del_array=array("member","lt_info","lt_job","lt_statis","friend_state","friend_info","question","company_order","attention","px_zixun","px_subject_collect");
					foreach($del_array as $value)
					{
						$this->obj->DB_delete_all($value,"`uid` in (".$uids.")","");
					}
					$this->obj->DB_delete_all("msg","`job_uid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend","`uid` in (".$uids.") or `nid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_reply","`uid` in (".$uids.") or `fid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_foot","`uid` in (".$uids.") or `fid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_im_list","`uid` in (".$uids.") or `touid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_message","`uid` in (".$uids.") or `fid` in (".$uids.")","");
					$this->obj->DB_delete_all("atn","`uid` in (".$uids.") or `scid` in (".$uids.")","");
					$this->obj->DB_delete_all("userid_job","`comid` in (".$uids.")","");
					$this->obj->DB_delete_all("down_resume","`comid` in (".$uids.")","");
					$this->obj->DB_delete_all("company_pay","`com_id` in (".$uids.")","");
					$this->obj->DB_delete_all("message","`uid` in (".$uids.") or `fa_uid` in (".$uids.")","");
					$this->obj->DB_delete_all("rebates","`job_uid` in (".$uids.") or `uid` in (".$uids.")"," ");
		    	}else{
					$layer_type='0';
		    		$photo = $this->obj->DB_select_once("lt_info","`uid`='$del' and `photo`!=''");
		    		if(is_array($photo)){
	    	    		$this->obj->unlink_pic(".".$photo['photo']);
	    	    		$this->obj->unlink_pic(".".$photo['photo_big']);
		    		}
		    		$friend_pic = $this->obj->DB_select_once("friend_info","`uid`='$del' and `pic`!=''");
		    		if(is_array($friend_pic)){
	    	    		$this->obj->unlink_pic($friend_pic['pic']);
	    	    		$this->obj->unlink_pic($friend_pic['pic_big']);
		    		}
					$del_array=array("member","lt_info","lt_job","lt_statis","friend_state","friend_info","question","company_order","attention","px_zixun","px_subject_collect");
					foreach($del_array as $value){
						$this->obj->DB_delete_all($value,"`uid`='".$del."'","");
					}
					$this->obj->DB_delete_all("msg","`job_uid`='$del'","");
					$this->obj->DB_delete_all("friend","`uid`='$del' or `nid`='$del'","");
					$this->obj->DB_delete_all("friend_reply","`uid`='$del' or `fid`='$del'","");
					$this->obj->DB_delete_all("friend_foot","`uid`='$del' or `fid`='$del'","");
					$this->obj->DB_delete_all("friend_im_list","`uid`='$del' or `touid`='$del'","");
					$this->obj->DB_delete_all("friend_message","`uid`='$del' or `fid`='$del'","");
					$this->obj->DB_delete_all("atn","`uid`='$del' or `scid`='$del'","");
					$this->obj->DB_delete_all("userid_job","`comid`='$del'","");
					$this->obj->DB_delete_all("down_resume","`comid`='$del'","");
					$this->obj->DB_delete_all("company_pay","`com_id`='$del'","");
					$this->obj->DB_delete_all("message","`uid`='$del' or `fa_uid`='$del'","");
					$this->obj->DB_delete_all("rebates","`job_uid`='$del' or `uid` ='$del'"," ");

		    	}
				$this->layer_msg('猎头会员(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的会员！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
	function lt_rec_action(){
		$this->check_token();
		$nid=$this->obj->DB_update_all("lt_info","`".$_GET['type']."`='".$_GET['rec']."'","`uid`='".$_GET['id']."'");
		$this->obj->admin_log("猎头会员(ID:".$_GET['id'].")推荐设置成功！");
		echo $nid?1:0;die;
	}
	function recup_action(){
		extract($_GET);
		$this->check_token();
		if($id){
			$nid=$this->obj->DB_update_all("member","`$type`='".$rec."'","`uid`='$id'");
			echo $nid?1:0;die;
		}
	}
}
?>