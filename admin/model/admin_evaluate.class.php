<?php
class admin_evaluate_controller extends common {
	
	/*	
	�����š�����ʱ�䡢�������������/��������
	*/	
	
	//��ҳ�г��Ծ�
	function index_action(){
		
		//Ĭ���б�
		if(!isset($_GET['evaluate_search'])){
			$where="1 and `keyid`!='0'";
			if($_GET['order'])//id����ʱ������sort����
			{
				$where.=" order by ".$_GET['t']." ".$_GET['order'];
				$urlarr['order']=$_GET['order'];
				$urlarr['t']=$_GET['t'];
			}else{
				$where.=" order by id desc";
			}
			$urlarr['order']=$_GET['order'];
			$urlarr['page']="{{page}}";
			$pageurl=$this->url("index",$_GET['m'],$urlarr);  //print_r($urlarr);die;
			//$M=$this->MODEL();
			//$PageInfo=$M->get_page("evaluate_group",$where,$pageurl,$this->config['sy_listnum'],"`id`,`keyid`,`name`,`sort`,`ctime`"); //print_r($PageInfo);die;
			$PageInfo=$this->get_page("evaluate_group",$where,$pageurl,$this->config['sy_listnum'],"`id`,`keyid`,`name`,`sort`,`ctime`"); 
			$this->yunset($PageInfo);
			$adminevaluate=$PageInfo;	
			//print_r($adminevaluate);die;
			if(is_array($adminevaluate)){
				foreach($adminevaluate as $v){
					$classid[]=$v['keyid'];
				}
			}
			if(is_array($classid))
			{
				$group=$this->obj->DB_select_all("evaluate_group","id in (".@implode(",",$classid).")","`id`,`name`");
			}
			//׷�����url
			foreach($adminevaluate as $one=>$onevalue){			
				foreach($group as $two=>$twovalue){
					if($adminevaluate[$one]['keyid'] == $group[$two]['id']){
						$adminevaluate[$one]['groupname']= $group[$two]['name'];
						$adminevaluate[$one]['url']=$this->config['sy_weburl']."/index.php?m=evaluate&c=exampaper&titleid=".$adminevaluate[$one]['id']."&gid=".$adminevaluate[$one]['keyid'];
					}
				}
			}
			//http://localhost/phpyun/index.php?m=evaluate&c=exampaper&titleid=52&gid=40
			//print_r($adminevaluate);die;
			$this->yunset("get_type", $_GET); 
			$this->yunset("adminevaluate",$adminevaluate);
			$this->yuntpl(array('admin/admin_evaluate_list'));
			die;
		}
		
		//��������
		if(isset($_GET['evaluate_search']) && $_GET['type']=='1'){
			$where="1 and `keyid`!='0' and `name` like '%".$_GET['keyword']."%'";
			$where.=" order by id desc";
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
			$urlarr['evaluate_search']=$_GET['evaluate_search'];
			$urlarr['order']=$_GET['order'];
			$urlarr['page']="{{page}}";
			$pageurl=$this->url("index",$_GET['m'],$urlarr);  //print_r($urlarr);die;
			//$M=$this->MODEL();
			//$PageInfo=$M->get_page("evaluate_group",$where,$pageurl,$this->config['sy_listnum'],"`id`,`keyid`,`name`,`sort`,`ctime`"); //print_r($PageInfo);die;
			$PageInfo=$this->get_page("evaluate_group",$where,$pageurl,$this->config['sy_listnum'],"`id`,`keyid`,`name`,`sort`,`ctime`");
			$this->yunset($PageInfo);
			$adminevaluate=$PageInfo;	
			//print_r($adminevaluate);die;
			if(is_array($adminevaluate)){
				foreach($adminevaluate as $v){
					$classid[]=$v['keyid'];
				}
			}
			if(is_array($classid))
			{
				$group=$this->obj->DB_select_all("evaluate_group","id in (".@implode(",",$classid).")","`id`,`name`");
			}
			//׷�����url
			foreach($adminevaluate as $one=>$onevalue){			
				foreach($group as $two=>$twovalue){
					if($adminevaluate[$one]['keyid'] == $group[$two]['id']){
						$adminevaluate[$one]['groupname']= $group[$two]['name'];
						$adminevaluate[$one]['url']=$this->config['sy_weburl']."/index.php?m=evaluate&c=exampaper&titleid=".$adminevaluate[$one]['id']."&gid=".$adminevaluate[$one]['keyid'];
					}
				}
			}
			//print_r($adminevaluate);die;
			$this->yunset("get_type", $_GET);
			$this->yunset("adminevaluate",$adminevaluate);
			$this->yuntpl(array('admin/admin_evaluate_list'));
			die;
		}
		//�������
		if(isset($_GET['evaluate_search']) && $_GET['type']=='2'){
			$where = "1 and `keyid`='0' and `name` like '%".$_GET['keyword']."%'";
			$group = $this->obj->DB_select_all("evaluate_group",$where,"`id`,`name`");
			//print_r($group);die
			if(is_array($group)){
				foreach($group as $v){
					$classid[]=$v['id'];
				}
			}
			//print_r($classid);die;
			//ȷ��SQL��������������ҳ
			$where ="1 and `keyid` in (".@implode(",",$classid).") order by `id` desc"; 
			//print_r($where);die;
			//��ҳ
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword']; 
			$urlarr['evaluate_search']=$_GET['evaluate_search']; 
			$urlarr['order']=$_GET['order']; 
			$urlarr['page']="{{page}}";
			$pageurl=$this->url("index",$_GET['m'],$urlarr); 
			//$M=$this->MODEL();																
			//$PageInfo=$M->get_page("evaluate_group",$where,$pageurl,$this->config['sy_listnum'],"`id`,`keyid`,`name`,`sort`,`ctime`");
			$PageInfo=$this->get_page("evaluate_group",$where,$pageurl,$this->config['sy_listnum'],"`id`,`keyid`,`name`,`sort`,`ctime`");
			$this->yunset($PageInfo);
			//print_r($PageInfo);die; 
			$adminevaluate = $PageInfo;  
			//׷�����url
			foreach($adminevaluate as $one=>$onevalue){
				foreach($group as $two=>$twovalue){
					if($adminevaluate[$one]['keyid'] == $group[$two]['id']){
						$adminevaluate[$one]['groupname']=$group[$two]['name'];
						$adminevaluate[$one]['url']=$this->config['sy_weburl']."/index.php?m=evaluate&c=exampaper&titleid=".$adminevaluate[$one]['id']."&gid=".$adminevaluate[$one]['keyid'];
					}
				}
			}
			//print_r($adminevaluate);die;
			$this->yunset("get_type", $_GET);
			$this->yunset("adminevaluate",$adminevaluate);
			$this->yuntpl(array('admin/admin_evaluate_list'));
			die;
		}
	
	}/*end index_action()*/	

	
	//ɾ���Ծ�
	//evaluate_group.id��evaluate.gid���������ɾ��evaluate_group.id����ɾ��evaluate.gid
	//copy form admin_news.class.php>delnews_action()
	function delevaluate_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
				//implode(",",array);������Ԫ����","���ӳ��ַ���
				$this->obj->DB_delete_all("evaluate_group","`id` in(".@implode(',',$del).")","");
				
				//ɾ�������
				$this->obj->DB_delete_all("evaluate","`gid` in(".@implode(',',$del).")","");
				
 				$this->layer_msg('�����Ծ�(ID:'.@implode(',',$del).')ɾ���ɹ���',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('��ѡ����Ҫɾ���Ĳ����Ծ�',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."'";
			$result=$this->obj->DB_delete_all("evaluate_group", $where);
			
			//ɾ�������
			$nid=$this->obj->DB_delete_all("evaluate","`gid`='".$_GET['id']."'","");
			
			isset($result)?$this->layer_msg('�����Ծ�(ID:'.$_GET['id'].')ɾ���ɹ���',9):$this->layer_msg('ɾ��ʧ�ܣ�',8);
		}else{
			$this->obj->ACT_layer_msg( "�Ƿ�������",8,$_SERVER['HTTP_REFERER']);
		}
	}	
	
	/*
	�����˵�������Ծ�
	*/
	
	//��ʾ ��Ӳ����Ծ� ҳ��
	function examadd_action(){
		$group_all = $this->obj->DB_select_all("evaluate_group","`keyid`='0'","`id`,`name`");
		$this->yunset("group_all",$group_all);
		$this->yuntpl(array('admin/admin_evaluate_examadd'));
	}
	//���������Ծ�
	function examsave_action(){
		//���������Ծ�
		if($_POST['subquestion']){
			$groupid = trim($_POST['selectgroup']);  //print_r($groupid);die;	//�������id
			$examtitle = trim($_POST['examtitle']);		//print_r($examtitle);die;	//�Ծ����
			$description = trim($_POST['description']);	//print_r($description);die;	//����
			$fromscore=$_POST['fromscore'];		//print_r($fromscore);die;	
			$toscore=$_POST['toscore'];			
			$comment=$_POST['comment'];									//��������
			$sort = trim($_POST['sort']);					//print_r($sort);die;	//����
			$ctime = time();														//����ʱ��
			$question = $_POST['question'];					//print_r($question);die;//��������
			$option = $_POST['option'];					//print_r($option);die;		//ѡ������
			$score = $_POST['score'];												//ѡ���ֵ����
			
			//�жϿͻ��˴����������Ƿ��п�ֵ
			//echo var_dump($groupid);die;
			if($groupid==0)               {$this->obj->ACT_layer_msg('��ѡ���Ծ���飡',8); die; }
			if(empty($examtitle))         {$this->obj->ACT_layer_msg('����д�Ծ����ƣ�',8); die; }
			if(empty($description)) 	  {$this->obj->ACT_layer_msg('����д������',8); die; }
			
			for($i=0; $i<count($fromscore); $i++){
				if(!strlen($fromscore[$i])) {$this->obj->ACT_layer_msg('����дfrom'.$i.'������',8); die; }
				if(!strlen($toscore[$i]))   {$this->obj->ACT_layer_msg('����дto'.$i.'������',8); die; }
				if(empty($comment[$i]))    {$this->obj->ACT_layer_msg('����д'.$i.'���',8); die; }
			}
			
			if(!strlen($sort))			   {$this->obj->ACT_layer_msg('����д����',8); die; }
			
			foreach($question as $key=>$value){
				if(empty($question[$key]))       {$this->obj->ACT_layer_msg('����д���⣡',8); die; }
				for($i=0; $i<count($option[$key]); $i++){
					if(empty($option[$key][$i])) {$this->obj->ACT_layer_msg('����дѡ�',8); die; }
					if(!strlen($score[$key][$i])){$this->obj->ACT_layer_msg('����д��ֵ��',8); die; }
				}
			}
			
			//echo "ͨ����ֵ��֤";die;
			
			//����ת�ַ���
			$fromscore=serialize($fromscore);		//print_r($fromscore);die;	
			$toscore=serialize($toscore);			
			$comment=serialize($comment);
			
			
			//��$groupid��$examtitle��sort��description��ctime��fromscore��toscore��comment������ evaluate_group
			$val="";
			$val="`keyid`='".$groupid."'";
			$val.=",`name`='".$examtitle."'";
			$val.=",`sort`='".$sort."'";
			$val.=",`description`='".$description."'";
			$val.=",`ctime`='".$ctime."'";
			$val.=",`fromscore`='".$fromscore."'";
			$val.=",`toscore`='".$toscore."'";
			$val.=",`comment`='".$comment."'";
			$examid = $this->obj->DB_insert_once("evaluate_group",$val);	//print_r($examid);die;
			
			$val="";
			foreach($question as $key => $value){
				//$key �� table�ı����ͬ�������ǲ������� 0 2 3
				//ÿѭ��һ�Σ�ѹ��һ�Σ�����һ��
				$option[$key] = serialize($option[$key]);	
				$score[$key] = serialize($score[$key]);		

				$val.="`gid`='".$examid."'";
				$val.=",`question`='".$question[$key]."'";
				$val.=",`option`='".$option[$key]."'";
				$val.=",`score`='".$score[$key]."'";		
				//echo $val;echo "<br>====<br>";
				$this->obj->DB_insert_once("evaluate",$val);
				$val="";
			}
			//////////////�����������У�����������⣬��ô�죿
			$lasturl= $_SERVER['HTTP_REFERER'];
			$this->obj->ACT_layer_msg( "�����Ծ�(ID:".$examid.")��ӳɹ���",9,$lasturl,2,1);
			die;
		}
	}	
	
	/*
	�����˵�������������
	*/
		
	//��������б�
	function group_action(){
		$evaluate_group = $this->obj->DB_select_all("evaluate_group","1 order by `sort` asc","id,keyid,name,sort");     //print_r($evaluate_group);die;
		if(is_array($evaluate_group)){
			foreach($evaluate_group as $key=>$value){
				if($value['keyid']!=0){
					$rootid[$value['keyid']][] = $value['id'];
				}else{
					$rootid[$value['id']][] = $value['id'];
				}
			}
		}//print_r($rootid);die;
		if(is_array($rootid)){
			foreach($rootid as $k=>$v){
				$root_arr = @implode(",",$v);
				$count = $this->obj->DB_select_num("evaluate_group","`keyid`='$k' or keyid IN ($root_arr)");
				
				foreach($evaluate_group as $key=>$value){
					if($value['id']==$k){
						$evaluate_group[$key]['count'] = $count;
						$evaluate_group[$key]['roots'] = count($v)-1;
					}
				}
			}
		}
		//print_r($evaluate_group);die;;;;;;;;;;;
		$this->yunset("evaluate_group",$evaluate_group);
		$this->yuntpl(array('admin/admin_evaluate_group'));
	}
	
	//��ӷ���
	function addgroup_action(){
        if($_POST['sub']){
			if($_POST['classname']!=""){
				if(!is_array($this->obj->DB_select_once("evaluate_group","name='".$_POST['classname']."'"))){
					$va="`name`='".$_POST['classname']."',`keyid`='0'";
					$nbid=$this->obj->DB_insert_once("evaluate_group",$va);
					$this->get_cache();
					isset($nbid)?$this->obj->ACT_layer_msg( "�������(ID:".$nbid.")��ӳɹ���",9,$_SERVER['HTTP_REFERER'],2,1):$this->obj->ACT_layer_msg( "���ʧ�ܣ�",8,$_SERVER['HTTP_REFERER']);
			     }else{
				   $this->obj->ACT_layer_msg( "�Ѿ����ڴ����",8,$_SERVER['HTTP_REFERER']);
			    }
			}else{
				$this->obj->ACT_layer_msg( "����ȷ��д������",8,$_SERVER['HTTP_REFERER']);
		    }
        }
	}
	
	//����޸� ������ơ�����
	function ajax_action(){
		if($_POST['sort'])//�޸�����
		{
			$this->obj->DB_update_all("evaluate_group","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("�������(ID:".$_POST['id'].")�޸�����");
		}
		
		if($_POST['name'])//�޸��������
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("evaluate_group","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$row=$this->obj->DB_select_once("evaluate_group","`id`='".$_POST['id']."'");
			$this->obj->admin_log("�������(ID:".$_POST['id'].")�޸�����");
		}
		$this->get_cache();
		echo '1';die;
	}
	function make_cache_action(){
		$result=$this->get_cache();
		echo $result? 1:0;die;
	}	
	//copy form admin_news.class.php>get_cache()
	//���ݿ�Ļ��棬�������ݿ�ķ���
	function get_cache(){
		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache("../plus/",$this->obj);
		return $makecache=$cacheclass->group_cache("group.cache.php");
	}	
	
	//ɾ������
	function delgroup_action(){
	   $this->check_token();
	   if(isset($_GET['id']))
	   {	
	   		//ɾ������   ɾ���÷����µ������Ծ�
			//$result=$this->obj->DB_delete_all("evaluate_group","`id`='".$_GET['id']."'","");   //echo $result;die;
			
			//�÷��������е��Ծ��id
			$titleid = $this->obj->DB_select_all("evaluate_group","`keyid`='".$_GET['id']."'","id");
			$valueid = array();
			$valueid[0]=$_GET['id'];
			//print_r($valueid);die;
			for($i=0; $i<count($titleid); $i++){
				$valueid[$i+1] = $titleid[$i]['id'];
			}
			$valueid=implode(",",$valueid);
			//print_r($valueid);die;
			$result=$this->obj->DB_delete_all("evaluate_group","`id` in (".$valueid.")",""); 				//print_r($result);die;
			$this->get_cache();
			isset($result)?$this->layer_msg('�������(ID:'.$_GET['id'].')ɾ���ɹ���',9):$this->layer_msg('ɾ��ʧ�ܣ�',8);
	   }
	}
	
	/*
	�޸��Ծ�ҳ��
	���顢�Ծ����ơ��������������Ϣ��֧�֡�����޸ġ�
	ÿ��������Ե����޸�
	�Ը��Ծ��������
	*/	
	//�Ծ��б�ҳ�棬���[�޸�]����ʾ�޸ĸ��Ծ�����
	function examup_action(){		
		//�Ծ����
		$group_all = $this->obj->DB_select_all("evaluate_group","`keyid`='0'","`id`,`name`");
		$this->yunset("group_all",$group_all);
		
		//�Ծ����ơ��������������
		$examid=$_GET['id']; 
		$adminevaluate = $this->obj->DB_select_once("evaluate_group","`id`='".$examid."'");  
		
		$adminevaluate['fromscore'] = unserialize($adminevaluate['fromscore']);
		$adminevaluate['toscore'] = unserialize($adminevaluate['toscore']);
		$adminevaluate['comment'] = unserialize($adminevaluate['comment']);
		//print_r($adminevaluate);die;
		$this->yunset("adminevaluate",$adminevaluate);
		
		//���⡢ѡ��Ծ��ܷ�
		$adminquestion = $this->obj->DB_select_all("evaluate","`gid`='".$examid."'");
		$fullscore=0;
		for($i=0; $i<count($adminquestion); $i++){
			$adminquestion[$i]['option'] = unserialize($adminquestion[$i]['option']);
			$adminquestion[$i]['score'] = unserialize($adminquestion[$i]['score']);
			
			//�Ծ��ܷ�
			$tempscore=0;
			$tempscore=intval($adminquestion[$i]['score'][0]);
			for($row=1; $row<count($adminquestion[$i]['score']); $row++){ 
				//��������ֵ����ǰ���ֵ����ȡ��ֵ
				if($tempscore < $adminquestion[$i]['score'][$row]){
					$tempscore = intval($adminquestion[$i]['score'][$row]);
				}
			}
			$fullscore+=$tempscore;
		}
		//print_r($adminquestion);die;
		$this->yunset("adminquestion",$adminquestion);
		$this->yunset("fullscore",$fullscore);
		
		$this->yuntpl(array('admin/admin_evaluate_examup'));
	}
	
	function ajaxsave_action(){
		$status = $_POST['status'];
		
		//��������
		if($status=="up"){
			$questid = $_POST['questid']; 
			$question = iconv("UTF-8","gb2312",$_POST['question']); //echo $question;die;
			$option = $_POST['option'];
			for($i=0; $i<count($option); $i++){
				$option[$i] = iconv("UTF-8","gb2312",$option[$i]);
			}
			$option=serialize($option);
			$score = serialize($_POST['score']);
			
			$val="`question`='".$question."',";
			$val.="`option`='".$option."',";
			$val.="`score`='".$score."'";
			$scale = $this->obj->DB_update_all("evaluate",$val,"`id`='".$questid."'");
			if($scale>0) $this->obj->admin_log("��������(ID:".$questid.")�޸ĳɹ�");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//���·���
		if($status=="group"){
			$examid = $_POST['examid'];
			$groupid = $_POST['groupid'];
			$val = "`keyid`='".$groupid."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("�����Ծ����(ID:".$questid.")�޸ĳɹ�");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//�����Ծ����
		if($status=="examtitle"){
			$examid = $_POST['examid'];
			$examtitle = iconv("UTF-8","GBK",$_POST['examtitle']);
			
			$val="`name`='".$examtitle."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("�����Ծ�����(ID:".$examid.")�޸ĳɹ�");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//�����Ծ�����
		if($status=="description"){
			$examid = $_POST['examid'];
			$description = iconv("UTF-8","GBK",$_POST['description']);
			
			$val="`description`='".$description."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("�����Ծ�����(ID:".$examid.")�޸ĳɹ�");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//��������
		if($status=="comment"){
			$examid = $_POST['examid'];
			$fromscore = $_POST['fromscore'];
			$toscore = $_POST['toscore'];
			$comment = $_POST['comment'];
			for($i=0; $i<count($comment); $i++){
				$comment[$i] = iconv("UTF-8","GBK",$comment[$i]);
			}
			$fromscore = serialize($fromscore);
			$toscore = serialize($toscore);
			$comment = serialize($comment);
			
			$val="`fromscore`='".$fromscore."',";
			$val.="`toscore`='".$toscore."',";
			$val.="`comment`='".$comment."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("�����Ծ�����(ID:".$examid.")�޸ĳɹ�");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//��������
		if($status=="sort"){
			$examid = $_POST['examid'];
			$sort = $_POST['$sort'];
			
			$val="`sort`='".$sort."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("�����Ծ�����(ID:".$examid.")�޸ĳɹ�");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		
		//���������
		if($status=="savenewquestion"){
			$examid = $_POST['examid'];
			$question = iconv("UTF-8","GBK",$_POST['question']);
			$option = $_POST['option'];
			for($i=0; $i<count($option); $i++){
				$option[$i] = iconv("UTF-8","GBK",$option[$i]);
			}
			$option = serialize($option);
			$score = serialize($_POST['score']);
			
			$val="`gid`='".$examid."',";
			$val.="`question`='".$question."',";
			$val.="`option`='".$option."',";
			$val.="`score`='".$score."',";
			$val.="`sort`='0'";
			$scale = $this->obj->DB_insert_once("evaluate",$val);
			if($scale>0) $this->obj->admin_log("��������(ID:".$scale.")��ӳɹ�"); 
			unset($val);
			unset($scale);
			echo '1';die;
		}
	}	
	
	//ɾ������
	function delquestion_action(){
		$this->check_token();
		if($_GET['qid']){
			$qid=$_GET['qid']; 
			//ɾ������
			$scale = $this->obj->DB_delete_all("evaluate","`id`='".$qid."'");
			isset($scale)?$this->layer_msg('��������(ID:'.$qid.')ɾ���ɹ���',9):$this->layer_msg('ɾ��ʧ�ܣ�',8);
		}
	}
	
	
	
	
	
	
	///////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////
	
}
?>