<?php
class ltclass_controller extends common{
	//添加
	function index_action(){
		$position=$this->obj->DB_select_all("ltclass","`keyid`='0'");
		$this->yunset("position",$position);

		$this->yuntpl(array('admin/admin_ltclass'));
	}
	//添加
	function save_action(){
		if(!is_array($this->obj->DB_select_once("ltclass","`name`='".$_POST['position']."'"))){
			$value="`name`='".iconv('utf-8','gbk',trim($_POST['position']))."',";
			if((int)$_POST['sort']==""){
				$_POST['sort']="0";
			}
			$value.="`sort`='".trim($_POST['sort'])."',";
			if($_POST['ctype']=='1'){//一级分类
				$value.="`variable`='".trim($_POST['variable'])."'";
			}else{
				$value.="`keyid`='".$_POST['nid']."'";
			}
			$add=$this->obj->DB_insert_once("ltclass",$value);
			$this->cache_action();
			$add?$msg=2:$msg=3;
			$this->obj->admin_log("猎头会员分类(ID:".$add.")添加成功");
		}else{
			$msg=1;
		}
		echo $msg;die;
	}
	//分类管理
	function up_action(){
		//查询子类别
		if($_GET['id']){
			$id=$_GET['id'];
			$class1=$this->obj->DB_select_once("ltclass","`id`='".$_GET['id']."'");
			$class2=$this->obj->DB_select_all("ltclass","`keyid`='".$_GET['id']."'");
			$this->yunset("id",$id);
			$this->yunset("class1",$class1);
			$this->yunset("class2",$class2);
		}
		$position=$this->obj->DB_select_all("ltclass","`keyid`='0'");
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_ltclass'));
	}
	//更新分类
	function upp_action(){
		if($_POST['update']){
			if(!empty($_POST['position'])){
				if(preg_match("/[^\d-., ]/",$_POST['sort'])){
					$this->ACT_layer_msg("请正确填写，排序是数字！",8,$_SERVER['HTTP_REFERER']);
				}else{
					$value="`name`='".$_POST['position']."'";
					if($_POST['sort']){
						$value.=",`sort`='".$_POST['sort']."'";
					}
					$where="`id`='".$_POST['id']."'";
					$up=$this->obj->DB_update_all("ltclass","$value","$where");
					$this->cache_action();
					$up?$this->ACT_layer_msg("猎头会员分类(ID:".$_POST['id'].")更新成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("更新失败，请销后再试！",8,$_SERVER['HTTP_REFERER']);
				}
			}else{
				$this->ACT_layer_msg("请正确填写你要更新的分类！",8,$_SERVER['HTTP_REFERER']);
			}
		}
	}
	//删除
	function del_action()
	{
		if($_GET['delid'])
		{
			$this->check_token();
			$id=$this->obj->DB_delete_all("ltclass","`id`='".$_GET['delid']."' or `keyid`='".$_GET['delid']."'","");
			$this->cache_action();
		    isset($id)?$this->layer_msg('猎头会员分类删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['del'])//批量删除
		{
			$del=@implode(",",$_POST['del']);
			$id=$this->obj->DB_delete_all("ltclass","`id` in (".$del.") or `keyid` in (".$del.")","");
			$this->cache_action();
			isset($id)?$this->layer_msg('猎头会员分类删除成功！',9,1,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
	function ajax_action()
	{
		if($_POST['sort'])//修改排序
		{
			$this->obj->DB_update_all("ltclass","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("猎头会员分类(ID:".$_POST['id'].")排序修改成功");
		}
		if($_POST['name'])//修改类别名称
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("ltclass","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("猎头会员分类(ID:".$_POST['id'].")名称修改成功");
		}
		$this->cache_action();echo '1';die;
	}
	function cache_action()
	{
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->lt_cache("lt.cache.php");
	}
}
?>