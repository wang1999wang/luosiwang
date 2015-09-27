<?php
class lthy_class_controller extends common
{
	function index_action(){
		//查询
		$position=$this->obj->DB_select_all("lthy_class","`keyid`='0' order by sort asc");
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_lthy'));
	}
	//添加行业
	function save_action(){
		if(!is_array($this->obj->DB_select_once("lthy_class","`name`='".$_POST["position"]."'"))){
			$value="`name`='".iconv('utf-8','gbk',trim($_POST["position"]))."',";
			if((int)$_POST["sort"]==""){
				$_POST["sort"]="0";
			}
			$value.="`sort`='".trim($_POST["sort"])."',";
			if($_POST['ctype']=='1'){//一级分类
				$value.="`keyid`='0'";
			}else{
				$value.="`keyid`='".$_POST["nid"]."'";
			}
			$add=$this->obj->DB_insert_once("lthy_class",$value);
			$this->cache_action();
			$add?$msg=2:$msg=3;
			$this->obj->admin_log("猎头行业分类(ID:".$add.")添加成功");
		}else{
			$msg=1;
		}
		echo $msg;die;
	}
	//行业管理
	function up_action(){
		//查询子类别
		if((int)$_GET["id"]){
			$id=(int)$_GET["id"];
			$onejob=$this->obj->DB_select_once("lthy_class","`id`='".$_GET["id"]."'");
			$twojob=$this->obj->DB_select_all("lthy_class","`keyid`='".$_GET["id"]."' order by sort asc");
			$this->yunset("onejob",$onejob);
			$this->yunset("twojob",$twojob);
			$this->yunset("id",$id);
		}
		$position=$this->obj->DB_select_all("lthy_class","`keyid`='0'");
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_lthy'));
	}
	//删除
	function del_action()
	{
		if($_GET['delid'])
		{
			$this->check_token();
			$id=$this->obj->DB_delete_all("lthy_class","`id`='".$_GET['delid']."' or `keyid`='".$_GET['delid']."'","");
			$this->cache_action();
		    isset($id)?$this->layer_msg('猎头行业分类删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['del'])//批量删除
		{
			$del=@implode(",",$_POST['del']);
			$id=$this->obj->DB_delete_all("lthy_class","`id` in (".$del.") or `keyid` in (".$del.")","");
			$this->cache_action();
			isset($id)?$this->layer_msg('猎头行业分类删除成功！',9,1,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
	function ajax_action()
	{
		if($_POST['sort'])//修改排序
		{
			$this->obj->DB_update_all("lthy_class","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("猎头行业分类(ID:".$_POST['id'].")排序修改成功");
		}
		if($_POST['name'])//修改类别名称
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("lthy_class","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("猎头行业分类(ID:".$_POST['id'].")类别修改成功");
		}
		$this->cache_action();echo '1';die;
	}
	function cache_action()
	{
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->lthy_cache("lthy.cache.php");
	}
}

?>