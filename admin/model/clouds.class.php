<?php
class clouds_controller extends common
{
	function index_action(){
		$this->yuntpl(array('admin/admin_clouds'));
	}
	//����
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
			$this->ACT_layer_msg("��վ�������óɹ���",9,1,2,1);
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
	//ͬ������
	function tb_action(){
		if($_POST['action']=="job"){
			$data=$this->get_job($_POST['id']);
		}else{
			$data=$this->get_resume($_POST['id']);
		}
		$arr=json_decode($data,true);
		$arr['error']=str_replace('��','',$arr['error']);
		echo json_encode($arr);die;
	}

	//ͬ��ְλ
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
					
					$data['com_name']	=iconv("gbk","UTF-8",$row['com_name']);//��˾����
					$data['comid']		=$row['uid'];//��˾ID
					$data['job_name']	=iconv("gbk","UTF-8",$row['name']);//ְλ����
					$data['joburl']		=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$this->url('index','com',array("c"=>'comapply',"id"=>$row['id'])));//ְλ����
					$data['comurl']		=iconv("gbk","UTF-8",$this->curl(array("url"=>"id:".$row['uid'])));//��˾����
					$data['address']	=iconv("gbk","UTF-8",$row['address']);//��˾��ַ
					$data['com_content']=iconv("gbk","UTF-8",$row['content']);//��˾����
					$data['hy']			=iconv("gbk","UTF-8",$industry_name[$row['com_hy']]);//��˾��ҵ
					$data['money']		=iconv("gbk","UTF-8",$comclass_name[$row['money']]);//ע���ʱ�
					$data['zip']		=iconv("gbk","UTF-8",$row['zip']);//�ʱ�
					$data['com_sdate']	=iconv("gbk","UTF-8",$row['com_sdate']);//��˾ע��ʱ��
					$data['website']	=iconv("gbk","UTF-8",$row['website']);//��˾��ַ
					$data['job_hy']		=iconv("gbk","UTF-8",$industry_name[$row['hy']]);//��˾��ַ
					$data['pr']			=iconv("gbk","UTF-8",$comclass_name[$row['pr']]);//��˾��ַ
					$data['mun']		=iconv("gbk","UTF-8",$comclass_name[$row['mun']]);//��˾��ַ
					$data['description']=iconv("gbk","UTF-8",$row['description']);//��˾��ַ
					$data['city']		=iconv("gbk","UTF-8",$city_name[$row['provinceid']]."/".$city_name[$row['cityid']]."/".$city_name[$row['three_cityid']]);//��˾��ַ
					$data['job_cate']	=iconv("gbk","UTF-8",$job_name[$row['job1']]."/".$job_name[$row['job1_son']]."/".$job_name[$row['job_post']]);//��˾��ַ
					$data['sdate']		=iconv("gbk","UTF-8",$row['sdate']);//��˾��ַ
					$data['edate']		=iconv("gbk","UTF-8",$row['edate']);//��˾��ַ
					$data['lastupdate']	=iconv("gbk","UTF-8",$row['lastupdate']);//��˾��ַ
					$data['salary']		=iconv("gbk","UTF-8",$comclass_name[$row['salary']]);//��˾��ַ
					$data['exp']		=iconv("gbk","UTF-8",$comclass_name[$row['exp']]);//��˾��ַ
					$data['report']		=iconv("gbk","UTF-8",$comclass_name[$row['report']]);//��˾��ַ
					$data['age']		=iconv("gbk","UTF-8",$comclass_name[$row['age']]);//��˾��ַ
					$data['type']		=iconv("gbk","UTF-8",$comclass_name[$row['type']]);//��˾��ַ
					$data['sex']		=iconv("gbk","UTF-8",$comclass_name[$row['sex']]);//��˾��ַ
					$data['edu']		=iconv("gbk","UTF-8",$comclass_name[$row['edu']]);//��˾��ַ
					$data['marriage']	=iconv("gbk","UTF-8",$comclass_name[$row['marriage']]);//��˾��ַ
					$data['number']		=iconv("gbk","UTF-8",$comclass_name[$row['number']]);//��˾��ַ
					$data['com_logo']	=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$row['com_logo']);//��˾��ַ
					$Arr[] = $data;
				}
			}
			echo  $this->curlpost('http://www.yp.com/api/data/index.php?m=job',$Arr);
	}

	function curlpost($url,$Arr)
	{
		//ת��JSON		$url = "http://www.yp.com/api/data/index.php?m=".$m."&key=".$this->config['yun_secret']."&uid=".$this->config['yun_id'];
		
		if(!empty($Arr)){
				
				$syncjson['json'] = gzcompress(json_encode($Arr));
				//����ͨ����Կ
				$syncjson['yun_key']  = $this->config['yun_secret'];
				$syncjson['yun_id'] = $this->config['yun_id'];
				
				//CURL POST ����
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//�����Ƿ񷵻���Ϣ
				curl_setopt($ch, CURLOPT_POST, 1);//����ΪPOST��ʽ
				curl_setopt($ch, CURLOPT_POSTFIELDS, $syncjson);//POST����
				$response = curl_exec($ch);//���շ�����Ϣ
				if(curl_errno($ch)){//��������ʾ������Ϣ
					
				}
				curl_close($ch); //�ر�curl����
				
				print_r($response);
				echo "ff";
				die;
				$nowcount = count($Arr);
				$response = json_decode($response);
				
				if($response->error == '1')//ͬ���ɹ�
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
				}else{//ͬ��ʧ��

					return json_encode(array('state'=>'2','msg'=>$response->msg));
				}
			}else{
				return  json_encode(array('state'=>'2','msg'=>iconv('gbk','utf-8','δ�ҵ��������!')));
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
	//ͬ������
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
			
				$data['info_name']			=iconv("gbk","UTF-8",$row['name']);//��˾����
				$data['info_birthday']		=iconv("gbk","UTF-8",$row['birthday']);//����
				$data['info_height']		=iconv("gbk","UTF-8",$row['height']);//���
				$data['info_weight']		=iconv("gbk","UTF-8",$row['weight']);//����
				$data['info_nationality']	=iconv("gbk","UTF-8",$row['nationality']);//����
				$data['info_homepage']		=iconv("gbk","UTF-8",$row['homepage']);//������ҳ
				$data['info_description']	=iconv("gbk","UTF-8",$row['description']);//����˵��
				$data['living']				=iconv("gbk","UTF-8",$row['living']);//�־�ס��
				$data['domicile']			=iconv("gbk","UTF-8",$row['domicile']);//�������ڵ�
				$data['eid']				=$value['eid'];//����ID
				$data['info_sex']			=iconv("gbk","UTF-8",$userclass_name[$row['sex']]);//��˾��ַ
				$data['info_photo']			=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$row['photo']);//��Ƭ
				$data['info_edu']			=iconv("gbk","UTF-8",$userclass_name[$row['edu']]);//��˾��ַ
				$data['info_address']		=iconv("gbk","UTF-8",$row['address']);//��ַ
				$data['info_report']		=iconv("gbk","UTF-8",$userclass_name[$row['report']]);//����ʱ��
				$data['info_exp']			=iconv("gbk","UTF-8",$userclass_name[$row['exp']]);//��������
				$data['info_type']			=iconv("gbk","UTF-8",$userclass_name[$row['type']]);//��������
				$data['info_salary']		=iconv("gbk","UTF-8",$userclass_name[$row['salary']]);//��������
				$data['source_url']			=iconv("gbk","UTF-8",$this->config['sy_weburl']."/".$this->url('index','resume',array("id"=>$def_job)));//ְλ����
				$jobarr=explode(',',$row['job_classid']);
				if(is_array($jobarr)){
					foreach($jobarr as $v){
						$jobname[]=$job_name[$v];
					}
				}
				$data['info_classid']=iconv("gbk","UTF-8",implode("/",$jobname));//����ְλ
				$data['info_city']=iconv("gbk","UTF-8",$city_name[$row['provinceid']]."/".$city_name[$row['cityid']]."/".$city_name[$row['three_cityid']]);//��˾��ַ

				//רҵ����
				$skill_rows=array();
				foreach($skill as $key=>$va){
					$skill_rows[$key]['name']		=iconv("gbk","UTF-8",$va['name']);
					$skill_rows[$key]['skill']		=iconv("gbk","UTF-8",$va['skill']);
					$skill_rows[$key]['ing']		=iconv("gbk","UTF-8",$va['ing']);
					$skill_rows[$key]['longtime']	=iconv("gbk","UTF-8",$va['longtime']);
				}
				$data['skill']=$skill_rows;
				//��������
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
					//��Ŀ����
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
				

				//��������
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
				

				//��������
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
				

				//����
				$other_rows=array();
				if(is_array($other))
				{
					foreach($other as $key=>$va){
						$other_rows[$key]['title']	=iconv("gbk","UTF-8",$va['title']);
						$other_rows[$key]['content']=iconv("gbk","UTF-8",$va['content']);
					}
					$data['other']=$other_rows;
				}
				
				//��ѵ����
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
					case "1"://����
					$tomorrow=date('Y-m-d',strtotime('+1 day'));
					$where.=" and `lastupdate` between ".strtotime($today)." and ".strtotime($tomorrow);
					break;
					case "2"://����
					$yestoday=date('Y-m-d',strtotime('-1 day'));
					$where.=" and `lastupdate` between ".strtotime($yestoday)." and ".strtotime($today);
					break;
					case "3"://����֮��
					$threedaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and `lastupdate` between ".strtotime($threedaysago)." and ".strtotime($today);
					break;
					case "4"://һ��֮��
					$sevendaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and `lastupdate` between ".strtotime($sevendaysago)." and ".strtotime($today);
					break;
					case "5"://һ��֮��
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
					case "1"://����
					$tomorrow=date('Y-m-d',strtotime('+1 day'));
					$where.=" and b.`lastupdate` between ".strtotime($today)." and ".strtotime($tomorrow);
					break;
					case "2"://����
					$yestoday=date('Y-m-d',strtotime('-1 day'));
					$where.=" and b.`lastupdate` between ".strtotime($yestoday)." and ".strtotime($today);
					break;
					case "3"://����֮��
					$threedaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and b.`lastupdate` between ".strtotime($threedaysago)." and ".strtotime($today);
					break;
					case "4"://һ��֮��
					$sevendaysago=date('Y-m-d',strtotime('-3 day'));
					$where.=" and b.`lastupdate` between ".strtotime($sevendaysago)." and ".strtotime($today);
					break;
					case "5"://һ��֮��
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
	
	//��������
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
			//ƴ��URL 
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