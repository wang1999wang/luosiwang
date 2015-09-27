<?php
class admin_evaluate_controller extends common {
	
	/*	
	点击编号、发布时间、排序等属性升序/降序排列
	*/	
	
	//首页列出试卷
	function index_action(){
		
		//默认列表
		if(!isset($_GET['evaluate_search'])){
			$where="1 and `keyid`!='0'";
			if($_GET['order'])//id排序、时间排序、sort排序
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
			//追加类别、url
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
		
		//标题搜索
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
			//追加类别、url
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
		//类别搜索
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
			//确定SQL语句条件，方便分页
			$where ="1 and `keyid` in (".@implode(",",$classid).") order by `id` desc"; 
			//print_r($where);die;
			//分页
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
			//追加类别、url
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

	
	//删除试卷
	//evaluate_group.id是evaluate.gid的外键，先删除evaluate_group.id，再删除evaluate.gid
	//copy form admin_news.class.php>delnews_action()
	function delevaluate_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
				//implode(",",array);将数组元素以","连接成字符串
				$this->obj->DB_delete_all("evaluate_group","`id` in(".@implode(',',$del).")","");
				
				//删除外键表
				$this->obj->DB_delete_all("evaluate","`gid` in(".@implode(',',$del).")","");
				
 				$this->layer_msg('测评试卷(ID:'.@implode(',',$del).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的测评试卷！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."'";
			$result=$this->obj->DB_delete_all("evaluate_group", $where);
			
			//删除外键表
			$nid=$this->obj->DB_delete_all("evaluate","`gid`='".$_GET['id']."'","");
			
			isset($result)?$this->layer_msg('测评试卷(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
		}else{
			$this->obj->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}	
	
	/*
	二级菜单：添加试卷
	*/
	
	//显示 添加测评试卷 页面
	function examadd_action(){
		$group_all = $this->obj->DB_select_all("evaluate_group","`keyid`='0'","`id`,`name`");
		$this->yunset("group_all",$group_all);
		$this->yuntpl(array('admin/admin_evaluate_examadd'));
	}
	//保存完整试卷
	function examsave_action(){
		//保存完整试卷
		if($_POST['subquestion']){
			$groupid = trim($_POST['selectgroup']);  //print_r($groupid);die;	//分组类别id
			$examtitle = trim($_POST['examtitle']);		//print_r($examtitle);die;	//试卷标题
			$description = trim($_POST['description']);	//print_r($description);die;	//描述
			$fromscore=$_POST['fromscore'];		//print_r($fromscore);die;	
			$toscore=$_POST['toscore'];			
			$comment=$_POST['comment'];									//评语数组
			$sort = trim($_POST['sort']);					//print_r($sort);die;	//排序
			$ctime = time();														//创建时间
			$question = $_POST['question'];					//print_r($question);die;//问题数组
			$option = $_POST['option'];					//print_r($option);die;		//选项数组
			$score = $_POST['score'];												//选项分值数组
			
			//判断客户端传来的数据是否有空值
			//echo var_dump($groupid);die;
			if($groupid==0)               {$this->obj->ACT_layer_msg('请选择试卷分组！',8); die; }
			if(empty($examtitle))         {$this->obj->ACT_layer_msg('请填写试卷名称！',8); die; }
			if(empty($description)) 	  {$this->obj->ACT_layer_msg('请填写描述！',8); die; }
			
			for($i=0; $i<count($fromscore); $i++){
				if(!strlen($fromscore[$i])) {$this->obj->ACT_layer_msg('请填写from'.$i.'分数！',8); die; }
				if(!strlen($toscore[$i]))   {$this->obj->ACT_layer_msg('请填写to'.$i.'分数！',8); die; }
				if(empty($comment[$i]))    {$this->obj->ACT_layer_msg('请填写'.$i.'评语！',8); die; }
			}
			
			if(!strlen($sort))			   {$this->obj->ACT_layer_msg('请填写排序！',8); die; }
			
			foreach($question as $key=>$value){
				if(empty($question[$key]))       {$this->obj->ACT_layer_msg('请填写问题！',8); die; }
				for($i=0; $i<count($option[$key]); $i++){
					if(empty($option[$key][$i])) {$this->obj->ACT_layer_msg('请填写选项！',8); die; }
					if(!strlen($score[$key][$i])){$this->obj->ACT_layer_msg('请填写分值！',8); die; }
				}
			}
			
			//echo "通过空值验证";die;
			
			//数组转字符串
			$fromscore=serialize($fromscore);		//print_r($fromscore);die;	
			$toscore=serialize($toscore);			
			$comment=serialize($comment);
			
			
			//将$groupid、$examtitle、sort、description、ctime、fromscore、toscore、comment保存至 evaluate_group
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
				//$key 与 table的编号相同，可以是不连续的 0 2 3
				//每循环一次，压缩一次，保存一次
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
			//////////////添加问题过程中，如果出现意外，怎么办？
			$lasturl= $_SERVER['HTTP_REFERER'];
			$this->obj->ACT_layer_msg( "测评试卷(ID:".$examid.")添加成功！",9,$lasturl,2,1);
			die;
		}
	}	
	
	/*
	二级菜单：测评类别管理
	*/
		
	//测评类别列表
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
	
	//添加分组
	function addgroup_action(){
        if($_POST['sub']){
			if($_POST['classname']!=""){
				if(!is_array($this->obj->DB_select_once("evaluate_group","name='".$_POST['classname']."'"))){
					$va="`name`='".$_POST['classname']."',`keyid`='0'";
					$nbid=$this->obj->DB_insert_once("evaluate_group",$va);
					$this->get_cache();
					isset($nbid)?$this->obj->ACT_layer_msg( "测评类别(ID:".$nbid.")添加成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->obj->ACT_layer_msg( "添加失败！",8,$_SERVER['HTTP_REFERER']);
			     }else{
				   $this->obj->ACT_layer_msg( "已经存在此类别！",8,$_SERVER['HTTP_REFERER']);
			    }
			}else{
				$this->obj->ACT_layer_msg( "请正确填写你的类别！",8,$_SERVER['HTTP_REFERER']);
		    }
        }
	}
	
	//点击修改 类别名称、排序
	function ajax_action(){
		if($_POST['sort'])//修改排序
		{
			$this->obj->DB_update_all("evaluate_group","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->obj->admin_log("测评类别(ID:".$_POST['id'].")修改排序");
		}
		
		if($_POST['name'])//修改类别名称
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("evaluate_group","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$row=$this->obj->DB_select_once("evaluate_group","`id`='".$_POST['id']."'");
			$this->obj->admin_log("测评类别(ID:".$_POST['id'].")修改名称");
		}
		$this->get_cache();
		echo '1';die;
	}
	function make_cache_action(){
		$result=$this->get_cache();
		echo $result? 1:0;die;
	}	
	//copy form admin_news.class.php>get_cache()
	//数据库的缓存，减少数据库的访问
	function get_cache(){
		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache("../plus/",$this->obj);
		return $makecache=$cacheclass->group_cache("group.cache.php");
	}	
	
	//删除分组
	function delgroup_action(){
	   $this->check_token();
	   if(isset($_GET['id']))
	   {	
	   		//删除分组   删除该分组下的所有试卷。
			//$result=$this->obj->DB_delete_all("evaluate_group","`id`='".$_GET['id']."'","");   //echo $result;die;
			
			//该分组下所有的试卷的id
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
			isset($result)?$this->layer_msg('测评类别(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
	   }
	}
	
	/*
	修改试卷页面
	分组、试卷名称、描述、排序等信息，支持“点击修改”
	每道问题可以单独修改
	对该试卷添加问题
	*/	
	//试卷列表页面，点击[修改]，显示修改该试卷内容
	function examup_action(){		
		//试卷分组
		$group_all = $this->obj->DB_select_all("evaluate_group","`keyid`='0'","`id`,`name`");
		$this->yunset("group_all",$group_all);
		
		//试卷名称、描述、评语、排序
		$examid=$_GET['id']; 
		$adminevaluate = $this->obj->DB_select_once("evaluate_group","`id`='".$examid."'");  
		
		$adminevaluate['fromscore'] = unserialize($adminevaluate['fromscore']);
		$adminevaluate['toscore'] = unserialize($adminevaluate['toscore']);
		$adminevaluate['comment'] = unserialize($adminevaluate['comment']);
		//print_r($adminevaluate);die;
		$this->yunset("adminevaluate",$adminevaluate);
		
		//问题、选项、试卷总分
		$adminquestion = $this->obj->DB_select_all("evaluate","`gid`='".$examid."'");
		$fullscore=0;
		for($i=0; $i<count($adminquestion); $i++){
			$adminquestion[$i]['option'] = unserialize($adminquestion[$i]['option']);
			$adminquestion[$i]['score'] = unserialize($adminquestion[$i]['score']);
			
			//试卷总分
			$tempscore=0;
			$tempscore=intval($adminquestion[$i]['score'][0]);
			for($row=1; $row<count($adminquestion[$i]['score']); $row++){ 
				//如果后面的值大于前面的值，则取大值
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
		
		//更新问题
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
			if($scale>0) $this->obj->admin_log("测评问题(ID:".$questid.")修改成功");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//更新分组
		if($status=="group"){
			$examid = $_POST['examid'];
			$groupid = $_POST['groupid'];
			$val = "`keyid`='".$groupid."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("测评试卷分组(ID:".$questid.")修改成功");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//更新试卷标题
		if($status=="examtitle"){
			$examid = $_POST['examid'];
			$examtitle = iconv("UTF-8","GBK",$_POST['examtitle']);
			
			$val="`name`='".$examtitle."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("测评试卷名称(ID:".$examid.")修改成功");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//更新试卷描述
		if($status=="description"){
			$examid = $_POST['examid'];
			$description = iconv("UTF-8","GBK",$_POST['description']);
			
			$val="`description`='".$description."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("测评试卷描述(ID:".$examid.")修改成功");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//更新评语
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
			if($scale>0) $this->obj->admin_log("测评试卷描述(ID:".$examid.")修改成功");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		//更新排序
		if($status=="sort"){
			$examid = $_POST['examid'];
			$sort = $_POST['$sort'];
			
			$val="`sort`='".$sort."'";
			$scale = $this->obj->DB_update_all("evaluate_group",$val,"`id`='".$examid."'");
			if($scale>0) $this->obj->admin_log("测评试卷排序(ID:".$examid.")修改成功");
			unset($val);
			unset($scale);
			echo '1';die;
		}
		
		//添加新问题
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
			if($scale>0) $this->obj->admin_log("测评问题(ID:".$scale.")添加成功"); 
			unset($val);
			unset($scale);
			echo '1';die;
		}
	}	
	
	//删除问题
	function delquestion_action(){
		$this->check_token();
		if($_GET['qid']){
			$qid=$_GET['qid']; 
			//删除问题
			$scale = $this->obj->DB_delete_all("evaluate","`id`='".$qid."'");
			isset($scale)?$this->layer_msg('测评问题(ID:'.$qid.')删除成功！',9):$this->layer_msg('删除失败！',8);
		}
	}
	
	
	
	
	
	
	///////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////
	
}
?>