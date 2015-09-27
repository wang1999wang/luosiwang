<?php
class ltjob_class_controller extends common
{
	function index_action(){
		//��ѯ
		$position=$this->obj->DB_select_all("ltjob_class","`keyid`='0' order by sort asc");
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_ltjob'));
	}
	//���ְλ
	function save_action(){
		if(!is_array($this->obj->DB_select_once("ltjob_class","`name`='".$_POST['position']."'"))){
			$value="`name`='".iconv('utf-8','gbk',trim($_POST['position']))."',";
			if((int)$_POST['sort']==""){
				$_POST['sort']="0";
			}
			$value.="`sort`='".trim($_POST['sort'])."',";
			if($_POST['ctype']=='1'){//һ������
				$value.="`keyid`='0'";
			}else{
				$value.="`keyid`='".$_POST['nid']."'";
			}
			$add=$this->obj->DB_insert_once("ltjob_class",$value);
			$this->cache_action();
			$add?$msg=2:$msg=3;
			$this->obj->admin_log("��ͷְλ���(ID:".$add.")��ӳɹ�");
		}else{
			$msg=1;
		}
		echo $msg;die;
	}
	//ְλ����
	function up_action(){
		//��ѯ�����
		if((int)$_GET['id']){
			$id=(int)$_GET['id'];
			$onejob=$this->obj->DB_select_once("ltjob_class","`id`='".$_GET['id']."'");
			$twojob=$this->obj->DB_select_all("ltjob_class","`keyid`='".$_GET['id']."' order by sort asc");
			$this->yunset("onejob",$onejob);
			$this->yunset("twojob",$twojob);
			$this->yunset("id",$id);
		}
		$position=$this->obj->DB_select_all("ltjob_class","`keyid`='0'");
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_ltjob'));
	}
	//����ְλ
	function upp_action(){

		if($_POST['update']){
			if(!empty($_POST['position'])){
				$value="`name`='".$_POST['position']."',`sort`='".$_POST['sort']."'";
				$where="`id`='".$_POST['id']."'";
				$up=$this->obj->DB_update_all("ltjob_class",$value,$where);
				$this->cache_action();
				$up?$this->ACT_layer_msg("��ͷְλ����(ID:".$_POST['id'].")���³ɹ���",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("����ʧ�ܣ����������ԣ�",8,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("����ȷ��д��Ҫ���µķ��࣡",8,$_SERVER['HTTP_REFERER']);
			}
		}
		$this->yuntpl(array('admin/ltjob_class'));
	}
	//ɾ��
	function del_action()
	{
		if($_GET['delid'])
		{
			$this->check_token();
			$id=$this->obj->DB_delete_all("ltjob_class","`id`='".$_GET['delid']."' or `keyid`='".$_GET['delid']."'","");
			$this->cache_action();
		    isset($id)?$this->layer_msg('��ͷְλ����ɾ���ɹ���',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,0,$_SERVER['HTTP_REFERER']);
		}
		if($_POST['del'])//����ɾ��
		{
			$del=@implode(",",$_POST['del']);
			$id=$this->obj->DB_delete_all("ltjob_class","`id` in (".$del.") or `keyid` in (".$del.")","");
			$this->cache_action();
			isset($id)?$this->layer_msg('��ͷְλ����ɾ���ɹ���',9,1,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,1,$_SERVER['HTTP_REFERER']);
		}
	}
	function ajax_action()
	{
		if($_POST['sort'])//�޸�����
		{
			$this->obj->DB_update_all("ltjob_class","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("��ͷְλ����(ID:".$_POST['id'].")�����޸ĳɹ�");
		}
		if($_POST['name'])//�޸��������
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("ltjob_class","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("��ͷְλ����(ID:".$_POST['id'].")�����޸ĳɹ�");
		}
		$this->cache_action();echo '1';die;
	}
	function cache_action()
	{
		include(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->ltjob_cache("ltjob.cache.php");
	}
}

?>