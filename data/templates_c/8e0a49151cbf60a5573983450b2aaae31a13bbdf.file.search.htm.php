<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-09-30 13:00:04
         compiled from "E:\WWW\luosiwang\app\template\default\job\search.htm" */ ?>
<?php /*%%SmartyHeaderCode:14645560b6c54ed8bb7-82254677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e0a49151cbf60a5573983450b2aaae31a13bbdf' => 
    array (
      0 => 'E:\\WWW\\luosiwang\\app\\template\\default\\job\\search.htm',
      1 => 1436225110,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14645560b6c54ed8bb7-82254677',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'style' => 0,
    'config' => 0,
    'finder' => 0,
    'key' => 0,
    'v' => 0,
    'total' => 0,
    'industry_name' => 0,
    'job_name' => 0,
    'city_name' => 0,
    'comclass_name' => 0,
    'sdate' => 0,
    'uptime' => 0,
    'paras' => 0,
    'industry_index' => 0,
    'job_index' => 0,
    'job_type' => 0,
    'city_index' => 0,
    'city_type' => 0,
    'comdata' => 0,
    'keylist' => 0,
    'job_list' => 0,
    'lookjob' => 0,
    'favjob' => 0,
    'useridjob' => 0,
    'usertype' => 0,
    'uid' => 0,
    'pagenav' => 0,
    'klist' => 0,
    'blist' => 0,
    'com' => 0,
    'zpthreecityid' => 0,
    'zpcityid' => 0,
    'zpjobpost' => 0,
    'zpjob1son' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_560b6c55449a30_91889008',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_560b6c55449a30_91889008')) {function content_560b6c55449a30_91889008($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'E:\\WWW\\luosiwang\\app\\include\\libs\\plugins\\function.url.php';
if (!is_callable('smarty_function_searchurl')) include 'E:\\WWW\\luosiwang\\app\\include\\libs\\plugins\\function.searchurl.php';
?><?php global $db,$db_config,$config;
		$time = time();
		if($config[sy_web_site]=="1"){
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}
        eval('$paramer=array("namelen"=>"30","comlen"=>"30","isshow"=>"1","ispage"=>"1","rec"=>"\'auto.rec\'","hy"=>"\'auto.hy\'","job1"=>"\'auto.job1\'","job1_son"=>"\'auto.job1_son\'","job_post"=>"\'auto.job_post\'","jobids"=>"\'auto.jobids\'","pr"=>"\'auto.pr\'","mun"=>"\'auto.mun\'","provinceid"=>"\'auto.provinceid\'","cityid"=>"\'auto.cityid\'","ltype"=>"\'auto.ltype\'","three_cityid"=>"\'auto.three_cityid\'","type"=>"\'auto.type\'","edu"=>"\'auto.edu\'","exp"=>"\'auto.exp\'","sex"=>"\'auto.sex\'","salary"=>"\'auto.salary\'","keyword"=>"\'auto.keyword\'","key"=>"\'key\'","sdate"=>"\'auto.sdate\'","cert"=>"\'auto.cert\'","urgent"=>"\'auto.urgent\'","uptime"=>"\'auto.uptime\'","order"=>"\'auto.order\'","limit"=>"16","item"=>"\'job_list\'","name"=>"\'joblist1\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `edate`>'$time' and `state`=1";
		}else{
			$where = "`edate`>'$time' and `state`=1";
		}
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[rec]){
			$where.=" AND `rec_time`>".time();
		}
		if($paramer['cert']){
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`<>2";
		}
		if($paramer[status]){
			$where.= " and `status`=1";
		}else{
			$where.= " and `status`<>1";
		}
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		}
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		if($paramer[job1_son])
		{
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		if($paramer[job_post])
		{
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		if($paramer['jobids'])
		{
			$where.= " AND (`job1` = $paramer[jobids] OR `job1_son`=$paramer[jobids] OR `job_post`=$paramer[jobids])";
		}
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		if($paramer[edu]){
			$where .= " AND `edu` = $paramer[edu]";
		}
		if($paramer[exp]){
			$where .= " AND `exp` = $paramer[exp]";
		}
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		if($paramer[salary]){
			$where .= " AND `salary` = $paramer[salary]";
		}
		if($paramer[cityin]){
			$where .= " AND( AND `provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		if($paramer[uptime]){
			$uptime = $time-$paramer[uptime]*86400;
			$where.=" AND `lastupdate`>$uptime";
		}
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		if($paramer[order] && $paramer[order]!="lastdate"){
			$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
		}else{
			$order = " ORDER BY `lastupdate` ";
		}
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		}
		if($paramer['orderby']=="rec"){
			$nowtime=time();
			$where.=" ORDER BY if(rec_time>$nowtime,rec_time,lastupdate)  desc";
		}else{
			$where.=$order.$sort;
		}
		if($paramer[where]){
			$where = $paramer[where];
		}
		if($paramer[limit]){
			$limit = " limit ".$paramer[limit];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[limit]?$paramer[limit]:"6",$_smarty_tpl);
            $_smarty_tpl->tpl_vars["firmurl"]=new Smarty_Variable;
			$_smarty_tpl->tpl_vars["firmurl"]->value = $config['sy_weburl']."/index.php?m=job".$ParamerArr[firmurl];
		}
		$job_list = $db->select_all("company_job",$where.$limit);
		if(is_array($job_list)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($job_list as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			
			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`");
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						$r_uid[$value['uid']] = $value['yyzz_status'];
					}
				}
			}
			include PLUS_PATH."/comrating.cache.php";
			foreach($job_list as $key=>$value){
				$job_list[$key] = $db->array_action($value,$cache_array);
				$job_list[$key][stime] = date("Y-m-d",$value[sdate]);
				$job_list[$key][etime] = date("Y-m-d",$value[edate]);
				$job_list[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);

				$job_list[$key][yyzz_status] =$r_uid[$value['uid']]['yyzz_status'];
				$time=time()-$value['lastupdate'];

				if($time>86400 && $time<604800){
					$job_list[$key]['time'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					$job_list[$key]['time'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					$job_list[$key]['time'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					$job_list[$key]['time'] = "刚刚";
				}else{
					$job_list[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($job_list[$key]['welfare'])&&$job_list[$key]['welfare']){
					foreach($job_list[$key]['welfare'] as $val){
						$job_list[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$job_list[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$job_list[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$job_list[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$job_list[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$job_list[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$job_list[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$job_list[$key][color] = str_replace("#","",$v[com_color]);
						$job_list[$key][ratlogo] = $v[com_pic];
						$job_list[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$job_list[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$job_list[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$job_list[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job_list[$key][name_n]);
					$job_list[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$job_list[$key][com_n]);
					$job_list[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$job_list[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
				}
			}
			if(is_array($job_list)){
				if($paramer[keyword]!=""&&!empty($job_list)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<?php global $db,$db_config,$config;
		$time = time();
		if($config[sy_web_site]=="1"){
			if($config[cityid]>0 && $config[cityid]!=""){
				$paramer[cityid] = $config[cityid];
			}
			if($config[three_cityid]>0 && $config[three_cityid]!=""){
				$paramer[three_cityid] = $config[three_cityid];
			}
			if($config[hyclass]>0 && $config[hyclass]!=""){
				$paramer[hy]=$config[hyclass];
			}
		}
        eval('$paramer=array("namelen"=>"15","comlen"=>"19","rec"=>"1","limit"=>"6","item"=>"\'blist\'","nocache"=>"")
;');
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr[arr];
        $Purl =  $ParamerArr[purl];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		if($paramer[sdate]){
			$where = "`sdate`>".strtotime("-".intval($paramer[sdate])." day",time())." and `edate`>'$time' and `state`=1";
		}else{
			$where = "`edate`>'$time' and `state`=1";
		}
		if($paramer[uid]){
			$where .= " AND `uid` = '$paramer[uid]'";
		}
		if($paramer[rec]){
			$where.=" AND `rec_time`>".time();
		}
		if($paramer['cert']){
			$company=$db->select_all("company","`yyzz_status`=1","`uid`");
			if(is_array($company)){
				foreach($company as $v){
					$job_uid[]=$v['uid'];
				}
			}
			$where.=" and `uid` in (".@implode(",",$job_uid).")";
		}
		if($paramer[noid]){
			$where.= " and `id`<>$paramer[noid]";
		}
		if($paramer[r_status]){
			$where.= " and `r_status`=2";
		}else{
			$where.= " and `r_status`<>2";
		}
		if($paramer[status]){
			$where.= " and `status`=1";
		}else{
			$where.= " and `status`<>1";
		}
		if($paramer[pr]){
			$where .= " AND `pr` =$paramer[pr]";
		}
		if($paramer['hy']){
			$where .= " AND `hy` = $paramer[hy]";
		}
		if($paramer[mun]){
			$where .= " AND `mun` = $paramer[mun]";
		}
		if($paramer[job1]){
			$where .= " AND `job1` = $paramer[job1]";
		}
		if($paramer[job1_son])
		{
			$where .= " AND `job1_son` = $paramer[job1_son]";
		}
		if($paramer[job_post])
		{
			$where .= " AND (`job_post` IN ($paramer[job_post]))";
		}
		if($paramer['jobwhere']){
			$where .=" and ".$paramer['jobwhere'];
		}
		if($paramer['jobids'])
		{
			$where.= " AND (`job1` = $paramer[jobids] OR `job1_son`=$paramer[jobids] OR `job_post`=$paramer[jobids])";
		}
		if($paramer['jobin']){
			$where .= " AND (`job1` IN ($paramer[jobin]) OR `job1_son` IN ($paramer[jobin]) OR `job_post` IN ($paramer[jobin]))";
		}
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = $paramer[provinceid]";
		}
		if($paramer['cityid']){
			$where .= " AND (`cityid` IN ($paramer[cityid]))";
		}
		if($paramer['three_cityid']){
			$where .= " AND (`three_cityid` IN ($paramer[three_cityid]))";
		}
		if($paramer['cityin']){
			$where .= " AND `three_cityid` IN ($paramer[cityin])";
		}
		if($paramer[edu]){
			$where .= " AND `edu` = $paramer[edu]";
		}
		if($paramer[exp]){
			$where .= " AND `exp` = $paramer[exp]";
		}
		if($paramer[type]){
			$where .= " AND `type` = $paramer[type]";
		}
		if($paramer[sex]){
			$where .= " AND `sex` = $paramer[sex]";
		}
		if($paramer[salary]){
			$where .= " AND `salary` = $paramer[salary]";
		}
		if($paramer[cityin]){
			$where .= " AND( AND `provinceid` IN ($paramer[cityin]) OR `cityid` IN ($paramer[cityin]) OR `three_cityid` IN ($paramer[cityin]))";
		}
		if($paramer[urgent]){
			$where.=" AND `urgent_time`>".time();
		}
		if($paramer[uptime]){
			$uptime = $time-$paramer[uptime]*86400;
			$where.=" AND `lastupdate`>$uptime";
		}
		if($paramer[comname]){
			$where.=" AND `com_name` LIKE '%".$paramer[comname]."%'";
		}
		if($paramer[com_pro]){
			$where.=" AND `com_provinceid` ='".$paramer[com_pro]."'";
		}
		if($paramer[keyword]){
			$where1[]="`name` LIKE '%".$paramer[keyword]."%'";
			$where1[]="`com_name` LIKE '%".$paramer[keyword]."%'";
			include PLUS_PATH."/city.cache.php";
			foreach($city_name as $k=>$v){
				if(strpos($v,$paramer[keyword])!==false){
					$cityid[]=$k;
				}
			}
			if(is_array($cityid)){
				foreach($cityid as $value){
					$class[]= "(provinceid = '".$value."' or cityid = '".$value."')";
				}
				$where1[]=@implode(" or ",$class);
			}
			$where.=" AND (".@implode(" or ",$where1).")";
		}
		if($paramer["job"]){
			$where.=" AND `job_post` in ($paramer[job])";
		}
		if($paramer[order] && $paramer[order]!="lastdate"){
			$order = " ORDER BY ".str_replace("'","",$paramer[order])."  ";
		}else{
			$order = " ORDER BY `lastupdate` ";
		}
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		}
		if($paramer['orderby']=="rec"){
			$nowtime=time();
			$where.=" ORDER BY if(rec_time>$nowtime,rec_time,lastupdate)  desc";
		}else{
			$where.=$order.$sort;
		}
		if($paramer[where]){
			$where = $paramer[where];
		}
		if($paramer[limit]){
			$limit = " limit ".$paramer[limit];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company_job",$where,$Purl,"",$paramer[limit]?$paramer[limit]:"6",$_smarty_tpl);
            $_smarty_tpl->tpl_vars["firmurl"]=new Smarty_Variable;
			$_smarty_tpl->tpl_vars["firmurl"]->value = $config['sy_weburl']."/index.php?m=job".$ParamerArr[firmurl];
		}
		$blist = $db->select_all("company_job",$where.$limit);
		if(is_array($blist)){
			$cache_array = $db->cacheget();
			$comuid=$jobid=array();
			foreach($blist as $key=>$value){
				if(in_array($value['uid'],$comuid)==false){$comuid[] = $value['uid'];}
				if(in_array($value['id'],$jobid)==false){$jobid[] = $value['id'];} 
			}
			$comuids = @implode(',',$comuid);
			$jobids = @implode(',',$jobid);
			
			if($comuids){
				$r_uids=$db->select_all("company","`uid` IN (".$comuids.")","`uid`,`yyzz_status`");
				if(is_array($r_uids)){
					foreach($r_uids as $key=>$value){
						$r_uid[$value['uid']] = $value['yyzz_status'];
					}
				}
			}
			include PLUS_PATH."/comrating.cache.php";
			foreach($blist as $key=>$value){
				$blist[$key] = $db->array_action($value,$cache_array);
				$blist[$key][stime] = date("Y-m-d",$value[sdate]);
				$blist[$key][etime] = date("Y-m-d",$value[edate]);
				$blist[$key][lastupdate] = date("Y-m-d",$value[lastupdate]);

				$blist[$key][yyzz_status] =$r_uid[$value['uid']]['yyzz_status'];
				$time=time()-$value['lastupdate'];

				if($time>86400 && $time<604800){
					$blist[$key]['time'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					$blist[$key]['time'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					$blist[$key]['time'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					$blist[$key]['time'] = "刚刚";
				}else{
					$blist[$key]['time'] = date("Y-m-d",$value['lastupdate']);
				}
				if(is_array($blist[$key]['welfare'])&&$blist[$key]['welfare']){
					foreach($blist[$key]['welfare'] as $val){
						$blist[$key]['welfarename'][]=$cache_array['comclass_name'][$val];
					}

				}
				if($paramer[comlen]){
					$blist[$key][com_n] = mb_substr($value['com_name'],0,$paramer[comlen],"GBK");
				}
				if($paramer[namelen]){
					if($value['rec_time']>time()){
						$blist[$key][name_n] = "<font color='red'>".mb_substr($value['name'],0,$paramer[namelen],"GBK")."</font>";
					}else{
						$blist[$key][name_n] = mb_substr($value['name'],0,$paramer[namelen],"GBK");
					}
				}else{
					if($value['rec_time']>time()){
						$blist[$key]['name_n'] = "<font color='red'>".$value['name']."</font>";
					}
				}
				$blist[$key][job_url] = Url("job",array("c"=>"comapply","id"=>$value[id]),"1");
				$blist[$key][com_url] = Url("company",array("c"=>"show","id"=>$value[uid]));
				foreach($comrat as $k=>$v){
					if($value[rating]==$v[id]){
						$blist[$key][color] = str_replace("#","",$v[com_color]);
						$blist[$key][ratlogo] = $v[com_pic];
						$blist[$key][ratname] = $v[name];
					}
				}
				if($paramer[keyword]){
					$blist[$key][name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[name]);
					$blist[$key][com_name]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$value[com_name]);
					$blist[$key][name_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$blist[$key][name_n]);
					$blist[$key][com_n]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$blist[$key][com_n]);
					$blist[$key][job_city_one]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[provinceid]]);
					$blist[$key][job_city_two]=str_replace($paramer[keyword],"<font color=#FF6600 >".$paramer[keyword]."</font>",$city_name[$value[cityid]]);
				}
			}
			if(is_array($blist)){
				if($paramer[keyword]!=""&&!empty($blist)){
					addkeywords('3',$paramer[keyword]);
				}
			}
		} ?>
<?php global $db,$db_config,$config;eval('$paramer=array("limit"=>"5","rec"=>"1","item"=>"\'com\'","nocache"=>"")
;');$com=array();

		if($config['sy_web_site']=="1"){
			if($config['cityid']>0 && $config['cityid']!=""){
				$paramer['cityid']=$config['cityid'];
			}
			if($config['hyclass']>0 && $config['hyclass']!=""){
				$paramer['hy']=$config['hyclass'];
			}
		}
		$time = time();
		$ParamerArr = GetSmarty($paramer,$_GET,$_smarty_tpl);
		$paramer = $ParamerArr['arr'];
		$Purl =  $ParamerArr['purl'];
        global $ModuleName;
        if(!$Purl["m"]){
            $Purl["m"]=$ModuleName;
        }
		$where="`name`<>''";
		if($paramer['keyword']){
			$where.=" AND `name` LIKE '%".$paramer['keyword']."%'";
		}
		if($paramer['hy']){
			$where .= " AND `hy` = '".$paramer['hy']."'";
		}
		if($paramer['pr']){
			$where .= " AND `pr` = '".$paramer['pr']."'";
		}
		if($paramer['mun']){
			$where .= " AND `mun` = '".$paramer['mun']."'";
		}
		if($paramer['provinceid']){
			$where .= " AND `provinceid` = '".$paramer['provinceid']."'";
		}
		if($paramer['cityid']){
			$where .= " AND (`cityid` = '".$paramer['cityid']."' or `provinceid` = '".$paramer['cityid']."')";
		}
		if($paramer['linkman']){
			$where .= " AND `linkman`<>''";
		}
		if($paramer['linktel']){
			$where .= " AND `linktel`<>''";
		}
		if($paramer['linkmail']){
			$where .= " AND `linkmail`<>''";
		}
		if($paramer['logo']){
			$where .= " AND `logo`<>''";
		}
		if($paramer['r_status']){
			$where .= " AND `r_status`='".$paramer['r_status']."'";
		}else{
			$where .= " AND `r_status`<>'2'";
		}
		if($paramer['cert']){
			$where .= " AND `yyzz_status`='1'";
		}
		if($paramer['uptime']){
			$uptime = $time-$paramer['uptime']*3600;
			$where.=" AND `lastupdate`>'".$uptime."'";
		}
		if($paramer['jobtime']){
			$where.=" AND `jobtime`<>''";
		}
		if($paramer['rec']){
			$where.=" AND `rec`='1'";
		}
		if($paramer['order']){
			if($paramer['order']=="lastＵpdate"){
				$paramer['order']="lastupdate";
			}
			$order = " ORDER BY `".$paramer['order']."`  ";
		}else{
			$order = " ORDER BY `jobtime` ";
		}
		if($paramer['sort']){
			$sort = $paramer['sort'];
		}else{
			$sort = " DESC";
		}
		if($paramer['limit']){
			$limit=" limit ".$paramer['limit'];
		}
		$where.=$order.$sort;
		if($paramer['where']){
			$where = $paramer['where'];
		}
		$cache_array = $db->cacheget();
		if($paramer['ispage']){
			if($paramer['rec']==1){
				$limit = PageNav($paramer,$_GET,"company",$where,$Purl,"","1",$_smarty_tpl);
			}else{
				$limit = PageNav($paramer,$_GET,"company",$where,$Purl,"","0",$_smarty_tpl);
			}

            $_smarty_tpl->tpl_vars['firmurl']=new Smarty_Variable;
			$_smarty_tpl->tpl_vars['firmurl']->value = $ParamerArr['firmurl'];
		}
		$Query = $db->query("SELECT * FROM $db_config[def]company where ".$where.$limit);
		while($rs = $db->fetch_array($Query)){
			$com[] = $db->array_action($rs,$cache_array);
			$ListId[] = $rs['uid'];
		}
		if($paramer['ismsg']){
			$Msgid = @implode(",",$ListId);
			$msglist = $db->select_alls("company_msg","resume","a.`cuid` in ($Msgid) and a.`uid`=b.`uid` order by a.`id` desc","a.cuid,a.content,b.name,b.photo,b.def_job");
			if(is_array($ListId) && is_array($msglist)){
				foreach($com as $key=>$value){
					foreach($msglist as $k=>$v){
						if($value['uid']==$v['cuid']){
							$com[$key]['msg'][$k]['content'] = $v['content'];
							$com[$key]['msg'][$k]['name'] = $v['name'];
							$com[$key]['msg'][$k]['photo'] = $v['photo'];
							$com[$key]['msg'][$k]['eid'] = $v['def_job'];
						}
					}
				}
			}
		}
		if($paramer['isjob']){
			$JobId = @implode(",",$ListId);
			$JobList=$db->select_all("company_job","`uid` IN ($JobId) and `edate`>'".mktime()."' and r_status<>'2' and status<>'1' and state=1  order by `lastupdate` desc");
			if(is_array($ListId) && is_array($JobList)){
				foreach($com as $key=>$value){
					$com[$key]['jobnum'] = 0;
					foreach($JobList as $k=>$v){
						if($value['uid']==$v['uid']){
							$id = $v['id'];
							$com[$key]['newsjob'] = $v['name'];
							$com[$key]['newsjob_status'] = $v['status'];
							$com[$key]['r_status'] = $v['r_status'];

							$v = $db->array_action($value,$cache_array);
							$v['job_url'] = Url("job",array("c"=>"comapply","id"=>$JobList[$k]['id']),"1");
							$v['id']= $id;
							$v['name'] = $com[$key]['newsjob'];
							$com[$key]['joblist'][] = $v;
							$com[$key]['jobnum'] = $com[$key]['jobnum']+1;
						}
					}
					foreach($comrat as $k=>$v){
						if($value['rating']==$v['id']){
							$com[$key]['color'] = $v['com_color'];
							$com[$key]['ratlogo'] = $v['com_pic'];
						}
					}
				}
			}
		}
		if($paramer['isnews']){
			$JobId = @implode(",",$ListId);
			$NewsList=$db->select_all("company_news","`uid` IN ($JobId) and status=1  order by `id` desc");
			if(is_array($ListId) && is_array($NewsList)){
				foreach($com as $key=>$value){
					$com[$key]['newsnum'] = 0;
					foreach($NewsList as $k=>$v){
						if($value['uid']==$v['uid']){
							$com[$key]['newslist'][] = $v;
							$com[$key]['newsnum'] = $com[$key]['newsnum']+1;
						}
					}
				}
			}
		}
		if($paramer['isshow']){
			$JobId = @implode(",",$ListId);
			$ShowList=$db->select_all("company_show","`uid` IN ($JobId) order by `id` desc");
			if(is_array($ListId) && is_array($ShowList)){
				foreach($com as $key=>$value){
					$com[$key]['shownum'] = 0;
					foreach($ShowList as $k=>$v){
						if($value['uid']==$v['uid']){
							$com[$key]['showlist'][] = $v;
							$com[$key]['shownum'] = $com[$key]['shownum']+1;
						}
					}
				}
			}
		}
		if($paramer['firm']){
			if($_COOKIE[uid]){$atnlist = $db->select_all("atn","`uid`='$_COOKIE[uid]'");}
			if(is_array($com)){
				foreach($com as $key=>$value){
					if(!empty($atnlist)){
						foreach($atnlist as $v){
							if($value['uid'] == $v['sc_uid']){
								$com[$key]['atn'] = "取消关注";
                                $com[$key]['atnstatus'] = "1";
								break;
							}else{
								$com[$key]['atn'] = "关注";
							}
						}
					}else{
						$com[$key]['atn'] = "关注";
					}
				}
			}
		}
		if(is_array($com)){
			foreach($com as $key=>$value){
				$com[$key]['com_url'] = Url("company",array("c"=>"show","id"=>$value['uid']));
				$com[$key]['joball_url'] = Url("company",array("c"=>"show","id"=>$value['uid'],"tp"=>"post"));
				if($value['logo']!=""){
					$com[$key]['logo'] = str_replace("./",$config['sy_weburl']."/",$value['logo']);
				}else{
					$com[$key]['logo'] = $config['sy_weburl']."/".$config['sy_unit_icon'];
				}
			}
			if($paramer['keyword']!=""&&!empty($com)){
				addkeywords('4',$paramer['keyword']);
			}
		} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<META name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">
<META name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/css.css" type="text/css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/job.css" type="text/css">
<!--[if IE 6]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
DD_belatedPNG.fix('.png');
<?php echo '</script'; ?>
>
<![endif]-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layer/layer.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/lazyload.min.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/industry.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/city.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/plus/job.cache.js" type="text/javascript"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/class.public.css" type="text/css">
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/class.public.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/js/com_index.js" language="javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/search.js" type="text/javascript"><?php echo '</script'; ?>
>
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/header.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/index_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="yun_body">
  <div class="yun_content">
    
    <div class="current_Location com_current_Location png">
      <div class="fl" >您当前的位置：<a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
">首页</a> > <span onclick="index_industry(1,'input[name=keyword]','.disc_zwsx','left:100px;top:100px; position:absolute;');">职位列表</span> </div>
    </div>
    <div class="clear"></div>    
    <div class="Search_jobs_box">
      <form action="<?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_jobdir']) {?>index.php<?php } else {
echo smarty_function_url(array('m'=>'job'),$_smarty_tpl);
}?>" method="get" onsubmit="return search_keyword(this);">
        <?php if (!$_smarty_tpl->tpl_vars['config']->value['sy_jobdir']) {?>
		<input type="hidden" name="m" value="job" id="m" />
		<?php }?>
        <input type="hidden" name="c" value="search" />
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['finder']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
        <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" />
        <?php } ?>
        <div class="php_disc">
          <div class="disc_sx"> <span class="disc_zwsx">职位筛选</span>

            <span class="Search_jobs_c_a_ln">
     
   >  共 <span class="blod org"><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</span> 个职位 
       </span>
       </div>
          <div class="disc_search">
            <input type="text" name="keyword" value="<?php echo $_GET['keyword'];?>
" placeholder="请输入要搜索的关键字" class="Search_jobs_text">
            <input type="submit" value="搜索" class="Search_jobs_submit">
            </div>
        </div>
			<?php if ($_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']]) {?> 
			<a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'hy'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">行业：<?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_GET['hy']];?>
</a> 
				<?php }?>
            <?php if ($_GET['job1']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'job1,job1_son,job_post'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">职位分类：<?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job1']];?>
</a> <?php }?>
            <?php if ($_GET['job1_son']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'job1_son,job_post'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job1_son']];?>
</a> <?php }?>
            <?php if ($_GET['job_post']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'job_post'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_GET['job_post']];?>
</a> <?php }?>
			<?php if ($_smarty_tpl->tpl_vars['config']->value['cityid']==''&&$_smarty_tpl->tpl_vars['config']->value['three_cityid']=='') {?> 
				<?php if ($_GET['provinceid']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'provinceid,cityid,three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作地点：<?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['provinceid']];?>
</a> <?php }?> 
				<?php if ($_GET['cityid']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'cityid,three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['cityid']];?>
</a> <?php }?> 
			<?php }?>
            <?php if ($_GET['three_cityid']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_GET['three_cityid']];?>
</a> <?php }?>
            <?php if ($_GET['salary']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">薪资：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['salary']];?>
</a> <?php }?>
            <?php if ($_GET['edu']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'edu'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">学历：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['edu']];?>
</a> <?php }?> 
            <?php if ($_GET['exp']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'exp'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">工作经验：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['exp']];?>
</a> <?php }?> 
            <?php if ($_GET['sex']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'sex'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">性别：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['sex']];?>
</a> <?php }?> 
            <?php if ($_GET['type']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'type'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">类型：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['type']];?>
</a> <?php }?>
            <?php if ($_GET['report']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'report'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">到岗时间：<?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_GET['report']];?>
</a> <?php }?> 
            <?php if ($_GET['sdate']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'sdate'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">发布时间：<?php echo $_smarty_tpl->tpl_vars['sdate']->value[$_GET['sdate']];?>
</a> <?php }?>
            <?php if ($_GET['uptime']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'uptime'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac">更新时间：<?php echo $_smarty_tpl->tpl_vars['uptime']->value[$_GET['uptime']];?>
</a> <?php }?>
            <?php if ($_GET['keyword']) {?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'keyword'),$_smarty_tpl);?>
" class="Search_jobs_c_a disc_fac"><?php echo $_GET['keyword'];?>
</a> <?php }?>
                   <?php if ($_smarty_tpl->tpl_vars['paras']->value) {?><a href="javascript:void(0)" class="Search_jobs_scq"  onclick="addfinder('<?php echo $_smarty_tpl->tpl_vars['paras']->value;?>
','1')">+ 保存为职位搜索器</a><?php }?> 
                   
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name">招聘行业：</div>
          <div class="Search_jobs_sub"> 
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'hy'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['hy']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['industry_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','hy'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'hy'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['hy']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?> <?php if ($_smarty_tpl->tpl_vars['key']->value>7) {?>hylist<?php }?>" <?php if ($_smarty_tpl->tpl_vars['key']->value>7) {?>style="display:none;"<?php }?>><?php echo $_smarty_tpl->tpl_vars['industry_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?> </div>
          <div class="zh_more"> <a href="javascript:checkmore('hylist');" id="hylist">更多</a> </div>
        </div>
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name"> 职位大类：</div>
          <div class="Search_jobs_sub ">
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'job1'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','job1'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'job1,job1_son,job_post'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?> <?php if ($_smarty_tpl->tpl_vars['key']->value>6) {?>job1list<?php }?>" <?php if ($_smarty_tpl->tpl_vars['key']->value>6) {?>style="display:none;"<?php }?>><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
          <div class="zh_more"> <a href="javascript:checkmore('job1list');" id="job1list">更多</a> </div>
        </div>
        <?php if ($_GET['job1']) {?>
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name"> 职位子类：</div>
          <div class="Search_jobs_sub ">
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'job1_son'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1_son']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','job1_son'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'job1_son,job_post'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job1_son']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <?php }?>
        <?php if (is_array($_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1_son']])) {?>
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name"> 职位类别：</div>
          <div class="Search_jobs_sub ">
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'job_post'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job_post']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_GET['job1_son']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','job_post'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'job_post'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['job_post']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <?php }?>
		<?php if ($_smarty_tpl->tpl_vars['config']->value['cityid']==''&&$_smarty_tpl->tpl_vars['config']->value['three_cityid']=='') {?> 
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name"> 工作省份：</div>
          <div class="Search_jobs_sub">
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'provinceid,cityid,three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['provinceid']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','provinceid'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'provinceid,cityid,three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['provinceid']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?> <?php if ($_smarty_tpl->tpl_vars['key']->value>18) {?>provinceidlist<?php }?>" <?php if ($_smarty_tpl->tpl_vars['key']->value>18) {?>style="display:none;"<?php }?>><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
          <div class="zh_more"> <a href="javascript:checkmore('provinceidlist');" id="provinceidlist">更多</a> </div>
        </div>
		 <?php }?>
        <?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']])) {?>
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name"> 工作城市：</div>
          <div class="Search_jobs_sub">
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'cityid,three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['cityid']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['provinceid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','cityid'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'cityid,three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['cityid']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <?php }?>
        <?php if (is_array($_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']])) {?>
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name"> 工作县区：</div>
          <div class="Search_jobs_sub">
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['three_cityid']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_GET['cityid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','three_cityid'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'three_cityid'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['three_cityid']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <?php }?>
        <div class="Search_jobs_form_list">
          <div class="Search_jobs_name"> 薪资待遇：</div>
          <div class="Search_jobs_sub ">
            <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['salary']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_salary']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','salary'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'salary'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['salary']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <div class="Search_jobs_form_list search_more" style="display:none">
          <div class="Search_jobs_name">学历要求：</div>
          <div class="Search_jobs_sub "> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'edu'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['edu']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_edu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','edu'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'edu'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['edu']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?> </div>
        </div>
        <div class="Search_jobs_form_list search_more"  style="display:none">
          <div class="Search_jobs_name"> 工作经验：</div>
          <div class="Search_jobs_sub"> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'exp'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['exp']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_exp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','exp'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'exp'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['exp']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <div class="Search_jobs_form_list search_more" style="display:none">
          <div class="Search_jobs_name"> 性别要求：</div>
          <div class="Search_jobs_sub"> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'sex'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['sex']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_sex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','sex'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'sex'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['sex']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?> </div>
        </div>
        <div class="Search_jobs_form_list search_more" style="display:none">
          <div class="Search_jobs_name"> 工作类型：</div>
          <div class="Search_jobs_sub"> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'type'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['type']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','type'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'type'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['type']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <div class="Search_jobs_form_list search_more" style="display:none">
          <div class="Search_jobs_name"> 到岗时间：</div>
          <div class="Search_jobs_sub"> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'report'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['report']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['comdata']->value['job_report']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','report'=>$_smarty_tpl->tpl_vars['v']->value,'untype'=>'report'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['report']==$_smarty_tpl->tpl_vars['v']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['comclass_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
</a> <?php } ?></div>
        </div>
        <div class="Search_jobs_form_list search_more" style="display:none">
          <div class="Search_jobs_name"> 发布时间：</div>
          <div class="Search_jobs_sub"> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'sdate'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['sdate']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['sdate']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','sdate'=>$_smarty_tpl->tpl_vars['key']->value,'untype'=>'sdate'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['sdate']==$_smarty_tpl->tpl_vars['key']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a> <?php } ?></div>
        </div>
        <div class="Search_jobs_form_list search_more" style="display:none">
          <div class="Search_jobs_name"> 更新时间：</div>
          <div class="Search_jobs_sub"> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'uptime'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['uptime']=='') {?>Search_jobs_sub_cur<?php }?>">全部</a> <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['uptime']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?> <a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','uptime'=>$_smarty_tpl->tpl_vars['key']->value,'untype'=>'uptime'),$_smarty_tpl);?>
" class="Search_jobs_sub_a <?php if ($_GET['uptime']==$_smarty_tpl->tpl_vars['key']->value) {?>Search_jobs_sub_cur<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a> <?php } ?></div>
        </div>
        <div class="clear"></div>
      </form>
      <div class="disc_more">
        <div class="disc_morecon" onclick="checkmore_search();"> <a href="javascript:void(0);"><span id="searchlist">更多选项</span>（学历，经验，性别，工作类型等）</a> </div>
      </div>
    </div>
    <div class="search_h1_box">
      <div class="search_h1_box_title">
        <ul class="search_h1_box_list">
          <li <?php if ($_GET['urgent']==''&&$_GET['rec']=='') {?>class="search_h1_box_cur"<?php }?>><a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search'),$_smarty_tpl);?>
">所有职位</a></li>
          <li <?php if ($_GET['urgent']) {?>class="search_h1_box_cur2"<?php }?> class="list_age png"><a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','urgent'=>1),$_smarty_tpl);?>
">紧急职位</a></li>
          <li <?php if ($_GET['rec']) {?>class="search_h1_box_cur3"<?php }?> class="list_rem png"><a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','rec'=>1),$_smarty_tpl);?>
">推荐职位</a></li>
        </ul>
        <div class="jobs_tag"> 你是不是想找：<?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;eval('$paramer=array("limit"=>"7","recom"=>"1","type"=>"3","item"=>"\'keylist\'","nocache"=>"")
;');$list=array();
	
		if($paramer[recom]){
			$tuijian = 1;
		}
		if($paramer[type]){
			$type = $paramer[type];
		}
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=20;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){ 
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='一句话招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='微简历';					
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='一句话招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='微简历';	
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}
					 
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['keylist']->key => $_smarty_tpl->tpl_vars['keylist']->value) {
$_smarty_tpl->tpl_vars['keylist']->_loop = true;
?> <a href="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['url'];?>
" class="jos_tag_a" title="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a> <?php } ?> </div>
      </div>
    </div>
    <div class="left_job_all fl">
      <div class="job_left_sidebar">
        <div class="search_user_list_tit search_user_list_tit_bg">
          <div class="search_Filter"> <span class="yun_search_tit">排序：</span>
            <ul class="search_Filter_list">
              <li <?php if ($_GET['order']=='lastdate') {?>class="search_Filter_current"<?php }?>><a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','order'=>'lastdate','untype'=>'order'),$_smarty_tpl);?>
">更新时间<i class="search_Filter_icon"></i></a></li>
              <li <?php if ($_GET['order']=='sdate') {?>class="search_Filter_current"<?php }?>><a href="<?php echo smarty_function_searchurl(array('m'=>'job','c'=>'search','order'=>'sdate','untype'=>'order'),$_smarty_tpl);?>
">发布时间<i class="search_Filter_icon"></i></a></li>
            </ul>
            <div class="search_Filter_Authenticate"> <a href="<?php if ($_GET['cert']) {
echo smarty_function_searchurl(array('m'=>'job','c'=>'search','untype'=>'cert'),$_smarty_tpl);
} else {
echo smarty_function_searchurl(array('m'=>'job','c'=>'search','cert'=>3),$_smarty_tpl);
}?>">
              <div class="checkbox_job search_Filter_Authenticate_mt8 <?php if ($_GET['cert']) {?>iselect_cert<?php }?>"><b></b></div>
              <em>执照已认证</em></a></div>
          </div>
        </div>
        <?php  $_smarty_tpl->tpl_vars['job_list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['job_list']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
$job_list = $job_list; if (!is_array($job_list) && !is_object($job_list)) { settype($job_list, 'array');}
foreach ($job_list as $_smarty_tpl->tpl_vars['job_list']->key => $_smarty_tpl->tpl_vars['job_list']->value) {
$_smarty_tpl->tpl_vars['job_list']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['job_list']->key;
?>
        <div class="search_job_list <?php if ($_smarty_tpl->tpl_vars['key']->value%2!='0') {
}?>">
          <div class="search_user_list_neme search_user_list_w240">
            <div class="checkbox_job" pid="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
"><i></i>
              <input type="checkbox" name="checkbox_job" style="display:none;" id="checkbox<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
"/>
            </div>
            <a href="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_url'];?>
" class="search_job_jobs_name" target="_blank"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['name_n'];?>
</a> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['rec_time']>time()) {?><img width="15" height="15" src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/tui.png" title="站长推荐" class="co_zztj png"/><?php }?> 
			<?php if (in_array($_smarty_tpl->tpl_vars['job_list']->value['id'],$_smarty_tpl->tpl_vars['lookjob']->value)) {?><span class="co_fav"><i></i><em>已浏览</em></span><?php }?> 
			<?php if (in_array($_smarty_tpl->tpl_vars['job_list']->value['id'],$_smarty_tpl->tpl_vars['favjob']->value)) {?><span class="co_fav"><i></i><em>已收藏</em></span><?php }?> 
			<?php if (in_array($_smarty_tpl->tpl_vars['job_list']->value['id'],$_smarty_tpl->tpl_vars['useridjob']->value)) {?><span class="co_fav"><i></i><em>已申请</em></span><?php }?>
			</div>
          <div class="disc_pay">&nbsp;<?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_salary'];?>
 </div>
          <div class=" clear"></div>
          <div class="company_det"> <a href="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['com_url'];?>
" target="_blank" class="search_job_com_name"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['com_n'];?>
</a>
          <?php if ($_smarty_tpl->tpl_vars['job_list']->value['ratlogo']!='') {?><img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['job_list']->value['ratlogo'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['job_list']->value['ratname'];?>
" width="16" height="16" /><?php }?> <?php if ($_smarty_tpl->tpl_vars['job_list']->value['yyzz_status']=='1') {?> <img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/disc_icon10.png" title="营业执照已审核" class="png"> <?php }?><span class="search_job_list_box_line">|</span><span class="search_job_list_box_s">经验：<em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_exp'];?>
</em> </span><span class="search_job_list_box_line">|</span><span class="search_job_list_box_s">学历：<em class="com_search_job_em"><?php echo $_smarty_tpl->tpl_vars['job_list']->value['job_edu'];?>
 </em></span><span class="search_job_list_box_line">|</span><span class="search_job_data">更新：<?php echo $_smarty_tpl->tpl_vars['job_list']->value['time'];?>
</span> </div>
          <div class="search_job_Apply_a"> 
          <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
          <a href="javascript:fav_job('<?php echo $_smarty_tpl->tpl_vars['job_list']->value['id'];?>
','1');" class="search_job_Apply_sc">收藏</a>
          <?php } else { ?>
              <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
              <a href="javascript:void(0);" onclick="layer.msg('只有个人用户才能收藏', 2, 8)" class="search_job_Apply_sc">收藏</a>
              <?php } else { ?>
              <a href="javascript:void(0);" onclick="showlogin('1');" class="search_job_Apply_sc">收藏</a>
              <?php }?>
          <?php }?>
           <a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'comapply','id'=>'`$job_list.id`'),$_smarty_tpl);?>
" target="_blank" class="search_job_Apply_fast">申请职位</a> </div>
        </div>
        <?php } ?>  
        <?php if ($_smarty_tpl->tpl_vars['total']->value!=0) {?>
        <div class="All_post_list fl">
          <div class="checkbox_all" onclick="checkAll();"><i></i>全选（当前列表）</div>
          <?php if ($_smarty_tpl->tpl_vars['usertype']->value==1) {?>
          <a id="comindex_sqjob" class="sq_post" title="申请选中职位" href="javascript:;">申请选中职位</a> 
          <a id="comindex_favjob" class="sq_post sq_post_sc" title="收藏选中职位" href="javascript:">收藏选中职位</a>
          <?php } else { ?>
              <?php if ($_smarty_tpl->tpl_vars['uid']->value) {?>
              <a class="sq_post" href="javascript:void(0);" onclick="layer.msg('只有个人用户才能申请', 2, 8)">申请选中职位</a> 
              <a class="sq_post sq_post_sc" href="javascript:void(0);" onclick="layer.msg('只有个人用户才能收藏', 2, 8)">收藏选中职位</a>
              <?php } else { ?>
              <a class="sq_post" href="javascript:void(0);" onclick="showlogin('1');">申请选中职位</a> 
              <a class="sq_post sq_post_sc" href="javascript:void(0);" onclick="showlogin('1');">收藏选中职位</a>
              <?php }?>
          <?php }?>
           </div>
        <div class="clear"></div>
        <div class="search_pages">
          <div class="pages"><?php echo $_smarty_tpl->tpl_vars['pagenav']->value;?>
</div>
        </div>
        <input value='<?php echo $_GET['ltype'];?>
' type='hidden' id='ltype'/>
        <?php } else { ?> 
        <!--没搜索到-->
        <div class="seachno">
          <div class="seachno_left"><img src="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/images/search-no.gif" width="144" height="102"></div>
          <div class="listno-content"> <strong>很抱歉，没有找到满足条件的职位</strong><br>
            <span> 建议您：<br>
            1、适当减少已选择的条件<br>
            2、适当删减或更改搜索关键字<br>
            </span> <span> 热门关键字：<br>
            <?php  $_smarty_tpl->tpl_vars['klist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['klist']->_loop = false;
global $config;eval('$paramer=array("limit"=>"7","recom"=>"1","type"=>"3","item"=>"\'klist\'","nocache"=>"")
;');$list=array();
	
		if($paramer[recom]){
			$tuijian = 1;
		}
		if($paramer[type]){
			$type = $paramer[type];
		}
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=20;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){ 
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='一句话招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='微简历';					
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='一句话招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='微简历';	
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}
					 
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['klist']->key => $_smarty_tpl->tpl_vars['klist']->value) {
$_smarty_tpl->tpl_vars['klist']->_loop = true;
?> <a href="<?php echo $_smarty_tpl->tpl_vars['klist']->value['url'];?>
" class="jos_tag_a" title="<?php echo $_smarty_tpl->tpl_vars['klist']->value['key_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['klist']->value['key_name'];?>
</a> <?php } ?></span> </div>
        </div>
        <?php }?> </div>
    </div>
    <div class="job_right_sidebar">
      <div class="job_right_box m10">
        <div class="job_right_box_h1"><span class="job_right_box_span">职位推荐</span><a href="javascript:void(0)" onclick="exchange();" class="job_right_box_more png">换一组</a></div>
        <ul class="job_right_box_list">
          <input type="hidden" value='2' id='exchangep'/>
          <?php  $_smarty_tpl->tpl_vars['blist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blist']->_loop = false;
$blist = $blist; if (!is_array($blist) && !is_object($blist)) { settype($blist, 'array');}
foreach ($blist as $_smarty_tpl->tpl_vars['blist']->key => $_smarty_tpl->tpl_vars['blist']->value) {
$_smarty_tpl->tpl_vars['blist']->_loop = true;
?>
          <li> <a href="<?php echo $_smarty_tpl->tpl_vars['blist']->value['job_url'];?>
" class="job_right_box_list_job"><?php echo $_smarty_tpl->tpl_vars['blist']->value['name_n'];?>
</a> <a href="<?php echo $_smarty_tpl->tpl_vars['blist']->value['com_url'];?>
" class="job_right_box_list_com"><?php echo $_smarty_tpl->tpl_vars['blist']->value['com_n'];?>
</a> <span class="">薪资：<em class="job_right_box_list_c"><?php echo $_smarty_tpl->tpl_vars['blist']->value['job_salary'];?>
 </em></span> </li>
          <?php } ?>
        </ul>
      </div>
      <div class="job_Subscribe m10">
        <div class="job_Subscribe_h1">订阅职位</div>
        <div class="job_Subscribe_p"> 根据你的筛选条件，定期将符合你要求的职位信息发送给你</div>
        <div class="job_Subscribe_dy"><a href="<?php echo smarty_function_url(array('m'=>'subscribe'),$_smarty_tpl);?>
" class="job_Subscribe_a">订阅职位</a></div>
      </div>
    </div>
  </div>
  <div class="yun_content">
    <div class="recomme_det">
      <h3 class="">企业推荐</h3>
      <div class="co_recom">
        <ul>
            <?php  $_smarty_tpl->tpl_vars['com'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['com']->_loop = false;
$com = $com; if (!is_array($com) && !is_object($com)) { settype($com, 'array');}
foreach ($com as $_smarty_tpl->tpl_vars['com']->key => $_smarty_tpl->tpl_vars['com']->value) {
$_smarty_tpl->tpl_vars['com']->_loop = true;
?>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['com']->value['com_url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['com']->value['logo'];?>
" onerror="showImgDelay(this,'<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_unit_icon'];?>
',2);" /><p><?php echo mb_substr($_smarty_tpl->tpl_vars['com']->value['name'],0,13,'gbk');?>
</p></a></li>
			<?php } ?>
        </ul>
      </div>
    </div>
    <div class="recomme_det">
      <h3 class=""><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
为您提供人才网最新招聘信息</h3>
      <div class="co_recom co_recom_link">
			<dl>
				<dt>周边招聘：</dt>
				<dd>
                <?php if ($_smarty_tpl->tpl_vars['zpthreecityid']->value) {?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['zpthreecityid']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','three_cityid'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php } elseif ($_smarty_tpl->tpl_vars['zpcityid']->value) {?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_type']->value[$_smarty_tpl->tpl_vars['zpcityid']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','cityid'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php } else { ?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','provinceid'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['city_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php }?>
				</dd>
			</dl>
			<dl>
				<dt>招聘频道：</dt>
				<dd>
                <?php if ($_smarty_tpl->tpl_vars['zpjobpost']->value) {?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['zpjobpost']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','job_post'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php } elseif ($_smarty_tpl->tpl_vars['zpjob1son']->value) {?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_type']->value[$_smarty_tpl->tpl_vars['zpjob1son']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','job1_son'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php } else { ?>
                	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['job_index']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<a href="<?php echo smarty_function_url(array('m'=>'job','c'=>'search','job1'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['job_name']->value[$_smarty_tpl->tpl_vars['v']->value];?>
招聘</a>
					<?php } ?>
                <?php }?>
				</dd>
			</dl>
			<dl style="border-bottom:0;">
				<dt>热门搜索：</dt>
				<dd>
                <?php  $_smarty_tpl->tpl_vars['keylist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keylist']->_loop = false;
global $config;eval('$paramer=array("limit"=>"20","recom"=>"1","type"=>"3","item"=>"\'keylist\'","nocache"=>"")
;');$list=array();
	
		if($paramer[recom]){
			$tuijian = 1;
		}
		if($paramer[type]){
			$type = $paramer[type];
		}
		if($paramer[limit]){
			$limit=$paramer[limit];
		}else{
			$limit=20;
		}
		include PLUS_PATH."/keyword.cache.php";
		if($paramer[iswap]){
			$wap = "/wap";
		}else{
			$index =1;
		}
		if(is_array($keyword)){
			if($paramer[iswap]){
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v[tuijian]!=1){
						continue;
					}
					if($type && $v[type]!=$type){
						continue;
					}

					$i++;
					if($v[type]=="1"){ 
						$v[url] = Url("wap",array("c"=>"once","keyword"=>$v['key_name']));
						$v[type_name]='一句话招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("wap",array("c"=>"tiny","keyword"=>$v['key_name']));
						$v['type_name']='微简历';					
					}elseif($v[type]=="3"){
						$v[url] = Url("wap",array("c"=>"job","keyword"=>$v['key_name']));
						$v[type_name]='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("wap",array("c"=>"company","keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("wap",array("c"=>"resume","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}else{
				$i=0;
				foreach($keyword as $k=>$v){
					if($tuijian && $v['tuijian']!=1){
						continue;
					}
					if($type && $v['type']!=$type){
						continue;
					}
					$i++;
					if($v['type']=="1"){
						$v['url'] = Url("once",array("keyword"=>$v['key_name']));
						$v['type_name']='一句话招聘';
					}elseif($v['type']=="13"){
						$v['url'] = Url("tiny",array("keyword"=>$v['key_name']));
						$v['type_name']='微简历';	
					}elseif($v['type']=="3"){
						$v['url'] = Url("job",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='职位';
					}elseif($v['type']=="4"){
						$v['url'] = Url("company",array("keyword"=>$v['key_name']));
						$v['type_name']='公司';
					}elseif($v['type']=="5"){
						$v['url'] = Url("resume",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='人才';
					}else if($v['type']=="12"){
						$v['url'] = Url("ask",array("c"=>"search","keyword"=>$v['key_name']));
						$v['type_name']='问答';
					}
					$v['key_title']=$v['key_name'];
					if($v['color']){
						$v['key_name']="<font color=\"".$v['color']."\">".$v['key_name']."</font>";
					}
					 
					$list[] = $v;
					if($i==$limit){
						break;
					}
				}
			}
		}$list = $list; if (!is_array($list) && !is_object($list)) { settype($list, 'array');}
foreach ($list as $_smarty_tpl->tpl_vars['keylist']->key => $_smarty_tpl->tpl_vars['keylist']->value) {
$_smarty_tpl->tpl_vars['keylist']->_loop = true;
?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['keylist']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['keylist']->value['key_name'];?>
</a> 
                <?php } ?>
				</dd>
			</dl>
      </div>
    </div>
  </div>
</div>
<div id="sqjob_show" style=" display:none; float:left">
  <div class="Pop-up_logoin"  style="padding:10px 20px 20px 20px;">
    <div class="Pop-up_logoin_sq" id="resume_job"> 
     <span style="width:90px; font-weight:bold; padding:10px  0 0 0; display:block">选择简历：</span>
     <div style="clear:both"></div>
      <div class="POp_up_r"></div>
    </div>
    <div style="clear:both"></div>
    <div class="Pop-up_logoin_sq" style="margin-top:10px;">
      <input id="click_comindex_sqjob" class="login_button2" style="margin-left:80px;"type="button" value="提交申请" name="Submit">
    </div>
  </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/footer.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/public_search/login.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
