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
				$name="��ͷ��Ա�ȼ���ID��".$nid."�����";
			}else{
				if($pic!=""){$_POST['com_pic']=$pic;};
				$where['id']=$id;
				$nid=$this->obj->update_once("company_rating",$_POST,$where);
				$name="��ͷ��Ա�ȼ���ID��".$id."������";
			}
		}
		$nid?$this->ACT_layer_msg($name."�ɹ���",9,"index.php?m=admin_lt_rating",2,1):$this->ACT_layer_msg($name."ʧ�ܣ�",8,"index.php?m=admin_lt_rating");
	}
	function del_action()
	{
		$this->check_token();
		$nid=$this->obj->DB_delete_all("company_rating","`id`='".$_GET['id']."'");
 		$nid?$this->layer_msg('��ͷ��Ա�ȼ���ID��'.$_GET['id'].'��ɾ���ɹ���',9):$this->layer_msg('ɾ��ʧ�ܣ�',8);
	}
}

?>