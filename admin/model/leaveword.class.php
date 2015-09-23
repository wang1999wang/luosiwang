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
class leaveword_controller extends common{
	function set_search(){
		$cate=$this->obj->DB_select_all("cars_group","1","`id`,`name`");
		if(!empty($cate)){
			foreach($cate as  $k=>$v){
                $newsarr[$v['id']]=$v['name'];
			}
		}
		if($_GET['cate']){
			foreach($cate as $val){
				if($_GET['cate']==$val['id']){
					$this->yunset("cateinfo", $val);
				}
			}
		}
		$this->yunset("cate", $cate);
		$lo_time=array('1'=>'����','3'=>'�������','7'=>'�������','15'=>'�������','30'=>'���һ����');
		$search_list[]=array("param"=>"publish","name"=>'����ʱ��',"value"=>$lo_time);
		$search_list[]=array("param"=>"cate","name"=>'�泵���',"value"=>$newsarr);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
         $where="1";
		 if ($_GET['nid']!=''){
             $where.=" and FIND_IN_SET('".$_GET['nid']."',`nid`)";
             $urlarr['nid']=$_GET['nid'];
		}
		if($_GET['adtime']){
			if($_GET['adtime']=='1'){
				$where .=" and `datetime`>'".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where .=" and `datetime`>'".strtotime('-'.intval($_GET['adtime']).' day')."'";
			}
			$urlarr['adtime']=$_GET['adtime'];
		}
		if($_GET['publish']){
			if($_GET['publish']=='1'){
				$where.=" and `datetime` >= '".strtotime(date("Y-m-d 00:00:00"))."'";
			}else{
				$where.=" and `datetime` >= '".strtotime('-'.(int)$_GET['publish'].'day')."'";
			}
			$urlarr['publish']=$_GET['publish'];
		}
		if($_GET['news_search']){
			if ($_GET['type']=='1'){
				$where.=" and `title` like '%".$_GET['keyword']."%'";
			}elseif ($_GET['type']=='2'){
				$where.=" and `author` like '%".$_GET['keyword']."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
			$urlarr['news_search']=$_GET['news_search'];
		}

		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by id desc";
		}
		$urlarr['order']=$_GET['order'];
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("leaveword",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $adminnews=$PageInfo['rows'];
		if(is_array($adminnews)){
			foreach($adminnews as $v){
                if(trim($v['nid'])){
                    $classid[]=$v['nid'];
                }
			}
		}
		if(is_array($classid))
		{
			$group=$this->obj->DB_select_all("cars_group","id in (".@implode(",",$classid).")");
		}
		$property=$this->obj->DB_select_all("property");
		if(is_array($group))
		{
			foreach($adminnews as $k=>$v)
			{
				$adminnews[$k]['url']=Url('article',array('c'=>'show','id'=>$v['id']));
				$adminnews[$k]['title']=mb_substr($v['title'],0,20,"GBK");
                $nid_list=explode(',',$v['nid']);
				foreach($group as $key=>$value)
				{
					if(in_array($value['id'],$nid_list))
					{
						$adminnews[$k]['name'][]=$value['name'];
					}
				}
                $adminnews[$k]['name']=implode(',',$adminnews[$k]['name']);
				if($v['newsphoto']!=""){
					$type.=" ͼ";
				}
				if($v['describe']!="")
				{
					$describe=@explode(",",$v['describe']);
					foreach($property as $val)
					{
						if(in_array($val['value'],$describe))
						{
							$ms=mb_substr($val['name'],0,1,"GBK");
							$type.=" ".$ms;
						}
					}
				}
				if($type!=""){
					$adminnews[$k]['titype']="[<font color='red'>".$type."</font> ]";
				}
				$type=$describe="";
			}
		}

        $this->yunset("get_type", $_GET);
		$this->yunset("adminnews",$adminnews);
		$this->yunset("property",$property);
		$this->yunset("propertys",$property);
		$this->yuntpl(array('admin/leaveword_list'));
	}
	function delnews_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
				$this->obj->DB_delete_all("leaveword","`id` in(".@implode(',',$del).")","");
				$this->obj->DB_delete_all("news_content","`nbid` in(".@implode(',',$del).")","");
 				$this->layer_msg('����(ID:'.@implode(',',$del).')ɾ���ɹ���',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('��ѡ����Ҫɾ�������ԣ�',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."'";
			$result=$this->obj->DB_delete_all("leaveword", $where);
			$nid=$this->obj->DB_delete_all("news_content","`nbid`='".$_GET['id']."'");
			isset($nid)?$this->layer_msg('����(ID:'.$_GET['id'].')ɾ���ɹ���',9):$this->layer_msg('ɾ��ʧ�ܣ�',8);
		}else{
			$this->ACT_layer_msg( "�Ƿ�������",8,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>