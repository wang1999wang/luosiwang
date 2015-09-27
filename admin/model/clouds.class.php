<?php
class clouds_controller extends common
{
	function index_action(){
		$this->yuntpl(array('admin/admin_clouds'));
	}
	//保存
	function save_action(){
 		if($_POST["config"]){
		 unset($_POST["config"]);
		   foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   if($config==false){
					$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			   }else{
					$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");
			   }
		 	}
			$this->web_config();
			$this->ACT_layer_msg("网站配置设置成功！",9,1,2,1);
		 }
	}

	function resume_action(){
		$this->industry_cache();
		$this->yuntpl(array('admin/admin_clouds'));
	}
	function job_action(){
		$this->industry_cache();
		$this->yuntpl(array('admin/admin_clouds'));
	}
	//同步分类
	function tb_action(){
		if($_POST['action']=="job"){
			$data=$this->get_job($_POST['id']);
		}else{
			$data=$this->get_resume($_POST['id']);
		}
		$arr=json_decode($data,true);
		$arr['error']=str_replace('！','',$arr['error']);
		echo json_encode($arr);die;
	}

	//同步职位
	function get_job_action(){
			include PLUS_PATH."/job.cache.php";
			include PLUS_PATH."/city.cache.php";
			include PLUS_PATH."/com.cache.php";
			include PLUS_PATH."/industry.cache.php";
			$swhere = $this->searchwhere($_GET);
			$jobs = $this->obj->DB_select_all('company_job',$swhere['where'].' '.$swhere['limit']);
			if(is_array($jobs))
			{
				foreach($jobs as $key=>$value)
				{
					$uids[] = $value['uid'];
				}
				
				$comlist = $this->obj->DB_select_all('company',"`uid` IN (".@implode(',',$uids).")","uid,name as com_name,sdate as com_sdate,hy as com_hy,address,money,zip,website,mun,pr,content");
				
				foreach($comlist as $k=>$v)
				{
					$cominfo[$v['uid']] = $v;
				}
					
				foreach($jobs as $key=>$value)
				{
					$data=array();

					$row=array_merge($value,$cominfo[$value['uid']]);
					
					$data['com_name']	=iconv("gbk","UTF-8",$row['com_name']);//公司名称
					$data['comid']		=$row['uid'];//公司ID
					$data['job_name']	=iconv("gbk","UTF-8",$row['name']);//职位名称
					$data['joburl']		=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$this->url('index','com',array("c"=>'comapply',"id"=>$row['id'])));//职位链接
					$data['comurl']		=iconv("gbk","UTF-8",$this->curl(array("url"=>"id:".$row['uid'])));//公司链接
					$data['address']	=iconv("gbk","UTF-8",$row['address']);//公司地址
					$data['com_content']=iconv("gbk","UTF-8",$row['content']);//公司描述
					$data['hy']			=iconv("gbk","UTF-8",$industry_name[$row['com_hy']]);//公司行业
					$data['money']		=iconv("gbk","UTF-8",$comclass_name[$row['money']]);//注册资本
					$data['zip']		=iconv("gbk","UTF-8",$row['zip']);//邮编
					$data['com_sdate']	=iconv("gbk","UTF-8",$row['com_sdate']);//公司注册时间
					$data['website']	=iconv("gbk","UTF-8",$row['website']);//公司网址
					$data['job_hy']		=iconv("gbk","UTF-8",$industry_name[$row['hy']]);//公司网址
					$data['pr']			=iconv("gbk","UTF-8",$comclass_name[$row['pr']]);//公司网址
					$data['mun']		=iconv("gbk","UTF-8",$comclass_name[$row['mun']]);//公司网址
					$data['description']=iconv("gbk","UTF-8",$row['description']);//公司网址
					$data['city']		=iconv("gbk","UTF-8",$city_name[$row['provinceid']]."/".$city_name[$row['cityid']]."/".$city_name[$row['three_cityid']]);//公司网址
					$data['job_cate']	=iconv("gbk","UTF-8",$job_name[$row['job1']]."/".$job_name[$row['job1_son']]."/".$job_name[$row['job_post']]);//公司网址
					$data['sdate']		=iconv("gbk","UTF-8",$row['sdate']);//公司网址
					$data['edate']		=iconv("gbk","UTF-8",$row['edate']);//公司网址
					$data['lastupdate']	=iconv("gbk","UTF-8",$row['lastupdate']);//公司网址
					$data['salary']		=iconv("gbk","UTF-8",$comclass_name[$row['salary']]);//公司网址
					$data['exp']		=iconv("gbk","UTF-8",$comclass_name[$row['exp']]);//公司网址
					$data['report']		=iconv("gbk","UTF-8",$comclass_name[$row['report']]);//公司网址
					$data['age']		=iconv("gbk","UTF-8",$comclass_name[$row['age']]);//公司网址
					$data['type']		=iconv("gbk","UTF-8",$comclass_name[$row['type']]);//公司网址
					$data['sex']		=iconv("gbk","UTF-8",$comclass_name[$row['sex']]);//公司网址
					$data['edu']		=iconv("gbk","UTF-8",$comclass_name[$row['edu']]);//公司网址
					$data['marriage']	=iconv("gbk","UTF-8",$comclass_name[$row['marriage']]);//公司网址
					$data['number']		=iconv("gbk","UTF-8",$comclass_name[$row['number']]);//公司网址
					$data['com_logo']	=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$row['com_logo']);//公司网址
					$Arr[] = $data;
				}
			}
			echo  $this->curlpost('http://www.yp.com/api/data/index.php?m=job',$Arr);
	}

	function curlpost($url,$Arr)
	{
		//转化JSON		$url = "http://www.yp.com/api/data/index.php?m=".$m."&key=".$this->config['yun_secret']."&uid=".$this->config['yun_id'];
		
		if(!empty($Arr)){
				
				$syncjson['json'] = gzcompress(json_encode($Arr));
				//定义通信密钥
				$syncjson['yun_key']  = $this->config['yun_secret'];
				$syncjson['yun_id'] = $this->config['yun_id'];
				
				//CURL POST 数据
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
				curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
				curl_setopt($ch, CURLOPT_POSTFIELDS, $syncjson);//POST数据
				$response = curl_exec($ch);//接收返回信息
				if(curl_errno($ch)){//出错则显示错误信息
					
				}
				curl_close($ch); //关闭curl链接
				
				print_r($response);
				echo "ff";
				die;
				$nowcount = count($Arr);
				$response = json_decode($response);
				
				if($response->error == '1')//同步成功
				{
					if($response->ids)
					{
						//$this->obj->DB_update_all("company_job","`sync`='1'","`id` IN (".$response->ids.")");
						//$nowcount = count(explode(',',$response->ids));
					}
					$count = $_POST['count']-$nowcount;
					if($count<=0)
					{
						return json_encode(array('state'=>'0','msg'=>$response->msg));
					}else{
						return json_encode(array('state'=>'1','count'=>$count));
					}
				}else{//同步失败

					return json_encode(array('state'=>'2','msg'=>$response->msg));
				}
			}else{
				return  json_encode(array('state'=>'2','msg'=>iconv('gbk','utf-8','未找到相关数据!')));
			}
	}
	function cutsel($table,$where,$fid){
	
		$array		=$this->obj->DB_select_all($table,$where);
		if(is_array($array))
		{
			foreach($array as $key=>$value)
			{
				$return[$value[$fid]][] = $value;
			}
		}
		return $return;
	}
	//同步简历
	function get_resume_action(){
		
		$swhere = $this->searchwhere($_GET);
		$where = $swhere['where'];

		$limit = $swhere['limit'];
		$jobs=$this->obj->DB_select_alls("resume","resume_expect",$where." order by lastupdate desc $limit","	a.name,a.birthday,a.height,a.weight,a.nationality,a.description,a.living,a.domicile,a.sex,a.photo,a.edu,a.address,b.report,a.exp,b.type,b.salary,b.job_classid,b.provinceid,b.cityid,b.three_cityid,a.`uid`,a.`edu`,b.`lastupdate`,b.`id` as eid,a.uid");
		
	
		if(is_array($jobs))
		{
			foreach($jobs as $key=>$value)
			{
				$ids[] =  $value['eid'];
			}
			$def_job = @implode(',',$ids);

			$works		=$this->cutsel("resume_work","`eid` IN (".$def_job.")","eid");
			$edus		=$this->cutsel("resume_edu","`eid` IN (".$def_job.")","eid");
			$projects	=$this->cutsel("resume_project","`eid` IN (".$def_job.")","eid");
			$skills		=$this->cutsel("resume_skill","`eid` IN (".$def_job.")","eid");
			$trainings	=$this->cutsel("resume_training","`eid` IN (".$def_job.")","eid");
			$others		=$this->cutsel("resume_other","`eid` IN (".$def_job.")","eid");
			$certs		=$this->cutsel("resume_cert","`eid` IN (".$def_job.")","eid");
			
			include PLUS_PATH."/job.cache.php";
			include PLUS_PATH."/city.cache.php";
			include PLUS_PATH."/user.cache.php";
			include PLUS_PATH."/industry.cache.php";

			foreach($jobs as $key=>$value)
			{
				$ids[]		=  $value['eid'];
					
				$defid		=	$value['def_job'];
				$row		=	$value;
				$work		=	$works[$defid];
				$edu		=	$edus[$defid];
				$project	=	$projects[$defid];
				$skill		=	$skills[$defid];
				$training	=	$trainings[$defid];
				$other		=	$others[$defid];
				$cert		=	$certs[$defid];
			
				$data['info_name']			=iconv("gbk","UTF-8",$row['name']);//公司名称
				$data['info_birthday']		=iconv("gbk","UTF-8",$row['birthday']);//生日
				$data['info_height']		=iconv("gbk","UTF-8",$row['height']);//身高
				$data['info_weight']		=iconv("gbk","UTF-8",$row['weight']);//体重
				$data['info_nationality']	=iconv("gbk","UTF-8",$row['nationality']);//体重
				$data['info_homepage']		=iconv("gbk","UTF-8",$row['homepage']);//个人主页
				$data['info_description']	=iconv("gbk","UTF-8",$row['description']);//个人说明
				$data['living']				=iconv("gbk","UTF-8",$row['living']);//现居住地
				$data['domicile']			=iconv("gbk","UTF-8",$row['domicile']);//户籍所在地
				$data['eid']				=$value['eid'];//简历ID
				$data['info_sex']			=iconv("gbk","UTF-8",$userclass_name[$row['sex']]);//公司网址
				$data['info_photo']			=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$row['photo']);//像片
				$data['info_edu']			=iconv("gbk","UTF-8",$userclass_name[$row['edu']]);//公司网址
				$data['info_address']		=iconv("gbk","UTF-8",$row['address']);//地址
				$data['info_report']		=iconv("gbk","UTF-8",$userclass_name[$row['report']]);//到岗时间
				$data['info_exp']			=iconv("gbk","UTF-8",$userclass_name[$row['exp']]);//工作经验
				$data['info_type']			=iconv("gbk","UTF-8",$userclass_name[$row['type']]);//工作经验
				$data['info_salary']		=iconv("gbk","UTF-8",$userclass_name[$row['salary']]);//工作经验
				$data['source_url']			=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$this->url('index','resume',array("id"=>$def_job)));//职位链接
				$jobarr=explode(',',$row['job_classid']);
				if(is_array($jobarr)){
					foreach($jobarr as $v){
						$jobname[]=$job_name[$v];
					}
				}
				$data['info_classid']=iconv("gbk","UTF-8",implode("/",$jobname));//意向职位
				$data['info_city']=iconv("gbk","UTF-8",$city_name[$row['provinceid']]."/".$city_name[$row['cityid']]."/".$city_name[$row['three_cityid']]);//公司网址

				//专业技能
				$skill_rows=array();
				foreach($skill as $key=>$va){
					$skill_rows[$key]['name']		=iconv("gbk","UTF-8",$va['name']);
					$skill_rows[$key]['skill']		=iconv("gbk","UTF-8",$va['skill']);
					$skill_rows[$key]['ing']		=iconv("gbk","UTF-8",$va['ing']);
					$skill_rows[$key]['longtime']	=iconv("gbk","UTF-8",$va['longtime']);
				}
				$data['skill']=$skill_rows;
				//工作经历
				$work_rows=array();
				if(is_array($work))
				{
					foreach($work as $key=>$va){
						$work_rows[$key]['title']		=iconv("gbk","UTF-8",$va['title']);
						$work_rows[$key]['name']		=iconv("gbk","UTF-8",$va['name']);
						$work_rows[$key]['sdate']		=iconv("gbk","UTF-8",date("Y-m-d",$va['sdate']));
						$work_rows[$key]['content']		=iconv("gbk","UTF-8",$va['content']);
						$work_rows[$key]['edate']		=iconv("gbk","UTF-8",date("Y-m-d",$va['edate']));
						$work_rows[$key]['department']	=iconv("gbk","UTF-8",$va['department']);
					}
					$data['work']=$work_rows;
				}
				
				
				if(is_array($project))
				{
					//项目经历
					$pro_rows=array();
					foreach($project as $key=>$va){
						$pro_rows[$key]['title']	=iconv("gbk","UTF-8",$va['title']);
						$pro_rows[$key]['name']		=iconv("gbk","UTF-8",$va['name']);
						$pro_rows[$key]['sdate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['sdate']));
						$pro_rows[$key]['content']	=iconv("gbk","UTF-8",$va['content']);
						$pro_rows[$key]['edate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['edate']));
						$pro_rows[$key]['sys']		=iconv("gbk","UTF-8",$va['sys']);
					}
					$data['pro']=$pro_rows;
				}
				

				//教育经历
				$edu_rows=array();
				if(is_array($edu))
				{
					foreach($edu as $key=>$va){
						$edu_rows[$key]['title']	=iconv("gbk","UTF-8",$va['title']);
						$edu_rows[$key]['name']		=iconv("gbk","UTF-8",$va['name']);
						$edu_rows[$key]['sdate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['sdate']));
						$edu_rows[$key]['content']	=iconv("gbk","UTF-8",$va['content']);
						$edu_rows[$key]['edate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['edate']));
						$edu_rows[$key]['specialty']=iconv("gbk","UTF-8",$va['specialty']);
					}
					$data['edu']=$edu_rows;
				}
				

				//教育经历
				$cert_rows=array();
				if(is_array($cert))
				{
					foreach($cert as $key=>$va){
						$cert_rows[$key]['title']	=iconv("gbk","UTF-8",$va['title']);
						$cert_rows[$key]['name']	=iconv("gbk","UTF-8",$va['title']);
						$cert_rows[$key]['sdate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['sdate']));
						$cert_rows[$key]['content']	=iconv("gbk","UTF-8",$va['content']);
						$cert_rows[$key]['edate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['edate']));
					}
					$data['cert']=$cert_rows;
				}
				

				//其它
				$other_rows=array();
				if(is_array($other))
				{
					foreach($other as $key=>$va){
						$other_rows[$key]['title']	=iconv("gbk","UTF-8",$va['title']);
						$other_rows[$key]['content']=iconv("gbk","UTF-8",$va['content']);
					}
					$data['other']=$other_rows;
				}
				
				//培训经历
				if(is_array($other))
				{
					$train_rows=array();
					foreach($training as $key=>$va){
						$train_rows[$key]['title']	=iconv("gbk","UTF-8",$va['title']);
						$train_rows[$key]['name']	=iconv("gbk","UTF-8",$va['name']);
						$train_rows[$key]['sdate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['sdate']));
						$train_rows[$key]['content']=iconv("gbk","UTF-8",$va['content']);
						$train_rows[$key]['edate']	=iconv("gbk","UTF-8",date("Y-m-d",$va['edate']));
					}
					$data['train']=$train_rows;
				}
				$Arr[] = $data;
			}
		}
		return   $this->curlpost('http://www.yp.com/api/data/index.php?m=user',$Arr);
	}

	function searchwhere($get){
	
		extract($get);
		if($get['type']=="job"){
			
			$where.="state='1' and `r_status`<>'2'";
			
			if($searchtype=="time"){
				
				$today=date("Y-m-d");
				switch($ctime){
					case "1"://今天
					$tomorrow=date('Y-m-d',strtotime('+1 day'));
					$where.=" and `lastupdate` between ".strtotime($today)." and ".strtotime($tomorrow);
					break;
					case "2"://昨天
					$yestoday=date('Y-m-d',strtotime('-1 day'));
					$where.=" and `lastupdate` between ".strtotime($yestoday)." and ".strtotime($today);
					break;
					case "3"://三天之内
					$threedaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and `lastupdate` between ".strtotime($threedaysago)." and ".strtotime($today);
					break;
					case "4"://一周之内
					$sevendaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and `lastupdate` between ".strtotime($sevendaysago)." and ".strtotime($today);
					break;
					case "5"://一月之内
					$onemonthago=date('Y-m-d',strtotime('-1 month'));
					$where.=" and `lastupdate` between ".strtotime($onemonthago)." and ".strtotime($today);
					break;
				}
			}else if($searchtype=="search"){
				if(!empty($industry)){
					$where.=" and `hy`='".$industry."'";
				}
				if(!empty($searchname)){
					$where.=" and `name` like '%".$searchname."%'";
				}
			}
			if(!$limit)
			{
				$limit =' limit 10';

			}else{
			
				$limit =' limit '.$limit;
			}
		}elseif($get['type']=="resume"){
			

			$where="a.def_job=b.id";
			if($searchtype=="time"){
				$today=date("Y-m-d");
				switch($ctime){
					case "1"://今天
					$tomorrow=date('Y-m-d',strtotime('+1 day'));
					$where.=" and b.`lastupdate` between ".strtotime($today)." and ".strtotime($tomorrow);
					break;
					case "2"://昨天
					$yestoday=date('Y-m-d',strtotime('-1 day'));
					$where.=" and b.`lastupdate` between ".strtotime($yestoday)." and ".strtotime($today);
					break;
					case "3"://三天之内
					$threedaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and b.`lastupdate` between ".strtotime($threedaysago)." and ".strtotime($today);
					break;
					case "4"://一周之内
					$sevendaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and b.`lastupdate` between ".strtotime($sevendaysago)." and ".strtotime($today);
					break;
					case "5"://一月之内
					$onemonthago=date('Y-m-d',strtotime('-1 month'));
					$where.=" and b.`lastupdate` between ".strtotime($onemonthago)." and ".strtotime($today);
					break;
				}
			}else if($searchtype=="search"){
				if(!empty($industry)){
					$where.=" and b.`hy`='".$industry."'";
				}
				if(!empty($searchname)){
					$where.=" and a.`name` like '%".$searchname."%'";
				}
			}
			if(!$limit)
			{
				$limit =' limit 10';

			}else{
			
				$limit =' limit '.$limit;
			}

			return array('where'=>$where,'limit'=>$limit);
		}
		
	}
	
	//查找数据
	function search_action(){
		
		$getinfo = $_GET;
		unset($getinfo['m']);unset($getinfo['showtype']);unset($getinfo['c']);unset($getinfo['pytoken']);unset($getinfo['config']);
		foreach($getinfo as $key=>$value)
		{
			$urlarr[$key]=$value;
			$url.='&'.$key.'='.$value;
		}

		$swhere = $this->searchwhere($_GET);

		if($_GET['type']=="job"){
			$this->yunset("url",'index.php?m=clouds&c=get_job'.$url);
			$this->yunset("showurl",'index.php?m=clouds&c=search'.$url);
			$where = $swhere['where'];
			$limit = $swhere['limit'];
			$count = $this->obj->DB_select_num("company_job",$where);
			if($_GET['showtype']=='1')
			{
				$urlarr['page']="{{page}}";
				$urlarr['c']="search";
				$urlarr['showtype']=$_GET['showtype'];
				$pageurl=$this->url("index",$_GET['m'],$urlarr);
				$rows=$this->get_page("company_job",$where." order by id desc",$pageurl,'10',"`id`,`uid`,`name`,`com_name`,`sdate`,`edate`,`lastupdate`");
				$this->yunset("rows",$rows);
			}
			//拼接URL 
			$this->yunset("count",$count);
			
			$this->yuntpl(array('admin/admin_clouds_joblist'));

		}elseif($_GET['type']=="resume"){

			include PLUS_PATH."/job.cache.php";
			include PLUS_PATH."/city.cache.php";
			include PLUS_PATH."/user.cache.php";
			include PLUS_PATH."/industry.cache.php";

			$this->yunset("url",'index.php?m=clouds&c=get_resume'.$url);
			$this->yunset("showurl",'index.php?m=clouds&c=search'.$url);

			$where = $swhere['where'];
			$limit = 10;
			$urlarr['page']="{{page}}";
			$urlarr['c']="search";
			$urlarr['showtype']=$_GET['showtype'];
			$pageurl=$this->url("index",$_GET['m'],$urlarr);

			include_once(LIB_PATH."page.class.php");
			$rows=array();
			$page=$_GET['page']<1?1:$_GET['page'];
			$ststrsql=($page-1)*$limit;
			$num=$this->obj->DB_select_num("resume",$where,"*","resume_expect");
			if($num>$limit){
				$pages=ceil($num/$limit);
				$this->yunset("pages",$pages);
				$this->yunset("total",$num);
				$page = new page($page,$limit,$num,$pageurl);
				$pagenav=$page->numPage();
				$this->yunset('pagenav',$pagenav);
			}
			$rows=$this->obj->DB_select_alls("resume","resume_expect",$where." order by lastupdate desc limit $limit","a.`uid`,a.`name`,b.`salary`,a.`exp`,a.`edu`,b.`lastupdate`,b.`id`");
			foreach($rows as $key=>$value)
			{
				$rows[$key]['salary'] = $userclass_name[$value['salary']];
				$rows[$key]['exp'] = $userclass_name[$value['exp']];
				$rows[$key]['edu'] = $userclass_name[$value['edu']];
			}
			$this->yunset($rowsname,$rows);

			$this->yunset("count",$num);
			$this->yunset("type",$_POST['type']);
			$this->yunset("rows",$rows);
			$this->yuntpl(array('admin/admin_clouds_reslist'));
		}
	}
}

?>