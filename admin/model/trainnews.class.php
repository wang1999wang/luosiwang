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
class trainnews_controller extends common
{
	//设置高级搜索功能
	function set_search(){
		$search_list[]=array("param"=>"status","name"=>'审核状态',"value"=>array("1"=>"已审核","3"=>"未审核","2"=>"未通过"));
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
		//分站---
		if($_SESSION['admin_city'])
		{
			$where.=" and b.`cityid`='".$_SESSION['admin_city']."'";
		}
		if($_SESSION['def_city'])
		{
			$where.=" and b.`cityid` in (".$_SESSION['def_city'].")";
		}
		//分站---
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
		$count=$this->obj->DB_select_alls("px_train_news","px_train","a.`uid`=b.`uid` $where","a.uid");//获取总数
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
		//$status //0未审核,1通过，2已过期，3未通过
		if(is_array($id))
		{
			foreach($id as $value)
			{
				$idlist[] = $value;
			}
			$aid = @implode(",",$idlist);
			$id=$this->obj->DB_update_all("px_train_news","`status`='$status',`statusbody`='".$statusbody."'","`id` IN ($aid)");
 			$id?$this->ACT_layer_msg("培训新闻审核(ID:".$aid.")设置成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("设置失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",9,$_SERVER['HTTP_REFERER']);
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
			$id?$this->layer_msg('培训新闻(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
	    }
	}
}
?>