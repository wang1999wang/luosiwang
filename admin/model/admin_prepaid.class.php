<?php
class admin_prepaid_controller extends common{
	function index_action(){
		$list=$this->obj->DB_select_all("prepaid");
		$this->yunset("list",$list);
		$this->yuntpl(array('admin/admin_prepaid_group'));
	}
	function clist_action(){
		$where="`cid`='".intval($_GET['id'])."'";
		$urlarr['id']=$_GET['id'];
		if($_GET['keyword']){
			$where.=" and `card` like '%".$_GET['keyword']."%'";
			$urlarr['keyword']=$_GET['keyword'];
		}
		if($_GET['type']){
			$where.=" and `type`='".$_GET['type']."'";
			$urlarr['type']=$_GET['type'];
		}
		if($_GET['order']){
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by `id` desc";
		}
		$urlarr['c']="clist";
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
        $M=$this->MODEL();
		$PageInfo=$M->get_page("prepaid_card",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
		$prepaid=$M->DB_select_once("prepaid","`id`='".intval($_GET['id'])."'");
		$this->yunset("prepaid",$prepaid);
		$this->yuntpl(array('admin/admin_prepaid'));
	}
	function upcard_action(){
		if($_POST['submit']){
			$stime=strtotime($_POST['stime'].' 00:00:00');
			$etime=strtotime($_POST['etime'].' 23:59:59');
			if($etime>time()){
				$statue='1';
			}
			$nid=$this->obj->DB_update_all("prepaid_card","`statue`='".$statue."',`stime`='".$stime."',`etime`='".$etime."',`password`='".trim($_POST['password'])."',`quota`='".trim($_POST['quota'])."',`type`='".$_POST['type']."'","`id`='".intval($_POST['id'])."' and `utime` is null");
			$nid?$this->ACT_layer_msg("充值卡(ID:".intval($_POST['id']).")更新成功！",9,"index.php?m=admin_prepaid&c=clist&id=".$_POST['cid'],2,1):$this->ACT_layer_msg("更新失败！",8,$_SERVER['HTTP_REFERER']);;
		}
		if($_GET['id']){
			$info=$this->obj->DB_select_once("prepaid_card","`id`='".intval($_GET['id'])."' and `utime` is null");
			if($info['id']){
				$prepaid=$this->obj->DB_select_once("prepaid","`id`='".$info['cid']."'");
				$this->yunset("prepaid",$prepaid);
				$this->yunset("info",$info);
				$this->yuntpl(array('admin/admin_prepaid_upcard'));
			}else{
				$this->ACT_layer_msg("非法操作",8,"index.php?m=admin_prepaid");
			}
		}
	}
	function add_action(){
		if($_POST['submit']){
			$quota=trim($_POST['quota']);
			$num=intval($_POST['num']);
			$cid=intval($_POST['cid']);
			$stime=strtotime($_POST['stime'].' 00:00:00');
			$etime=strtotime($_POST['etime'].' 23:59:59');
			$type=trim($_POST['type']);
			$value=array();
			for($i=1;$i<=$num;$i++){
				$time = @explode(" ", microtime () );
				$time = $time[1].($time[0]*1000000);
				if(strlen($time)<16){
					$time=substr($time.'0000',0,16);
				}
				$card = substr($time.rand(100,999),0,16);
				$password=substr(base_convert($card,10,8),-5).rand(100,999);
				$value[]="('".$card."','".$cid."','".$password."','".$quota."','".$type."','".$stime."','".$etime."','".time()."')";
			}
			$this->obj->DB_query_all("INSERT INTO ".$this->def."prepaid_card(`card`,`cid`,`password`,`quota`,`type`,`stime`,`etime`,`atime`) VALUES ".@implode(',',$value));
			$this->obj->DB_update_all("prepaid","`num`=`num`+'".$num."'","`id`='".$cid."'");
			$this->ACT_layer_msg("充值卡添加成功！",9,"index.php?m=admin_prepaid&c=clist&id=".$cid);
		}
		if($_GET['cid']){
			$pinfo=$this->obj->DB_select_once("prepaid","`id`='".$_GET['cid']."'");
			$this->yunset("pinfo",$pinfo);
		}else{
			$prepaid=$this->obj->DB_select_all("prepaid");
			$this->yunset("prepaid",$prepaid);
		}
		$this->yuntpl(array('admin/admin_prepaid_add'));
	}
	function rec_action(){
		intval($_GET['rec'])=='1'?$type='1':$type='2';
		$id=$this->obj->DB_update_all("prepaid_card","`type`='".$type."'","`id`='".$_GET['id']."'");
		$this->obj->admin_log("充值卡(ID:".$_GET['id'].")状态设置成功！");
		echo $id?1:0;die;
	}

	function del_action(){
		if($_GET['del']){
			$this->check_token();
			$del=$_GET['del'];
			if(is_array($del)){
				$del=@implode(',',$del);
				$layer_type=1;
			}else{
				$layer_type=0;
			}
			$id=$this->obj->DB_delete_all("prepaid_card","`id` in (".$del.")"," ");
			$del?$this->layer_msg('充值卡(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择要删除的内容！',8);
		}
	}

	function gadd_action(){
		if($_POST['submit']){
			if(trim($_POST['name'])==''){$this->ACT_layer_msg("类别名称不能为空！",8,$_SERVER['HTTP_REFERER']);}
			if(trim($_POST['stime'])==''){$this->ACT_layer_msg("有效日期不能为空！",8,$_SERVER['HTTP_REFERER']);}
			if(trim($_POST['etime'])==''){$this->ACT_layer_msg("结束日期不能为空！",8,$_SERVER['HTTP_REFERER']);}
			if($_POST['id']){
				$_POST['id']=intval($_POST['id']);
				$prepaid=$this->obj->DB_select_once("prepaid","`id`='".$_POST['id']."'");
				$id=$this->obj->DB_update_all("prepaid","`name`='".trim($_POST['name'])."',`stime`='".strtotime($_POST['stime'].' 00:00:00')."',`etime`='".strtotime($_POST['etime'].' 23:59:59')."',`type`='".$_POST['type']."'","`id`='".$_POST['id']."'");
				if($id){
					$value=array();
					if($prepaid['type']!=trim($_POST['type'])){
						$value[]="`type`='".trim($_POST['type'])."'";
					}
					if($prepaid['stime']!=strtotime($_POST['stime'])||$prepaid['etime']!=strtotime($_POST['etime'])){
						$value[]="`stime`='".strtotime($_POST['stime'].' 00:00:00')."',`etime`='".strtotime($_POST['etime'].' 23:59:59')."'";
					}
					if($value&&is_array($value)){
						$this->obj->DB_update_all("prepaid_card",@implode(',',$value),"`cid`='".$_POST['id']."' and `stime`='".$prepaid['stime']."' and `etime`='".$prepaid['etime']."' and `utime` is null");
					}
					$this->ACT_layer_msg("充值卡类别(ID:".$_POST['id'].")更新成功！",9,"index.php?m=admin_prepaid",2,1);
				}else{
					$this->ACT_layer_msg("更新失败！",8,$_SERVER['HTTP_REFERER']);
				}
			}else{
				$id=$this->obj->DB_insert_once("prepaid","`name`='".trim($_POST['name'])."',`stime`='".strtotime($_POST['stime'].' 00:00:00')."',`etime`='".strtotime($_POST['etime'].' 23:59:59')."',`type`='".$_POST['type']."'");
				isset($id)?$this->ACT_layer_msg("充值卡类别(ID:".$id.")添加成功！",9,"index.php?m=admin_prepaid",2,1):$this->ACT_layer_msg("添加失败！",8,$_SERVER['HTTP_REFERER']);
			}
		}
		if($_GET['id']){
			$info=$this->obj->DB_select_once("prepaid","`id`='".$_GET['id']."'");
			$this->yunset("info",$info);
		}
		$this->yuntpl(array('admin/admin_prepaid_gadd'));
	}
	function delgroup_action(){
		if($_GET['del']){
			$this->check_token();
			$del=$_GET['del'];
			if(is_array($del)){
				$del=@implode(',',$del);
				$layer_type=1;
			}else{
				$layer_type=0;
			}
			$id=$this->obj->DB_delete_all("prepaid","`id` in (".$del.")"," ");
			if($id){
				$this->obj->DB_delete_all("prepaid_card","`cid` in (".$del.")"," ");
				$this->layer_msg('充值卡类别(ID:'.$del.')删除成功！',9,$layer_type,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('删除失败！',8,$layer_type,$_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->layer_msg('请选择要删除的内容！',8);
		}
	}
}
?>