<?php
class excel_controller extends common
{
	function index_action()
	{
		$this->yuntpl(array('admin/admin_excel'));
	}
	function resume_action()
	{
		set_time_limit(0);
		include LIB_PATH."/reader.php";
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('gbk');

		if($_FILES[excel][name]!="")
		{
			$time = time();
			$excel = $time.".xls";
			move_uploaded_file($_FILES[excel][tmp_name],APP_PATH."upload/excel/".$excel);
		}else{
			$this->ACT_layer_msg("无文件上传！",8,$_SERVER['HTTP_REFERER'],2,1);
		}

		$data->read(APP_PATH.'upload/excel/'.$excel);
		if($data->sheets[0]['numRows']<1)
		{
			$this->ACT_layer_msg("数据读取失败，请检查excel格式！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
		$user = array();

		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
			$user[$i]['username'] 	= trim($data->sheets[0]['cells'][$i][1]);
			$user[$i]['name'] 		= trim($data->sheets[0]['cells'][$i][2]);
			$user[$i]['sex_n'] 		= $data->sheets[0]['cells'][$i][3];
			$user[$i]['age_n'] 		= $data->sheets[0]['cells'][$i][4];
			$user[$i]['marriage_n'] = $data->sheets[0]['cells'][$i][5];
			$user[$i]['jiguan_n'] 	= $data->sheets[0]['cells'][$i][6];
			$user[$i]['telphone']   = $data->sheets[0]['cells'][$i][7];
			$user[$i]['homephone']  = $data->sheets[0]['cells'][$i][8];
			$user[$i]['email'] 	    = $data->sheets[0]['cells'][$i][9];
			$user[$i]['edu_n'] 		= $data->sheets[0]['cells'][$i][10];
			$user[$i]['exp_n'] 		= $data->sheets[0]['cells'][$i][11];
			$user[$i]['xcity'] 		= $data->sheets[0]['cells'][$i][12];
			$user[$i]['address'] 	= $data->sheets[0]['cells'][$i][13];
			$user[$i]['jobaddress'] = $data->sheets[0]['cells'][$i][14];
			$user[$i]['job'] 		= $data->sheets[0]['cells'][$i][15];
			$user[$i]['salary_n'] 	= $data->sheets[0]['cells'][$i][16];

			$user[$i]['eduexcel'] 	= $data->sheets[0]['cells'][$i][17];
			$user[$i]['work_n'] 	= $data->sheets[0]['cells'][$i][18];
			$user[$i]['other_n'] 	= $data->sheets[0]['cells'][$i][19];
			$user[$i]['description']= $data->sheets[0]['cells'][$i][20];
		}
		if(is_array($user))
		{
			$numres = 0; $numuser=0;$numwork=0;$numedu=0;$los=0;
			include PLUS_PATH."/job.cache.php";
			include PLUS_PATH."/user.cache.php";
			include PLUS_PATH."/city.cache.php";
			foreach($user as $key=>$value)
			{
			if($value[name]!=""){
				$salt = substr(uniqid(rand()), -6);
				$pass =array("a","b","c","d","e","f","g","h","i","g","k","l","m","n","o","p","q","r","s","t","u","v","w","x","w","z","1","2","3","4","5","6","7","8","9","0");

				$password='';
				for($i=0;$i<6;$i++)
				{
					$k = rand(0,36);
					$password.=$pass[$k];
				}
				$npass = md5(md5($password).$salt);
				$time = time();
				if($value['username']=='')
				{
					$value['username'] = 'nz'.date('mdHis').rand(100,999);
				}
				if($value['email']!='')
				{
					$emailuser[] = array('email'=>$value['email'],'username'=>$value[username],'password'=>$password,'name'=>$value['name']);
				}
				$mvalue = "`username`='$value[username]',`password`='$npass',`email`='$value[email]',`usertype`='1',`address`='$value[address]',`status`='1',`salt`='$salt',`moblie`='$value[telphone]',`reg_date`='$time',`passtext`='$password'";
				$uid = $this->obj->DB_insert_once("member",$mvalue);
				$this->obj->DB_insert_once("member_statis","`uid`='$uid'");
				$this->obj->DB_insert_once("resume","`uid`='$uid'");
				$this->obj->DB_insert_once("friend_info","`uid`='$uid'");
				if($uid)
				{
					$numuser++;
					$sqlval="`uid`='$uid'";
					$sqlval .=",`name`='$value[name]'";

					$job_row=$this->get_job_class($value['job']);
					
					
					if($job_row){
						$job_arr=array();
						foreach($job_row as $vs){
							$job_arr[] = $vs;
						}
						$sqlval.=",`job_classid`='".implode(',',$job_arr)."'";
					}


							
					$pcity = $value['jiguan_n'];
					$xcity = $value['xcity'];
					$provinceid = $cityid = $three_cityid=0;
					$city_row=$this->get_city($value['jobaddress']);
					
					$i=1;
					foreach($city_row as $v){
						if($i==1)$provinceid=$v;
						if($i==2)$cityid=$v;
						if($i==3)$three_cityid=$v;
						$i++;
					}
					$sqlval.=",`provinceid`='$provinceid'";
					$sqlval.=",`cityid`='$cityid'";
					$sqlval.=",`three_cityid`='$three_cityid',`lastupdate`='".mktime()."'";
					if(intval($value['salary_n'])>0)
					{
						$salary = intval($value['salary_n']);
						if($salary<=1500)
						{
							$sqlval.=",`salary`='31'";
						}elseif($salary<=2000)
						{
							$sqlval.=",`salary`='32'";
						}elseif($salary<=3000)
						{
							$sqlval.=",`salary`='33'";
						}elseif($salary<5000)
						{
							$sqlval.=",`salary`='34'";
						}elseif($salary<10000)
						{
							$sqlval.=",`salary`='35'";
						}else{
							$sqlval.=",`salary`='36'";
						}
					}else{
						$sqlval.=",`salary`='30'";
					}
					$sqlval.=",`type`='58',`report`='46'";
					$resumeid = $this->obj->DB_insert_once("resume_expect",$sqlval);
					$numres++;
					if($uid)
					{
						$ressql ="`def_job`='$resumeid'";
						$ressql.=",`name`='$value[name]'";
						if($value['sex_n']=="女")
						{
							$ressql.=",`sex`='7'";
						}else{
							$ressql.=",`sex`='6'";
						}
						if((int)$value[age_n]>0)
						{
							$birthday = date("Y")-$value[age_n]."-".date("m-d");
							$ressql.=",`birthday`='$birthday'";
						}
						if($value['marriage_n']=="已婚")
						{
							$ressql.=",`marriage`='8'";
						}else{
							$ressql.=",`marriage`='11'";
						}
						$ressql.=",`telphone`='$value[telphone]',`telhome`='$value[homephone]'";
						$ressql.=",`living` = '$xcity'";
						$ressql.=",`domicile` = '$pcity'";
						$ressql.=",`email`='$value[email]'";

						if($value[edu_n]!="")
						{
							foreach($userdata['user_edu'] as $k=>$v)
							{
								if(strpos($userclass_name[$v],$value[edu_n])!==false)
								{
									$edu = $v;
								}
							}
						}
						$ressql.=",`edu`='$edu'";
						if($value[exp_n]!="")
						{
							foreach($userdata['user_word'] as $k=>$v)
							{
								if(strpos($userclass_name[$v],$value[exp_n])!==false)
								{
									$exp = $v;
								}
							}
						}
						$ressql.=",`exp`='$exp'";
						$ressql.=",`address`='$value[address]',`description`='$value[description]'";

						$this->obj->DB_update_all("resume",$ressql,"`uid`='$uid'");
						if($resumeid  && $value[work_n]!="")
						{
							$work_arr = @explode("||",$value[work_n]);

							if(is_array($work_arr))
							{
								foreach($work_arr as $k=>$v)
								{
									$sonv = @explode("***",$v);
									$workson_arra = @explode("-",$sonv[0]);
									$sdate = $this->uparr($workson_arra[0]);
									$edate = $this->uparr($workson_arra[1]);
									$content = $workson_arra[2];
									if($sonv[1]!="" || $sonv[2]!="" || $sonv[3]!="")
									{
									$this->obj->DB_insert_once("resume_work","`uid`='$uid',`eid`='$resumeid',`sdate`='$sdate',`edate`='$edate',`name`='$sonv[1]',`title`='$sonv[3]',`content`='$sonv[2]'");
									$numwork++;
									}
								}
							}
						}
						if($resumeid  && $value[eduexcel]!="")
						{
							$edu_arr = @explode("||",$value[eduexcel]);
							if(is_array($edu_arr))
							{
								foreach($edu_arr as $k=>$v)
								{
									$sonv = @explode("***",$v);
									$eduson_arra = @explode("-",$sonv[0]);
									$sdate = $this->uparr($eduson_arra[0]);
									$edate = $this->uparr($eduson_arra[1]);
									$content = $eduson_arra[2];
									if($sonv[1]!="" || $sonv[2]!="")
									{
										$this->obj->DB_insert_once("resume_edu","`uid`='$uid',`eid`='$resumeid',`sdate`='$sdate',`edate`='$edate',`name`='$sonv[1]',`content`='$sonv[2]'");
										$numedu++;
									}
								}
							}
						}
						if($resumeid  && $value[other_n]!="")
						{
							$this->obj->DB_insert_once("resume_other","`uid`='$uid',`eid`='$resumeid',`content`='$value[other_n]'");
						}
					}
				}

			}else{

			}
			}
			if(is_array($emailuser) && 1!=2)
			{
				include(LIB_PATH."email.class.php");

				$smtpserver = $this->config["sy_smtpserver"];
				$smtpserverport =$this->config["sy_smtpserverport"];
				$smtpusermail =$this->config["sy_smtpemail"];
				$smtpuser = $this->config["sy_smtpuser"];
				$smtppass = $this->config["sy_smtppass"];
				$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);

				$smtpusermail =$this->config["sy_smtpemail"];

				foreach($emailuser as $e=>$m)
				{
					$html = '';
				}
			}
			$msg = "本次新增个人会员：".$numuser."人，新增简历：".$numres."份;新增工作经历:".$numwork."份;新增教育经历:".$numedu."份.";
			$this->ACT_layer_msg($msg,9,$_SERVER['HTTP_REFERER'],2,1);


		}else{
			$this->ACT_layer_msg("没有找到合适的数据，请查看格式是否规范！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
	}

	function comexcel_action()
	{
		include LIB_PATH."/reader.php";
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('gbk');

		if($_FILES[excel][name]!="")
		{
			$time = time();
			$excel = $time.".xls";
			move_uploaded_file($_FILES[excel][tmp_name],APP_PATH."upload/excel/".$excel);
		}

		$data->read(APP_PATH."upload/excel/".$excel);
		$user = array();
		if($data->sheets[0]['numRows']<1)
		{
			$this->ACT_layer_msg("数据读取失败，请检查excel格式！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++)
		{
			$user[$i]['comname'] 	= trim($data->sheets[0]['cells'][$i][1]);
			$user[$i]['linkman'] 	= $data->sheets[0]['cells'][$i][2];
			$user[$i]['linkjob'] 	= $data->sheets[0]['cells'][$i][3];
			$user[$i]['linktel'] 	= $data->sheets[0]['cells'][$i][4];
			$user[$i]['linkphone'] 	= $data->sheets[0]['cells'][$i][5];
			$user[$i]['linkqq'] 	= $data->sheets[0]['cells'][$i][6];
			$user[$i]['address'] 	= $data->sheets[0]['cells'][$i][7];
			$user[$i]['email'] 		= $data->sheets[0]['cells'][$i][8];
			$user[$i]['hy'] 		= $data->sheets[0]['cells'][$i][9];
			$user[$i]['mun'] 		= $data->sheets[0]['cells'][$i][10];
			$user[$i]['content'] 	= $data->sheets[0]['cells'][$i][11];
			$user[$i]['name'] 	= $data->sheets[0]['cells'][$i][12];
			$user[$i]['jobclass'] 	= $data->sheets[0]['cells'][$i][13];
			$user[$i]['num'] 		= $data->sheets[0]['cells'][$i][14];
			$user[$i]['description']= $data->sheets[0]['cells'][$i][15];

			$user[$i]['salary'] 		= $data->sheets[0]['cells'][$i][16];

			$user[$i]['exp']		= $data->sheets[0]['cells'][$i][17];
			$user[$i]['edu']		= $data->sheets[0]['cells'][$i][18];
			$user[$i]['city']		= $data->sheets[0]['cells'][$i][19];

		}
		if(is_array($user))
		{
			$numjob=0;$numuser=0;$los=0;
			$row = $this->obj->DB_select_once("company_rating","`id`='4'");
			include PLUS_PATH."/job.cache.php";
			include PLUS_PATH."/industry.cache.php";
			include PLUS_PATH."/city.cache.php";
			include PLUS_PATH."/com.cache.php";
			foreach($user as $key=>$value)
			{
				$salt = substr(uniqid(rand()), -6);
				$pass =array("a","b","c","d","e","f","g","h","i","g","k","l","m","n","o","p","q","r","s","t","u","v","w","x","w","z","1","2","3","4","5","6","7","8","9","0");
				$password =  '';
				$len = rand(8,12);
				for($i=0;$i<$len;$i++)
				{
					$k = rand(0,36);
					$password.=$pass[$k];
				}
				$npass = md5(md5($password).$salt);
				$time = time();
				if($value[comname]!="")
				{
					$comname = $value[comname];
					
					$mvalue = "`username`='$value[comname]',`password`='$npass',`email`='$value[email]',`usertype`='2',`address`='$value[address]',`status`='1',`salt`='$salt',`moblie`='$value[telphone]',`reg_date`='$time',`passtext`='$password'";
					$uid = $this->obj->DB_insert_once("member",$mvalue);

					$statisval = "`uid`='$uid',";
					$statisval.=$this->rating_info($row);
					$this->obj->DB_insert_once("company_statis",$statisval);
					$this->obj->DB_insert_once("friend_info","`uid`='$uid'");
					if($uid)
					{
						$numuser++;
						$comval = "`uid`='$uid',`name`='$value[comname]'";
						$comval.=",`linkman`='$value[linkman]'";
						$comval.=",`linkjob`='$value[linkjob]'";
						$comval.=",`linktel`='$value[linktel]'";
						$comval.=",`linkphone`='$value[linkphone]'";
						$comval.=",`linkqq`='$value[linkqq]'";
						$comval.=",`address`='$value[address]'";
						$comval.=",`linkmail`='$value[email]'";
						$comval.=",`content`='$value[content]'";
						if(is_array($industry_name) && $value[hy]!="")
						{
							foreach($industry_name as $k=>$v)
							{
								if(strpos($v,$value['hy'])!==false)
								{
									$hy = $k;
								}
							}
							$comval.=",`hy`='$hy'";
						}

						if($value[mun])
						{
							$mun = str_replace("人","",$value[mun]);
							$mun = @explode("-",$mun);

							if($mun[1]<20)
							{
								$munval = "27";
							}elseif($mun[1]<99){
								$munval = "28";
							}
							elseif($mun[1]<499){
								$munval = "29";
							}elseif($mun[1]<999){
								$munval = "30";
							}elseif($mun[1]<9999){
								$munval = "31";
							}else{
								$munval = "32";
							}

							$comval.=",`mun`='$munval'";
							$mun = $munval;
						}
					}

					$this->obj->DB_insert_once("company",$comval);
				}

				if($uid)
				{
					$stime = time();
					$etime = $stime+3600*24*30;
					if($value['jobclass']!="")
					{
						$job1 = $job1_son = $job_post=0;
						$jobarr = explode('*',$value['jobclass']);
						$jobval = "`uid`='$uid',`hy`='$hy',`description`='$value[description]',`name`='$value[name]',`state`='1',`sdate`='$stime',`edate`='$etime',`lastupdate`='".$stime."'";
						$job_post="";
						if($jobarr[0]!="")
						{
							foreach($job_index as $k=>$v)
							{
								if((strpos($job_name[$v],$jobarr[0])!==false || strpos($jobarr[0],$job_name[$v])!==false))
								{
									$job1 = $v;
									break;
								}
							}
							if($job1>0 && $jobarr[1]!="")
							{
								if(is_array($job_type[$job1]))
								{
									foreach($job_type[$job1] as $k=>$v)
									{
										if((strpos($job_name[$v],$jobarr[1])!==false || strpos($jobarr[1],$job_name[$v])!==false))
										{
											$job1_son = $v;
											break;
										}
									}
									if($job1_son>0 && $jobarr[2]!="")
									{
										if(is_array($job_type[$job1_son]))
										{
											foreach($job_type[$job1_son] as $k=>$v)
											{
												if((strpos($job_name[$v],$jobarr[2])!==false || strpos($jobarr[2],$job_name[$v])!==false))
												{
													$job_post = $v;
													break;
												}
											}
										}
									}
								}
							}
						}
						


						if(is_array($job_name))
						{
							foreach($job_name as $k=>$v)
							{
								if(strpos($v,$value['jobclass']))
								{
									$job_post = $k;
									foreach($job_type as $kk=>$vv)
									{
										if($k == $vv)
										{
											$job1_son = $kk;
											foreach($job_index as $kkk=>$vvv)
											{
												if($kk == $vvv)
												{
													$job1 = $kk;
												}
											}
										}
									}
								}
							}
						}
						if($job_post!="")
						{
							$jobval.=",`job1`='$job1',`job1_son`='$job1_son',`job_post`='$job_post'";
						}
						if($value[num]=="若干")
						{
							$num = "40";
						}elseif((int)$value[num]<2){

							$num = "41";

						}elseif((int)$value[num]<10){

							$num = "42";
						}elseif((int)$value[num]<50){

							$num = "43";
						}elseif((int)$value[num]<100){

							$num = "44";
						}elseif((int)$value[num]<999){

							$num = "45";
						}else{
							$num="";
						}
						if($num!="")
						{
							$jobval.=",`number`='$num'";
						}
						if($value[sex]=="女")
						{
							$jobval.=",`sex`='64'";
						}elseif($value[sex]=="男"){
							$jobval.=",`sex`='63'";
						}else{
							$jobval.=",`sex`='62'";
						}

						if($value['exp'])
						{
							$exps = explode("-",$value['exp']);
							$exp = $exp[1];
							if(!$exp)
							{
								$jobval.=",`exp`='11'";
							}elseif((int)$exp<1){

								$jobval.=",`exp`='11'";
							}elseif((int)$exp<2){

								$jobval.=",`exp`='13'";
							}elseif((int)$exp<3){

								$jobval.=",`exp`='14'";
							}elseif((int)$exp<5){

								$jobval.=",`exp`='15'";
							}elseif((int)$exp<8){

								$jobval.=",`exp`='16'";
							}elseif((int)$exp<10){

								$jobval.=",`exp`='17'";
							}elseif((int)$exp<11){

								$jobval.=",`exp`='18'";
							}
						}
						if($value['edu']!="")
						{
							foreach($comdata['job_edu'] as $k=>$v)
							{
								if(strpos($comclass_name[$v],$value['edu'])!==false)
								{
									$edu = $v;
								}
							}
						}
						$jobval.=",`edu`='$edu'";
						if($value['city'])
						{
							$cityarr = @explode("/",$value['city']);
							foreach($city_name as $k=>$v)
							{
								if((strpos($v,$cityarr[0])!==false || strpos($cityarr[0],$v)!==false) && $cityarr[0]!="")
								{
									$provinceid = $k;
								}
								if((strpos($v,$cityarr[1])!==false || strpos($cityarr[1],$v)!==false) && $cityarr[1]!="")
								{
									$cityid = $k;
								}
								if((strpos($v,$cityarr[2])!==false || strpos($cityarr[2],$v)!==false) && $cityarr[2]!="")
								{
									$three_cityid = $k;
								}
							}
							$jobval.= ",`provinceid`='$provinceid',`cityid`='$cityid',`three_cityid`='$three_cityid'";
						}

						if($value['salary'])
						{
							if(strpos($value['salary'],"-"))
							{
								$salary =@explode("-",$value['salary']);
								$salary = $salary[1];
							}else{

								$salary = $value['salary'];
							}
							if((int)$salary<2000)
							{
								$jobval.=",`salary`='47'";
							}elseif((int)$salary<3000){
								$jobval.=",`salary`='48'";
							}elseif((int)$salary<5000){
								$jobval.=",`salary`='49'";
							}elseif((int)$salary<10000){
								$jobval.=",`salary`='50'";
							}elseif((int)$salary>9999){
								$jobval.=",`salary`='51'";
							}elseif((int)$salary>9999){
								$jobval.=",`salary`='52'";
							}else{
								$jobval.=",`salary`='46'";
							}
						}
						$jobval.=",`com_name`='$comname',`mun` = $mun";
						$numjob++;

						$this->obj->DB_insert_once("company_job",$jobval);
					}
				}
			}
			$msg = "本次新增企业会员：".$numuser."人，新增职位：".$numjob."个";
			$this->ACT_layer_msg($msg,9,$_SERVER['HTTP_REFERER'],2,1);

		}else{
			$this->ACT_layer_msg("未读取到合适的数据，请检查格式是否规范！",8,$_SERVER['HTTP_REFERER'],2,1);
		}
	}
	function excellog_action()
	{
		$urlarr=array("page"=>"{{page}}");
		$pageurl=$this->url("index",$_GET[act],$urlarr);
		$rows=$this->get_page("excel"," 1 order by time desc",$pageurl,"15");
		$this->yuntpl(array('admin/admin_excellist'));
	}
	function rating_info($row)
	{
		$value="`rating`='4',";
		$value.="`rating_name`='".$row["name"]."',";
		$value.="`job_num`='".$row["job_num"]."',";
		$value.="`down_resume`='".$row["resume"]."',";
		$value.="`invite_resume`='".$row["interview"]."',";
		$value.="`editjob_num`='".$row["editjob_num"]."',";
		$value.="`breakjob_num`='".$row["breakjob_num"]."'";
		return $value;
	}
	function del_action(){

		$this->check_token();
	    if($_GET[delsub]){
	    	$del=$_GET[del];
	    	if($del){
	    		if(is_array($del)){
			    	foreach($del as $v){
			    	    $this->obj->DB_delete_all("excel","`id`='$v'");
			    	}
		    	}else{
		    		$this->obj->DB_delete_all("excel","`id`='$del'");
		    	}
	    		$this->obj->get_admin_msg($_SERVER['HTTP_REFERER'],"删除成功！");
	    	}else{
	    		$this->obj->get_admin_msg($_SERVER['HTTP_REFERER'],"请选择您要删除的招聘");
	    	}
	    }
	    if(isset($_GET[id])){
			$result=$this->obj->DB_delete_all("excel","`id`='".$_GET[id]."'" );
			isset($result)?$this->obj->get_admin_msg($_SERVER['HTTP_REFERER'],"删除成功"):$this->obj->get_admin_msg($_SERVER['HTTP_REFERER'],"删除失败");
		}else{
			$this->obj->get_admin_msg($_SERVER['HTTP_REFERER'],"非法操作");
		}
	}
	function uparr($arr)
	{
		$arr = str_replace("年","-",$arr);
		$arr = str_replace("月","-",$arr);
		$arr = str_replace("日","-",$arr);

		$narr = @explode("-",$arr);

		if($narr[2]=="")
		{
			$narr[2] = "01";
		}
		if($narr[1]=="")
		{
			$narr[1] = "01";
		}
		if($narr[0]!="")
		{
			$arr = $narr[0]."-".$narr[1]."-".$narr[2];
		}
		$arr = strtotime($arr);
		return $arr;
	}
	function add_tj_phpyun($type,$id){
		$data="`uid`='".$this->uid."',";
		$data.="`type`='".$type."',";
		$data.="`nid`='".$id."',";
		$data.="`state`='0',";
		$data.="`ctime`='".mktime()."'";
		$nid=$this->db->DB_insert_once("user_import_tj",$data);
	}
	//检查匹配度
	function locoytostr($arr,$str,$locoy_rate="50"){
		foreach($arr as $key=>$value)
		{
			similar_text($str,$value,$percent);
			
			$rows[$percent]=$key;
			$aaa[$percent] = $value;
		}
		krsort($rows);
		foreach($rows as $k =>$v){			 
			if ($k>=$locoy_rate){
				return array('id'=>$v,'percent'=>$k);
			}else{
				return false;
			}
		}
	}

	function tostring($string){ 
		$length=strlen($string); 
		$retstr=''; 
		for($i=0;$i<$length;$i++) { 
			$retstr[]=ord($string[$i])>127?$string[$i].$string[++$i]:$string[$i]; 
		} 
		return $retstr; 
	}

	function get_com_type($cat){
		include(PLUS_PATH."com.cache.php");
		foreach($comdata["job_".$cat] as $v){
			$data[$v]=$comclass_name[$v];
		}
		return $data;
	}

	function get_city($name){
		include(PLUS_PATH."city.cache.php");
		$name=str_replace(array("省","市","县","区"),"/",$name);
		$arr=explode("/",$name);
		if(is_array($arr)){
			foreach($arr as $v){
				$locoystr=$this->locoytostr($city_name,$v);//匹配
				$data[] = $locoystr['id'];
			}
		}
		
		return $data;
	}

	function get_all_city($city_type,$data,$k=""){
		if(is_array($data)){
			foreach($data as $v){
				foreach($city_type as $key=>$value){
					$a=$k?$k:$v;
					if(in_array($a,$value)){
						if($key){
							$val=$this->get_all_city($city_type,$data,$key);
						}
						$val[$key]=$a;
					}
				}
			}
		}
		return $val;
	}
	
	function get_once_city($t,$n,$id){
		$row=$n[$id];
		if(is_array($t[$id])){
			foreach($t[$id] as $k=>$v){
				$array[$v]=$n[$v];
			}
		}
		$locoystr=$this->locoytostr($array,$row);
		$r = array('id'=>$locoystr['id'],'percent'=>$locoystr['percent'],'name'=>$row);
		return $r;
	}
	function get_job_class($name){
		include(PLUS_PATH."job.cache.php");
		
		$arr=explode(",",$name);
		
		if(is_array($arr)){
			foreach($arr as $v){
				$locoystr=$this->locoytostr($job_name,$v);

				$data[] = $locoystr['id'];
			}
		}
		return $data;
	}
	function get_user_type($cat){
		include(PLUS_PATH."user.cache.php");
		foreach($userdata["user_".$cat] as $v){
			$data[$v]=$userclass_name[$v];
		}
		return $data;
	}
}
