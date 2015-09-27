<?php
class coupon_list_controller extends common
{
		//���ø߼���������
	function set_search(){
		//echo $_SERVER['REQUEST_URI'];
		$search_list[]=array("param"=>"status","name"=>'����״̬',"value"=>array("1"=>"δ����","2"=>"������"));
		$search_list[]=array("param"=>"receive","name"=>'����ʱ��',"value"=>array("1"=>"����","3"=>"�������","7"=>"�������","15"=>"�������","30"=>"���һ����"));
		$search_list[]=array("param"=>"end","name"=>'����ʱ��',"value"=>array("1"=>"����","3"=>"�������","7"=>"�������","15"=>"�������","30"=>"���һ����"));
		$search_list[]=array("param"=>"change","name"=>'����ʱ��',"value"=>array("1"=>"����","3"=>"�������","7"=>"�������","15"=>"�������","30"=>"���һ����"));
		$this->yunset("search_list",$search_list);
	}
	function index_action()
	{
		$this->set_search();
		$where="1";
		if($_GET['status']){
			$where.=" and `status`='".$_GET['status']."'";
			$urlarr['status']=$_GET['status'];
		}
		if($_GET['change']){
			if($_GET['change']=='1'){
				$where.=" and `xf_time` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `xf_time` >= '".strtotime('-'.$_GET['change'].'day')."'";
			}
			$urlarr['change']=$_GET['change'];
		}
		if($_GET['end']){
			$time=time();
			if($_GET['end']=='1'){
				$where.=" and ((`validity` <= '".strtotime(date("Y-m-d 11:59:59"))."') and (`validity` >= '".strtotime(date("Y-m-d 00:00:00"))."'))";
			}else{
				$where.=" and ((`validity` <= '".strtotime('+'.$_GET['end'].'day')."') and (`validity` >= '".$time."') )";
			}
			$urlarr['end']=$_GET['end'];
		}
		if($_GET['receive']){
			if($_GET['receive']=='1'){
				$where.=" and `ctime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `ctime` >= '".strtotime('-'.$_GET['receive'].'day')."'";
			}
			$urlarr['receive']=$_GET['receive'];
		}
		if(trim($_GET['keyword']))
		{
			if($_GET['type']=='1'){
				$m_uid=$this->obj->DB_select_all("member","`username` like '%".trim($_GET['keyword'])."%' ","`uid`");
				if(is_array($m_uid) && !empty($m_uid)){
					foreach($m_uid as $k){
						$m_id[]=$k['uid'];
					}
				}
				$where.=" and `uid` in(".@implode(',',$m_id).")";
			}elseif($_GET['type']=='2'){
				$where.=" and `number` like '%".trim($_GET['keyword'])."%'";
			}elseif($_GET['type']=='3'){
				$where.=" and `coupon_name` like '%".trim($_GET['keyword'])."%'";
			}
			$urlarr['type']="".$_GET['type']."";
			$urlarr['keyword']="".$_GET['keyword']."";
		}
		if($_GET['order']){
			if($_GET['order']=="desc"){
				$order=" order by `".$_GET['t']."` desc";
			}else{
				$order=" order by `".$_GET['t']."` asc";
			}

		}else{
			$order=" order by `id` desc";
		}
		if($_GET['order']=="asc"){
			$this->yunset("order","desc");
		}else{
			$this->yunset("order","asc");
		}
		$urlarr['page']="{{page}}";
		$pageurl=$this->url("index",$_GET['m'],$urlarr);
		$rows=$this->get_page("coupon_list",$where.$order,$pageurl,$this->config['sy_listnum']);
		if(is_array($rows))
		{
			foreach($rows as $v)
			{
				$uid[]=$v['uid'];
			}
			$member=$this->obj->DB_select_all("member","`uid` in (".@implode(",",$uid).")","`uid`,`username`");
			foreach($rows as $k=>$v)
			{
				foreach($member as $val)
				{
					if($v['uid']==$val['uid'])
					{
						$rows[$k]['username']=$val['username'];
					}
				}
			}
			$this->yunset("rows",$rows);
		}
		$this->yunset("get_type",$_GET);
		$changetime=array('1'=>'һ��','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
        $this->yunset("change",$changetime);
		$receivetime=array('1'=>'һ��','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
        $this->yunset("receive",$receivetime);
		$endtime=array('1'=>'һ��','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
        $this->yunset("end",$endtime);
		$this->yuntpl(array('admin/coupon_list'));
	}
	function del_action()
	{
		if($_GET['del'])
		{
			$this->check_token();
			$del=$_GET['del'];
			if(is_array($del)){
				$del=@implode(',',$del);
				$layer_type=1;
			}else{
				$layer_type=0;
			}
			$id=$this->obj->DB_delete_all("coupon_list","`id` in (".$del.")"," ");
			$del?$this->layer_msg('�Ż�ȯ��¼(ID:'.$del.')ɾ���ɹ���',9,$layer_type,$_SERVER['HTTP_REFERER']):$this->layer_msg('ɾ��ʧ�ܣ�',8,$layer_type,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('��ѡ��Ҫɾ�������ݣ�',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
}

?>