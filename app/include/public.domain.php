<?php
if($config['sy_web_site']=="1"){
	
	$host =  "http://".$_SERVER['HTTP_HOST'];
	
	if(!strpos($host,"localhost")&&!strpos($host,"127.0.0.1"))
	{
		
		
			
		
		if($host!=$config['sy_weburl']){
			
			if($_COOKIE['siteurl'] == $_SERVER['HTTP_HOST'])
			{
				$config['sy_weburl']	=  "http://".$_COOKIE['siteurl'];
				$config['cityid']		=  $_COOKIE['cityid'];
				$config['cityname']		=  $_COOKIE['cityname'];
				$config['webkeyword']	=  $_COOKIE['webkeyword'];
				$config['webmeta']		=  $_COOKIE['webmeta'];
				$config['did']			=  $_COOKIE['did'];
				$config['style']		=  $_COOKIE['style'];

			}else{

					
				include(PLUS_PATH."/domain_cache.php");
				include(PLUS_PATH."/city.cache.php");
				
				setcookies(
					array(
					'siteurl'=>'',
					'cityid'=>'',
					'three_cityid'=>'',
					'cityname'=>'',
					'webkeyword'=>'',
					'sy_weburl'=>'',
					'weblogo'=>'',
					'style'=>'',
					'webmeta'=>''
				),time()-86400,$config['sy_onedomain']);

				if(is_array($site_domain))
				{
						
					
					foreach($site_domain as $key=>$value){
						if($value['host']==$_SERVER['HTTP_HOST']){
							$parseDate['did']=$value['id'];
							if($value['three_cityid']>0){
								$parseDate['three_cityid']	=	$value['three_cityid'];
								$parseDate['cityname']		=	$city_name[$value['three_cityid']];
							}else{
								$parseDate['cityid']	=	$value['cityid'];
								$parseDate['cityname']	=	$city_name[$value['cityid']];
							}
							$parseDate['webtitle']   =	$value['webtitle'];
							$parseDate['weblogo']    =	$value['weblogo'];
							$parseDate['webkeyword'] =	$value['webkeyword'];
							$parseDate['webmeta']    =	$value['webmeta'];
							$parseDate['style']      =	$value['style'];
							$parseDate['sy_weburl']  =	$host;

							

							if(strpos($host,$config['sy_onedomain'])!==false)
							{
								$domainUrl  = $config['sy_onedomain'];

							}else{

								$domainUrlAll  = parse_url($host);
								$domainUrl = $domainUrlAll['host'];
							}
							setcookies($parseDate,time()+86400,$domainUrl);
							

							$config = array_merge($config,$parseDate);
						}
					}
				}
			}
		}
	}
}
function setcookies($parseDate=array(),$time,$domain){
	
	if(is_array($parseDate))
	{
		foreach($parseDate as $key=>$value)
		{
			SetCookie($key,$value,$time,"/",$domain);
		}
	}
}
?>