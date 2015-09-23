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
class admin_school_controller extends common
{
	function set_search(){
		$cate=$this->obj->DB_select_all("school_group","1","`id`,`name`");
		if(!empty($cate)){
			foreach($cate as  $k=>$v){
                $schoolarr[$v['id']]=$v['name'];
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
		$lo_time=array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]=array("param"=>"publish","name"=>'发布时间',"value"=>$lo_time);
		$search_list[]=array("param"=>"cate","name"=>'文章类别',"value"=>$schoolarr);
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
         $where="1";
		 if ($_GET['cate']!=''){
			$where.=" and `nid`='".$_GET['cate']."'";
			$urlarr['cate']=$_GET['cate'];
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
		if($_GET['school_search']){
			if ($_GET['type']=='1'){
				$where.=" and `title` like '%".$_GET['keyword']."%'";
			}elseif ($_GET['type']=='2'){
				$where.=" and `author` like '%".$_GET['keyword']."%'";
			}
			$urlarr['type']=$_GET['type'];
			$urlarr['keyword']=$_GET['keyword'];
			$urlarr['school_search']=$_GET['school_search'];
		}

		if($_GET['order'])
		{
			$where.=" order by ".$_GET['t']." ".$_GET['order'];
			$urlarr['order']=$_GET['order'];
			$urlarr['t']=$_GET['t'];
		}else{
			$where.=" order by sort asc";
		}
		$urlarr['order']=$_GET['order'];
		$urlarr['page']="{{page}}";
		$pageurl=Url($_GET['m'],$urlarr,'admin');
        $M=$this->MODEL();
		$PageInfo=$M->get_page("school_base",$where,$pageurl,$this->config['sy_listnum']);
        $this->yunset($PageInfo);
        $adminschool=$PageInfo['rows'];
		if(is_array($adminschool)){
			foreach($adminschool as $v){
				$classid[]=$v['nid'];
			}
		}
		if(is_array($classid))
		{
			$group=$this->obj->DB_select_all("school_group","id in (".@implode(",",$classid).")");
		}
		$property=$this->obj->DB_select_all("property");
		if(is_array($group))
		{
			foreach($adminschool as $k=>$v)
			{
				$adminschool[$k]['url']=Url('article',array('c'=>'show','id'=>$v['id']));
				$adminschool[$k]['title']=mb_substr($v['title'],0,20,"GBK");
				foreach($group as $key=>$value)
				{
					if($value['id']==$v['nid'])
					{
						$adminschool[$k]['name']=$value['name'];
					}
				}
				if($v['newsphoto']!=""){
					$type.=" 图";
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
					$adminschool[$k]['titype']="[<font color='red'>".$type."</font> ]";
				}
				$type=$describe="";
			}
		}

        $this->yunset("get_type", $_GET);
		$this->yunset("adminschool",$adminschool);
		$this->yunset("property",$property);
		$this->yunset("propertys",$property);
		$this->yuntpl(array('admin/admin_school_list'));
	}
	function property_action(){
		if(!$_POST['id']){
			$nbid=$this->obj->DB_insert_once("property","`name`='".$_POST['name']."',`value`='".$_POST['value']."'");
			isset($nbid)?$this->ACT_layer_msg( "文章属性(ID:".$nbid.")添加成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "添加失败！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$nbid=$this->obj->DB_update_all("property","`name`='".$_POST['name']."',`value`='".$_POST['value']."'","`id`='".$_POST['id']."'");
			isset($nbid)?$this->ACT_layer_msg( "文章属性(ID:".$_POST['id'].")更新成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "更新失败！",8,$_SERVER['HTTP_REFERER']);
		}
	}
	function savepro_action(){
		if($_POST['type']=="add"){
			$describe=@implode(",",$_POST['describe']);
			
			$row=$this->obj->DB_select_all("school_base","`id` in (".$_POST['proid'].")");
			foreach($row as $k=>$v){
				if($v['describe']==""){
					$this->obj->DB_update_all("school_base","`describe`='".$describe."'","`id`='".$v['id']."'");
				}else{
					$describes = @explode(',',$v['describe']);
					
					foreach($_POST['describe'] as $key=>$value){
						
						if(!in_array($value,$describes))
						{
							
							$describes[] = $value;
						}
					}
					$this->obj->DB_update_all("school_base","`describe`='".@implode(',',$describes)."'","`id`='".$v['id']."'");
				}
			}
			$this->ACT_layer_msg("文章(ID:".$_POST['proid'].")添加属性成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		if($_POST['type']=="del" && $_POST['proid']){
			if($_POST['describe'])
			{
				$list = $this->obj->DB_select_all("school_base","`id` in(".$_POST['proid'].") AND `describe`<>''","`id`,`describe`");
				if(is_array($list))
				{
					foreach($list as $key=>$value){
					
						if($value['describe'])
						{
							$describe = @explode(',',$value['describe']);
							
							foreach($describe as $key=>$v){
								
								if(in_array($v,$_POST['describe']))
								{
									unset($describe[$key]);
								}
							}
							$this->obj->DB_update_all("school_base","`describe`='".@implode(',',$describe)."'","`id`='".$value['id']."'");
						}
					}
				}
			}
			
			$this->ACT_layer_msg("文章(ID:".$_POST['proid'].")删除属性成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
	}
	function delpro_action(){
		$this->check_token();
		if($_GET['id']){
			$this->obj->DB_delete_all("property","`id`='".(int)$_GET['id']."'");
			$this->layer_msg("文章属性(ID:".$_POST['id'].")删除成功",9,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function school_action(){
		if($_GET[nid]){
			$school[nid]=$_GET[nid];
			$this->yunset("school",$school[nid]);
		}
		$school_group=$this->obj->DB_select_all("school_group");
		$a=0;$b=0;
		if(is_array($school_group)){
			foreach($school_group as $key=>$v){
				if($v['keyid']==0){
					$one_class[$a]['id']=$v['id'];
					$one_class[$a]['name']=$v['name'];
					$a++;
				}
				if($v['keyid']!=0){
					if(!is_array($two_class[$v['keyid']]))$b=0;
					$two_class[$v['keyid']][$b]['id']=$v['id'];
					$two_class[$v['keyid']][$b]['name']=$v['name'];
					$b++;
				}
			}
		}
        $this->yunset("one_class",$one_class);
	    $this->yunset("two_class",$two_class);
		$property=$this->obj->DB_select_all("property");
		$this->yunset("property",$property);
		$domain = $this->obj->DB_select_all("domain","1","`id`,`title`");
		$this->yunset("domain",$domain);
		if($_GET['id']){
			$school = $this->obj->DB_select_once("school_base","`id`='".$_GET['id']."'");
			//$row = $this->obj->DB_select_once("school_content","`nbid`='".$_GET['id']."'");
			//$school['content']=str_replace("&","&amp;",$row['content']);
			$describe=@explode(',',$school['describe']);
			$this->yunset("describe",$describe);
			$this->yunset("school",$school);
			$this->yunset("lasturl",$_SERVER['HTTP_REFERER']);
			if($school['did']>0){
				$domainone = $this->obj->DB_select_once("domain","`id`='".$school['did']."'","`title`");
				$this->yunset("domainname",$domainone['title']);
			}
		}else{
			$school['sort']=rand(1, 300 );
			$this->yunset("school",$school);
		}

		$this->yuntpl(array('admin/admin_school_add'));
	}
	function addschool_action()
	{
		if($_POST['updateschool'])
		{
			$school_base=$this->obj->DB_select_once('school_base',"`id`='".$_POST['id']."'","`newsphoto`,`s_thumb`,`datetime`");
			if($_POST['uplocadpic'])
			{
				if($school_base['s_thumb']!=$_POST['uplocadpic']){
					if($school_base['s_thumb']){
						unlink_pic('../'.$school_base['s_thumb']);
						unlink_pic('../'.$school_base['newsphoto']);
					}
					$upload=$this->upload_pic("../data/upload/school/");
					if(file_exists('..'.$_POST['uplocadpic'])){
						$uplocadpic=$upload->picture('..'.$_POST['uplocadpic'],false,1);//同名文件已经存在了
 						$s_thumb=$upload->news_makeThumb($uplocadpic,120,120,'_S_');
						$value.="`newsphoto`='" . str_replace("../data/upload/new","data/upload/new",$uplocadpic) . "',";
						$value.="`s_thumb`='" . str_replace("../data/upload/new","data/upload/new",$s_thumb) . "',";
					}else{
						$s_thumb=$upload->news_makeThumb('..'.$_POST['uplocadpic'],120,120,'_S_');
						$value.="`newsphoto`='" . str_replace("/config/","config/",$_POST['uplocadpic']) . "',";
						$value.="`s_thumb`='" . str_replace("../config/","config/",$s_thumb) . "',";
					}
				}
				unlink_pic('..'.$_POST['uplocadpic']);
			}
			$content = str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'','',''),html_entity_decode($_POST["content"],ENT_QUOTES,"GB2312"));
			$describe = @implode(",",$_POST['describe']);
			$time = time();
			if(empty($_POST['did']))
			{
				$_POST['did']=0;
			}
			$value.="`did`='".$_POST['did']."',";
			$value.="`color`='".$_POST['color']."',";
			$value.="`sort`='".$_POST['sort']."',";
			$value.="`nid`='".$_POST['nid']."',";
			$value.="`author`='".$_POST['author']."',";
			$value.="`source`='".$_POST['source']."',";
			$value.="`title`='".$_POST['title']."',";
			$value.="`describe`='".$describe."',";
			$value.="`lastupdate`='".$time."',";
            $value.="`content`='".$content."',";
			if(!$_POST['keyword']){
				require(LIB_PATH."lib_splitword_class.php");
				$sp = new SplitWord();
				$keywordarr=$sp->getkeyword(strip_tags($content));
				$value.="`keyword`='".@implode(",",$keywordarr)."',";
			}else{
				$value.="`keyword`='".$_POST['keyword']."',";
			}
			$value.="`description`='".$_POST['description']."'";
			$nbid=$this->obj->DB_update_all("school_base",$value,"`id`='".$_POST['id']."'");

			$row=$this->obj->DB_select_once('school_content',"`nbid`='".$_POST['id']."'","nbid");
			if(is_array($row)){
				$cont = $this->obj->DB_update_all("school_content", "`content`='".$content."'","`nbid`='".$_POST['id']."'");
			}else{
				$cont = $this->obj->DB_insert_once("school_content", "`nbid`='".$_POST['id']."',`content`='".$content."'");
			}
			$this->autohtml($_POST['id'],$school_base['datetime']);
			isset($nbid)?$this->ACT_layer_msg( "文章(ID:".$_POST['id'].")更新成功！",9,Url('admin_school',null,'admin'),2,1):$$this->ACT_layer_msg( "更新失败！",8,Url('admin_school',null,'admin'));
		}
	    if($_POST['schooladd']){
			if($_POST['uplocadpic']){
				$upload=$this->upload_pic("../data/upload/school/");
				if(file_exists('..'.$_POST['uplocadpic'])){
					$uplocadpic=$upload->picture('..'.$_POST['uplocadpic'],false,1);
 					$s_thumb=$upload->news_makeThumb($uplocadpic,120,120,'_S_');
					$value.="`newsphoto`='" . str_replace("../data/upload/new","data/upload/new",$uplocadpic) . "',";
					$value.="`s_thumb`='" . str_replace("../data/upload/new","data/upload/new",$s_thumb) . "',";
				}else{
					$s_thumb=$upload->news_makeThumb('..'.$_POST['uplocadpic'],120,120,'_S_');
					$value.="`newsphoto`='" . str_replace("/config/","config/",$_POST['uplocadpic']) . "',";
					$value.="`s_thumb`='" . str_replace("../config/","config/",$s_thumb) . "',";
				}
				unlink_pic('..'.$_POST['uplocadpic']);
			}

			$content = str_replace(array("&amp;","background-color:#ffffff","background-color:#fff","white-space:nowrap;"),array("&",'','',""),html_entity_decode($_POST["content"],ENT_QUOTES,"GB2312"));
			$describe = @implode(",",$_POST['describe']);
			$time = time();
			if($_POST['sort']!=''){
				$value.="`sort`='".$_POST['sort']."',";
			}else{
				$value.="`sort`='0',";
			}
			if(empty($_POST['did']))
			{
				$_POST['did']=0;
			}
			$value.="`did`='".$_POST['did']."',";
			$value.="`color`='".$_POST['color']."',";
			$value.="`nid`='".$_POST['nid']."',";
			$value.="`author`='".$_POST['author']."',";
			$value.="`source`='".$_POST['source']."',";
			$value.="`title`='".$_POST['title']."',";
			$value.="`datetime`='".$time."',";
			$value.="`lastupdate`='".$time."',";
			$value.="`describe`='".$describe."',";
            $value.="`content`='".$content."',";

			if(!$_POST["keyword"]){
				require(LIB_PATH."lib_splitword_class.php");
				$sp = new SplitWord();
				$keywordarr=$sp->getkeyword(strip_tags($content));
				$value.="`keyword`='".@implode(",",$keywordarr)."',";
			}else{
				$value.="`keyword`='".$_POST['keyword']."',";
			}
			$value.="`description`='".$_POST["description"]."'";
			$nbid=$this->obj->DB_insert_once("school_base",$value);
			$cont = $this->obj->DB_insert_once("school_content", "`nbid`='$nbid',`content`='" .$content. "'");
			$this->autohtml($nbid,$time);
			isset($cont)?$this->ACT_layer_msg( "文章(ID:".$nbid.")添加成功！",9,Url('admin_school',null,'admin'),2,1):$this->ACT_layer_msg( "添加失败！",8,Url('admin_school',null,'admin'));
		}
	}
	function group_action(){
		$school_group = $this->obj->DB_select_all("school_group","1 order by `id` desc");
		if(is_array($school_group)){
			foreach($school_group as $key=>$value){
				if($value['keyid']!=0){
					$rootid[$value['keyid']][] = $value['id'];
				}else{
					$rootid[$value['id']][] = $value['id'];
				}
			}
		}
		if(is_array($rootid)){
			foreach($rootid as $k=>$v){
				$root_arr = @implode(",",$v);
				$count = $this->obj->DB_select_num("school_base","`nid`='$k' or nid IN ($root_arr)");
				foreach($school_group as $key=>$value){
					if($value['id']==$k){
						$school_group[$key]['count'] = $count;
						$school_group[$key]['roots'] = count($v)-1;
					}
				}
			}
		}
	    $info=$this->obj->DB_select_once("school_group","`id`='".$_GET['id']."'");
	    $subclass=$this->obj->DB_select_all("school_group","`keyid`='".$info['id']."'");
	    $school=$this->obj->DB_select_all("school_group","keyid!=0");

        $this->yunset("info",$info);
        $this->yunset("school_group",$school_group);
        $this->yunset("subclass",$subclass);
		$type=$this->obj->DB_select_all("navigation_type");
		$this->yunset("type",$type);
		$this->yuntpl(array('admin/admin_school_group'));
	}
	function addgroup_action(){
        if($_POST['sub']){
			if($_POST['classname']!=""){
				if(!is_array($this->obj->DB_select_once("school_group","name='".$_POST['classname']."'"))){
					if($_POST['f_id']=='0'){
						$va="`name`='".$_POST['classname']."',`keyid`='".$_POST['f_id']."',`rec`='".$_POST['rec']."'";
					}else{
						$va="`name`='".$_POST['classname']."',`keyid`='".$_POST['f_id']."'";
					}
					$nbid=$this->obj->DB_insert_once("school_group",$va);
					$this->get_cache();
					isset($nbid)?$this->ACT_layer_msg( "文章类别(ID:".$nbid.")添加成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "添加失败！",8,$_SERVER['HTTP_REFERER']);
			     }else{
				   $this->ACT_layer_msg( "已经存在此类别！",8,$_SERVER['HTTP_REFERER']);
			    }
			}else{
				$this->ACT_layer_msg( "请正确填写你的类别！",8,$_SERVER['HTTP_REFERER']);
		    }
        }
	    if($_POST['update']){
	    	 $update=$this->obj->DB_update_all("school_group","`name`='".$_POST['procity']."'","`id`='".$_POST['id']."'");
	         $this->get_cache();
			 isset($update)?$this->ACT_layer_msg( "文章类别(ID:".$_POST['id'].")更新成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg( "更新失败！",8,$_SERVER['HTTP_REFERER']);
	    }
	}
	function recommend_action(){
		$nid=$this->obj->DB_update_all("school_group","`".$_GET['type']."`='".$_GET['rec']."'","`id`='".$_GET['id']."' and `keyid`='0'");
		$this->get_cache();
		echo $nid?1:0;die;
	}
	function recschool_action(){
		$nid=$this->obj->DB_update_all("school_group","`".$_GET['type']."`='".$_GET['rec_school']."'","`id`='".$_GET['id']."' and `keyid`='0'");
		$this->get_cache();
		echo $nid?1:0;die;
	}
	function delschool_action(){
		$this->check_token();
	    if($_GET['del']){
	    	$del=$_GET['del'];
	    	if(is_array($del)){
				$this->obj->DB_delete_all("school_base","`id` in(".@implode(',',$del).")","");
				$this->obj->DB_delete_all("school_content","`nbid` in(".@implode(',',$del).")","");
 				$this->layer_msg('文章(ID:'.@implode(',',$del).')删除成功！',9,1,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->layer_msg('请选择您要删除的文章！',8,1,$_SERVER['HTTP_REFERER']);
	    	}
	    }
	    if(isset($_GET['id'])){
			$where="`id`='".$_GET['id']."'";
			$result=$this->obj->DB_delete_all("school_base", $where);
			$nid=$this->obj->DB_delete_all("school_content","`nbid`='".$_GET['id']."'");
			isset($nid)?$this->layer_msg('文章(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
		}else{
			$this->ACT_layer_msg( "非法操作！",8,$_SERVER['HTTP_REFERER']);
		}
	}

	function delgroup_action()
	{
		$this->check_token();
	   if(isset($_GET['id']))
	   {
			$result=$this->obj->DB_delete_all("school_group","`id`='".$_GET['id']."' or `keyid`='".$_GET['id']."'","");
			$this->get_cache();
			isset($result)?$this->layer_msg('文章类别(ID:'.$_GET['id'].')删除成功！',9):$this->layer_msg('删除失败！',8);
	   }
	}
	function autohtml($id,$time){
        $this->articleshow($id);
	}
	function ajax_action()
	{
		if($_POST['sort'])
		{
			$this->obj->DB_update_all("school_group","`sort`='".$_POST['sort']."'","`id`='".$_POST['id']."'");
			$this->admin_log("文章类别(ID:".$_POST['id'].")修改排序");
		}
		if($_POST['name'])
		{
			$_POST['name']=iconv("UTF-8","gbk",$_POST['name']);
			$this->obj->DB_update_all("school_group","`name`='".$_POST['name']."'","`id`='".$_POST['id']."'");
			$row=$this->obj->DB_select_once("school_group","`id`='".$_POST['id']."'");
			if($row['is_menu']=="1")
			{
				$this->obj->DB_update_all("navigation","`name`='".$_POST['name']."'","`school`='".$_POST['id']."'");
				$this->menu_cache_action();
			}
			$this->admin_log("文章类别(ID:".$_POST['id'].")修改名称");
		}
		$this->get_cache();
		echo '1';die;
	}
	function make_cache_action(){
		$result=$this->get_cache();
		echo $result? 1:0;die;
	}
	function get_cache(){
		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		return $makecache=$cacheclass->group_cache("group.cache.php");
	}
	function ajax_menu_action()
	{
		if($_POST['id'])
		{
			$row=$this->obj->DB_select_once("school_group","`id`='".$_POST['id']."'");
			if($row['is_menu']=="1")
			{
				$info=$this->obj->DB_select_once("navigation","`school`='".$_POST['id']."'");
				$arr['id']=$info['id'];
				$arr['nid']=$info['nid'];
				$arr['name']=iconv("gbk","utf-8",$info['name']);
				$arr['color']=$info['color'];
				$arr['url']=$info['url'];
				$arr['furl']=$info['furl'];
				$arr['type']=$info['type'];
				$arr['sort']=$info['sort'];
				$arr['eject']=$info['eject'];
				$arr['model']=$info['model'];
				$arr['bold']=$info['bold'];
				$arr['display']=$info['display'];
			}else{
				$arr['name']=iconv("gbk","utf-8",$row['name']);
				$arr['url']="school/".$row['id']."/";
				$arr['furl']="m_school-c_list-nid_".$row['id'].".html";
			}
			echo urldecode(json_encode($arr));die;
		}
	}
	function set_menu_action()
	{
	    if($_POST['submit'])
	    {
	    	if($_POST['id'])
	    	{
	    		$where=" and `id`<>'".$_POST['id']."'";
	    	}
	    	$row=$this->obj->DB_select_once("navigation","name='".$_POST['name']."' and `nid`='".$_POST['nid']."'".$where);
	    	if(!is_array($row))
	    	{
				$value.="`nid`='".$_POST['nid']."',";
				$value.="`eject`='".$_POST['eject']."',";
				$value.="`display`='".$_POST['display']."',";
				$value.="`name`='".$_POST['name']."',";
				$url = str_replace("amp;","",$_POST['url']);
				$value.="`url`='".$url."',";
				$value.="`furl`='".$_POST['furl']."',";
				$value.="`sort`='".$_POST['sort']."',";
				$value.="`color`='".$_POST['color']."',";
				$value.="`model`='".$_POST['model']."',";
				$value.="`bold`='".$_POST['bold']."',";
				$value.="`type`='".$_POST['type']."'";
				if($_POST['id'])
				{
					$nbid=$this->obj->DB_update_all("navigation",$value,"`id`='".$_POST['id']."'");
					$msg="文章类别导航更新";
				}else{
					$value.=",`school`='".$_POST['did']."'";
					$nbid=$this->obj->DB_insert_once("navigation",$value);
					$this->obj->DB_update_all("school_group","`is_menu`='1'","`id`='".$_POST['did']."'");
					$msg="文章类别导航添加";
				}
				$this->menu_cache_action();
				isset($nbid)?$this->ACT_layer_msg( $msg."成功！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg( $msg."失败！",8,$_SERVER['HTTP_REFERER']);
	    	}else{
				$this->ACT_layer_msg( "已经存在此导航！",8,$_SERVER['HTTP_REFERER']);
	    	}
		}
	}
	function delmenu_action()
	{
		if($_GET['id'])
		{
			$this->check_token();
			$this->obj->DB_update_all("school_group","`is_menu`='0'","`id`='".$_GET['id']."'");
			$this->obj->DB_delete_all("navigation","`school`='".$_GET['id']."'");
			$this->menu_cache_action();
			$this->layer_msg("文章类别导航(".$_GET['id'].")取消成功",9,0,$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('非法操作',8,0,$_SERVER['HTTP_REFERER']);
		}
	}
	function menu_cache_action(){
		include_once(LIB_PATH."cache.class.php");
		$cacheclass= new cache(PLUS_PATH,$this->obj);
		$makecache=$cacheclass->menu_cache("menu.cache.php");
	}
    function articleshow($id){
		$M=$this->MODEL('school');
		$school=$M->GetSchoolBaseOnce(array('id'=>$id));
		$row=$M->GetSchoolContentOnce(array('nbid'=>$id));
		$school['content']=$row['content'];
		$school_last=$M->GetSchoolBaseOnce(array("`id`<'".$id."'"),array('orderby'=>" `id` desc"));

		if(!empty($school_last)){
			if($this->config[sy_school_rewrite]=="2"){
				$school_last["url"]=$this->config['sy_weburl']."/school/".date("Ymd",$school_last["datetime"])."/".$school_last['id'].".html";
			}else{
				$school_last["url"]= Url("index",'school',array('c'=>'show',"id"=>$school_last[id]),"1");
			}
		}
		$school_next=$M->GetSchoolBaseOnce(array("`id`>'".$id."'"),array('orderby'=>" `id` desc"));
		if(!empty($school_next)){
			if($this->config[sy_school_rewrite]=="2"){
				$school_next["url"]=$this->config['sy_weburl']."/school/".date("Ymd",$school_next["datetime"])."/".$school_next['id'].".html";
			}else{
				$school_next["url"]= Url("index",'school',array('c'=>'show',"id"=>$school_next[id]),"1");
			}
		}
		$class=$M->GetSchoolGroupOnce(array("id"=>$school['nid']));
		if($school["keyword"]!="")
		{
			$keyarr = @explode(",",$school["keyword"]);
			if(is_array($keyarr) && !empty($keyarr))
			{
				foreach($keyarr as $key=>$value){
					$sqlkeyword[]= " `keyword` LIKE '%$value%'";
				}
				$sqlkw = @implode(" OR ",$sqlkeyword);
				$about=$M->GetSchoolBaseList(array("(".$sqlkw.") and `id`<>'".$id."'"),array("orderby"=>'`id` desc ','limit'=>6));//相关文章
				if(is_array($about)){
					foreach($about as $k=>$v){
						if($this->config[sy_school_rewrite]=="2"){
							$about[$k]["url"]=$this->config['sy_weburl']."/school/".date("Ymd",$v["datetime"])."/".$v['id'].".html";
						}else{
							$about[$k]["url"]= Url("index",'school',array('c'=>'show',"id"=>$v[id]),"1");
						}

					}
				}
			}
		}
		$info=$school;
		$data['school_title']=$school['title'];
		$data['school_keyword']=$school['keyword'];
		$data['school_class']=$class['name'];
		$data['school_desc']=$this->GET_content_desc($school['description']);
		$this->data=$data;
		$info["school_class"]=$class['name'];
		$info["last"]=$school_last;
		$info["next"]=$school_next;
		$info["like"]=$about;
		$this->yunset("Info",$info);

		$this->seo("school_article");
        global $phpyun;
        $contect = $phpyun->fetch(TPL_PATH.'default/article/show.htm',$id);
        $fp = fopen(APP_PATH.'school/'.$id.'.html', "w");
        fwrite($fp, $contect);
        fclose($fp);
	}
}
?>