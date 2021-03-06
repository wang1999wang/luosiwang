<?php
class admin_log_controller extends common
{
	function set_search(){
		$ad_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"end","name"=>'操作时间',"value"=>$ad_time);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$where = "1";
		$this->set_search();
		if($_GET['end']){
			if($_GET['end']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.(int)$_GET['end'].'day')."'";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET["keyword"]!=""){
			$where.=" and `username`='".$_GET["keyword"]."'";
			$urlarr["keyword"]=$_GET["keyword"];
		}
		$urlarr["page"]="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();

		$list=$M->get_page("admin_log",$where." order by `id` desc",$pageurl,$this->config["sy_listnum"]);
		$list['list']=$list['rows'];
		$this->yunset($list);
		$this->yuntpl(array('admin/admin_log'));
	}

	function del_action(){
		$this->check_token();
	    if($_GET["del"]){
	    	$del=$_GET["del"];
	    	if(is_array($del)){
				$this->obj->DB_delete_all("admin_log","`id` in(".@implode(',',$del).")","");
	    		$this->layer_msg( "后台日志删除(ID:".@implode(',',$del).")成功！",9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg( "请选择您要删除的信息！",8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET["id"])){
			$result=$this->obj->DB_delete_all("admin_log","`id`='".$_GET["id"]."'" );
 			isset($result)?$this->layer_msg('后台日志删除(ID:'.$_GET['id'].')成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->ACT_layer_msg("非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}

}
?>