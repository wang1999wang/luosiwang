<?php
class ltclass_controller extends common{
	//���
	function index_action(){
		$position=$this->obj->DB_select_all("ltclass","`keyid`='0'");
		$this->yunset("position",$position);

		$this->yuntpl(array('admin/admin_ltclass'));
	}
	//���
	function save_action(){
		if(!is_array($this->obj->DB_select_once("ltclass","`name`='".$_POST['position']."'"))){
			$value="`name`='".iconv('utf-8','gbk',trim($_POST['position']))."',";
			if((int)$_POST['sort']==""){
				$_POST['sort']="0";
			}
			$value.="`sort`='".trim($_POST['sort'])."',";
			if($_POST['ctype']=='1'){//һ������
				$value.="`variable`='".trim($_POST['variable'])."'";
			}else{
				$value.="`keyid`='".$_POST['nid']."'";
			}
			$add=$this->obj->DB_insert_once("ltclass",$value);
			$this->cache_action();
			$add?$msg=2:$msg=3;
			$this->obj->admin_log("��ͷ��Ա����(ID:".$add.")��ӳɹ�");
		}else{
			$msg=1;
		}
		echo $msg;die;
	}
	//�������
	function up_action(){
		//��ѯ�����
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
	//���·���
	function upp_action(){
		if($_POST['update']){
			if(!empty($_POST['position'])){
				if(preg_match("/[^\d-., ]/",$_POST['sort'])){
					$this->ACT_layer_msg("����ȷ��д�����������֣�",8,$_SERVER['HTTP_REFERER']);
				}else{
					$value="`name`='".$_POST['position']."'";
					if($_POST['sort']){
						$value.=",`sort`='".$_POST['sort']."'";
					}
					$where="`id`='".$_POST['id']."'";
					$up=$this->obj->DB_update_all("ltclass","$value","$where");
					$this->cache_action();
					$up?$this->ACT_layer_msg("��ͷ��Ա����(ID:".$_POST['id'].")���³ɹ���",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("����ʧ�ܣ����������ԣ�",8,$_SERVER['HTTP_REFERER']);
				}
			}else{
				$this->ACT_layer_msg("����ȷ��д��Ҫ���µķ��࣡",8,$_SERVER['HTTP_REFERER']);
			}
		}
	}
	//ɾ��
	function del_action()
	{
		if($_GET['delid'])
		{
			$this->check_token();
			$id=$this->obj->DB_delete_all("ltclass","`id`='".$_GET['delid']."' or `keyid`='".$_GET['delid']."'","");
			$this->cache_action();
		    isset($id)?$this->layer_msg('��ͷ��Ա����ɾ���ɹ���',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,0,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['del'])//����ɾ��
		{
			$del=@implode(",",$_POST['del']);
			$id=$this->obj->DB_delete_all("ltclass","`id` in (".$del.") or `keyid` in (".$del.")","");
			$this->cache_action();
			isset($id)?$this->layer_msg('��ͷ��Ա����ɾ���ɹ���',9,1,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
	function ajax_action()
	{
		if($_POST['sort'])//�޸�����
		{
			$this->obj->DB_update_all("ltclass","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("��ͷ��Ա����(ID:".$_POST['id'].")�����޸ĳɹ�");
		}
		if($_POST['name'])//�޸��������
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("ltclass","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("��ͷ��Ա����(ID:".$_POST['id'].")�����޸ĳɹ�");
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