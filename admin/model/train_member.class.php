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
class train_member_controller extends common
{
	//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"rec","name"=>'推荐状态',"value"=>array("1"=>"已推荐","2"=>"未推荐"));
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","4"=>"未审核","3"=>"未通过","2"=>"锁定"));
		$re_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"r_time","name"=>'注册时间',"value"=>$re_time);
		$last_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"l_time","name"=>'最近登录时间',"value"=>$last_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		$where="`usertype`='4' ";
		if(trim($_GET['keyword']))
		{
			if($_GET['type']=="1")
			{
				$where .=" and `username` LIKE'%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=='3'){
				$where .=" and `email` LIKE'%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=='4'){
				$where .=" and `moblie` LIKE'%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=="2"){
				$cwhere="`name` LIKE'%".trim($_GET['keyword'])."%'";
				//分站
				if($_SESSION['admin_city'])
				{
					$cwhere.=" and `cityid`='".$_SESSION['admin_city']."'";
				}
				if($_SESSION['def_city'])
				{
					$cwhere.=" and `cityid` in (".$_SESSION['def_city'].")";
				}
				//分站
				$train=$this->obj->DB_select_all("px_train",$cwhere,"`uid`,`name`,`rec`,email_status,moblie_status,yyzz_status");
				if(is_array($train))
				{
					foreach($train as $v)
					{
						$uid[]=$v['uid'];
					}
				}
				$where.=" and `uid` in (".@implode(",",$uid).")";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['l_time']){
			if($_GET['l_time']=='1'){
				$where.=" and `login_date` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `login_date` >= '".strtotime('-'.(int)$_GET['l_time'].'day')."'";
			}
			$urlarr['l_time']=$_GET['l_time'];
		}
		if($_GET['r_time']){
			if($_GET['r_time']=='1'){
				$where.=" and `reg_date` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `reg_date` >= '".strtotime('-'.(int)$_GET['r_time'].'day')."'";
			}
			$urlarr['r_time']=$_GET['r_time'];
		}
		if($_GET['status'])
		{
			if($_GET['status']=="1")
			{
				$where .= " and `status`='1'";
			}elseif($_GET['status']=="3"){
				$where .= " and `status`='3'";
			}elseif($_GET['status']=="2"){
				$where .= " and `status`='2'";
			}else{
				$where .= " and `status`='0'";
			}
			$urlarr['status']=$_GET['status'];
		}
		if($_GET['rec'])
		{
			if($_GET['rec']=='2'){
				$re='0';
			}else{
				$re=$_GET['rec'];
			}
            $rec=$this->obj->DB_select_all("px_train","`rec`='".$re."'","`uid`");
            if(is_array($rec) && !empty($rec)){
            	foreach($rec as $v){
            		$r_uid[]=$v['uid'];
            	}
            	$r_uids=@implode(",",$r_uid);
            }
			$where .= " and `uid` in ($r_uids)";
		}
		if($_GET['order']){
			$where1.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by `uid` desc";
		}
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index","train_member",$urlarr);
		$userrows=$this->get_page("member",$where,$pageurl);
		if(is_array($userrows))
		{
			if($_GET['type']!="2" || !$_GET['keyword'])
			{
				foreach($userrows as $v)
				{
					$uid[]=$v['uid'];
				}
				$train=$this->obj->DB_select_all("px_train","`uid` in (".@implode(",",$uid).")","uid,name,rec,email_status,moblie_status,yyzz_status");
			}
			foreach($userrows as $k=>$v)
			{
				foreach($train as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$userrows[$k]['train_name']=$val['name'];
						$userrows[$k]['email_status']=$val['email_status'];
						$userrows[$k]['moblie_status']=$val['moblie_status'];
						$userrows[$k]['yyzz_status']=$val['yyzz_status'];
						$userrows[$k]['rec']=$val['rec'];
					}
				}
			}
		}
		$this->yunset("userrows",$userrows);
		$lotime=array('1'=>'一天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$this->yunset("lotime",$lotime);
		$this->yunset("get_type",$_GET);
		$this->yuntpl(array('admin/admin_member_trainlist'));
	}
	function status_action()//审核
	{
		 extract($_POST);
		 $id = @explode(",",$uid);
		 $member=$this->obj->DB_select_all("member","`uid` in (".$uid.")","`email`,`uid`");
		 $smtp = $this->email_set();
		 if(is_array($member)&&$member)
		 {
			foreach($member as $v)
			{
				$idlist[] =$v['uid'];
				$this->send_msg_email(array("uid"=>$v['uid'],"name"=>$info[$v['uid']],"email"=>$v['email'],"status_info"=>$statusbody,"date"=>date("Y-m-d H:i:s"),"type"=>"userstatus"));
			}
			$aid = @implode(",",$idlist);
			$id=$this->obj->DB_update_all("member","`status`='".$status."',`lock_info`='".$statusbody."'","`uid` IN (".$aid.")");
			$id?$this->ACT_layer_msg("培训会员审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("审核设置失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function lock_action()//锁定
	{
		$this->obj->DB_update_all("px_subject","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$this->obj->DB_update_all("px_teacher","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$this->obj->DB_update_all("px_train","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
		$train=$this->obj->DB_select_once("px_train","`uid`='".$_POST['uid']."'");
		$id=$this->obj->DB_update_all("member","`status`='".$_POST['status']."',`lock_info`='".$_POST['lock_info']."'","`uid`='".$_POST['uid']."'");
		$this->send_msg_email(array("email"=>$train['linkmail'],"uid"=>$_POST['uid'],"name"=>$train['name'],"lock_info"=>$_POST['lock_info'],"type"=>"lock"));
		$id?$this->ACT_layer_msg("培训会员(ID:".$_POST['uid'].")锁定设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "设置失败！",8,$_SERVER['HTTP_REFERER']);
	}
	function rec_action()
	{
		$this->check_token();
		$nid=$this->obj->DB_update_all("px_train","`".$_GET['type']."`='".$_GET['rec']."'","`uid`='".$_GET['id']."'");
		$this->obj->admin_log("培训机构推荐(ID:".$_GET['id'].")设置成功");
		echo $nid?1:0;die;
	}
	function edit_action()
	{
		if($_GET['id'])
		{
			$com_info = $this->obj->DB_select_once("member","`uid`='".$_GET['id']."'");
			$this->yunset("com_info",$com_info);
			$row = $this->obj->DB_select_once("px_train","`uid`='".$_GET['id']."'");
			$this->yunset("row",$row);
			$CacheArr['com'] =array('comdata','comclass_name');
			$CacheArr['city'] =array('city_index','city_type','city_name');
			$CacheArr['subject'] =array('subject_index','subject_name');
			$this->CacheInclude($CacheArr);
		}
		if($_POST['submit'])
		{
			//更新会员表
			if($_POST['password'])
			{
				$salt = substr(uniqid(rand()), -6);
				$pass = md5(md5($_POST['password']).$salt);
				$mvalue.="`password`='".$pass."',";
				$mvalue.="`salt`='".$salt."',";
			}
			$mvalue.="`status`='".$_POST['status']."',";
			if($_POST['status']=="2")
			{
				$this->obj->DB_update_all("px_subject","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
				$this->obj->DB_update_all("px_teacher","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
				$this->obj->DB_update_all("px_train","`r_status`='".$_POST['status']."'","`uid`='".$_POST['uid']."'");
				$mvalue.="`lock_info`='".$_POST['lock_info']."',";
			}
			$mvalue.="`email`='".$_POST['email']."',";
			$mvalue.="`moblie`='".$_POST['moblie']."'";
			$this->obj->DB_update_all("member",$mvalue,"`uid`='".$_POST['uid']."'");
			//更新基本信息
			$value.="`name`='".$_POST['name']."',";
			$value.="`linkmail`='".$_POST['email']."',";
			$value.="`linktel`='".$_POST['moblie']."',";
			$value.="`linkphone`='".$_POST['linkphone']."',";
			$value.="`linkqq`='".$_POST['linkqq']."',";
			$value.="`address`='".$_POST['address']."',";
			$value.="`sid`='".$_POST['sid']."',";
			$value.="`pr`='".$_POST['pr']."',";
			$value.="`mun`='".$_POST['mun']."',";
			$value.="`provinceid`='".$_POST['provinceid']."',";
			$value.="`cityid`='".$_POST['cityid']."',";
			$value.="`linkman`='".$_POST['linkman']."',";
			$value.="`website`='".$_POST['website']."',";
			$content=str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'','',''),html_entity_decode($_POST['content'],ENT_QUOTES,"GB2312"));
			$value.="`content`='".$content."'";
			$this->obj->DB_update_all("px_train",$value,"`uid`='".$_POST['uid']."'");
			$this->ACT_layer_msg("培训会员(ID:".$_POST['uid'].")修改成功！",9,"index.php?m=train_member",2,1);
		}
		$this->yuntpl(array('admin/admin_member_trainedit'));
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
					$photo = $this->obj->DB_select_all("px_train","`uid` in (".$uids.") and `logo`<>''");
					if(is_array($photo))
					{
				    	foreach($photo as $val)
				    	{
				    		$this->obj->unlink_pic("../".$val['logo']);
				    	}
					}
					$banner = $this->obj->DB_select_all("px_banner","`uid` in (".$uids.") and `pic`<>''");
					if(is_array($banner))
					{
				    	foreach($banner as $val)
				    	{
				    		$this->obj->unlink_pic($val['pic']);
				    	}
					}
					$show = $this->obj->DB_select_all("px_train","`uid` in (".$uids.") and `picurl`<>''");
					if(is_array($show))
					{
				    	foreach($show as $val)
				    	{
				    		$this->obj->unlink_pic(".".$val['picurl']);
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
					$del_array=array("member","px_train","px_banner","px_subject","px_teacher","px_train_news","px_train_show","px_train_statis");
					foreach($del_array as $value)
					{
						$this->obj->DB_delete_all($value,"`uid` in (".$uids.")","");
					}
					$this->obj->DB_delete_all("px_baoming","`s_uid` in (".$uids.")","");
					$this->obj->DB_delete_all("px_subject_collect","`s_uid` in (".$uids.")","");
					$this->obj->DB_delete_all("px_zixun","`s_uid` in (".$uids.")","");
					$this->obj->DB_delete_all("msg","`job_uid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend","`uid` in (".$uids.") or `nid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_reply","`uid` in (".$uids.") or `fid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_foot","`uid` in (".$uids.") or `fid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_im_list","`uid` in (".$uids.") or `touid` in (".$uids.")","");
					$this->obj->DB_delete_all("friend_message","`uid` in (".$uids.") or `fid` in (".$uids.")","");
					$this->obj->DB_delete_all("atn","`uid` in (".$uids.") or `scid` in (".$uids.")","");
					$this->obj->DB_delete_all("message","`uid` in (".$uids.") or `fa_uid` in (".$uids.")","");
		    	}else{
					$layer_type='0';
					$photo = $this->obj->DB_select_all("px_train","`uid`='".$del."' and `logo`<>''");
					if(is_array($photo))
					{
				    	$this->obj->unlink_pic("../".$photo['logo']);
					}
					$banner = $this->obj->DB_select_all("px_banner","`uid`='".$del."' and `pic`<>''");
					if(is_array($banner))
					{
				    	$this->obj->unlink_pic($banner['pic']);
					}
					$show = $this->obj->DB_select_all("px_train","`uid`='".$del."' and `picurl`<>''");
					if(is_array($show))
					{
				    	$this->obj->unlink_pic(".".$show['picurl']);
					}
					$friend_pic = $this->obj->DB_select_all("friend_info","`uid`='".$del."' and `pic`<>''");
					if(is_array($friend_pic))
					{
			    		$this->obj->unlink_pic($friend_pic['pic']);
			    		$this->obj->unlink_pic($friend_pic['pic_big']);
					}
					$del_array=array("member","px_train","px_banner","px_subject","px_teacher","px_train_news","px_train_show","px_train_statis");
					foreach($del_array as $value){
						$this->obj->DB_delete_all($value,"`uid`='".$del."'","");
					}
					$this->obj->DB_delete_all("px_baoming","`s_uid`='".$del."'","");
					$this->obj->DB_delete_all("px_subject_collect","`s_uid`='".$del."'","");
					$this->obj->DB_delete_all("px_zixun","`s_uid`='".$del."'","");
					$this->obj->DB_delete_all("msg","`job_uid`='".$del."'","");
					$this->obj->DB_delete_all("friend","`uid`='".$del."' or `nid`='".$del."'","");
					$this->obj->DB_delete_all("friend_reply","`uid`='".$del."' or `fid`='".$del."'","");
					$this->obj->DB_delete_all("friend_foot","`uid`='".$del."' or `fid`='".$del."'","");
					$this->obj->DB_delete_all("friend_im_list","`uid`='".$del."' or `touid`='".$del."'","");
					$this->obj->DB_delete_all("friend_message","`uid`='".$del."' or `fid`='".$del."'","");
					$this->obj->DB_delete_all("atn","`uid`='".$del."' or `scid`='".$del."'","");
					$this->obj->DB_delete_all("message","`uid`='".$del."' or `fa_uid`='".$del."'","");
		    	}
				$this->layer_msg('培训会员(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的会员！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	}
}

?>