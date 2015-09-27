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
class admin_lt_rating_controller extends common
{
	function index_action()
	{
		$list=$this->obj->DB_select_all("company_rating","`category`='2'");
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_lt_rating'));
	}
	function rating_action()
	{
		if($_GET['id'])
		{
			$row=$this->obj->DB_select_once("company_rating","`id`='".$_GET['id']."'");
			$this->yunset("row",$row);
		}
		$coupon=$this->obj->DB_select_all("coupon");
		$this->yunset("coupon",$coupon);
		$this->yuntpl(array('admin/admin_ltclass_add'));
	}
	function saveclass_action()
	{
		if($_POST['useradd'])
		{
			$id=$_POST['id'];
			unset($_POST['useradd']);
			unset($_POST['id']);
			if(is_uploaded_file($_FILES['com_pic']['tmp_name'])){
				$upload=$this->upload_pic("../data/upload/compic/");
				$pictures=$upload->picture($_FILES['com_pic']);
				$pic = str_replace("../data/upload","upload",$pictures);
			}
			$_POST['time_start']=strtotime($_POST['time_start']);
			$_POST['time_end']=strtotime($_POST['time_end']);
			if(!$id){
				$_POST['com_pic']=$pic;
				$nid=$this->obj->insert_into("company_rating",$_POST);
				$name="猎头会员等级（ID：".$nid."）添加";
			}else{
				if($pic!=""){$_POST['com_pic']=$pic;};
				$where['id']=$id;
				$nid=$this->obj->update_once("company_rating",$_POST,$where);
				$name="猎头会员等级（ID：".$id."）更新";
			}
		}
		$nid?$this->ACT_layer_msg($name."成功！",9,"index.php?m=admin_lt_rating",2,1):$this->ACT_layer_msg($name."失败！",8,"index.php?m=admin_lt_rating");
	}
	function del_action()
	{
		$this->check_token();
		$nid=$this->obj->DB_delete_all("company_rating","`id`='".$_GET['id']."'");
 		$nid?$this->layer_msg('猎头会员等级（ID：'.$_GET['id'].'）删除成功！',9):$this->layer_msg('删除失败！',8);
	}
}

?>