<?php
class index_controller extends common{
	function index_action(){
        if($this->config['sy_jobdir']!=""){
			$jobclassurl=$this->config['sy_weburl']."/job/?c=search&";
		}else{
			$jobclassurl=$this->config['sy_weburl']."/index.php?m=job&c=search&";
		}
        //�õ�Ƭ
        $M=$this->MODEL();
        $ad_class_list1=$M->DB_select_all('ad_class','`id`=1 or `pid`=1');
        foreach($ad_class_list1 as $k1=>$v1){
            $ADCIDList[]=$v1['id'];
        }
        $ad_list1=$M->DB_select_all('ad','`class_id` in ('.implode(',',$ADCIDList).')');
        foreach($ad_class_list1 as $k1=>$v1){
            foreach($ad_list1 as $k2=>$v2){
                if($v1['id']==$v2['class_id']){
                    $ad_list1[$k1]['class_name'][]=$v1['class_name'];
                }
            }
        }
		$this->yunset("ad_list1",$ad_list1);
        //��̬
        $dongtai_class_list=$M->DB_select_all('news_group','1');
        foreach($dongtai_class_list as $k1=>$v1){
            $news_pic_list=$M->DB_select_all('news_base','`nid` in ('.$v1['id'].') and `newsphoto`<>\'\' and FIND_IN_SET(\'indextj\',`describe`) order by lastupdate desc limit 1');
            $NIDList=array();
            foreach($news_pic_list as $k2=>$v2){
                $NIDList[]=$v2['id'];
            }
            $news_nopic_list=$M->DB_select_all('news_base','`nid` in ('.$v1['id'].') and id not in ('.implode(',',$NIDList).') and FIND_IN_SET(\'indextj\',`describe`) order by lastupdate desc limit 4');
            foreach($news_nopic_list as $k2=>$v2){
                $news_nopic_list[$k2]['class_name']=$v1['name'];
                $news_nopic_list[$k2]['title']=mb_substr($v2['title'],0,12,'gbk');
            }
            $dongtai_class_list[$k1]['nopic']=$news_nopic_list;
            $dongtai_class_list[$k1]['pic']=$news_pic_list;
        }
        //�泵����
        $chache_class_list=$M->DB_select_all('school_group','1');
        foreach($chache_class_list as $k1=>$v1){
            $dongtai_pic_list=$M->DB_select_all('school_base','`nid` in ('.$v1['id'].') and FIND_IN_SET(\'indextj\',`describe`) order by lastupdate desc limit 2');
            foreach($dongtai_pic_list as $k2=>$v2){
                $dongtai_pic_list[$k2]['content']=trim(mb_substr(trim(strip_tags($v2['content'])),0,30,'gbk'));
            }
            $chache_class_list[$k1]['pic']=$dongtai_pic_list;
            $NIDList=array();
            foreach($dongtai_pic_list as $k2=>$v2){
                $NIDList[]=$v2['id'];
            }
        }
        $this->yunset("chache_class_list",$chache_class_list);
        $this->yunset("dongtai_class_list",$dongtai_class_list);
        
        $CacheM=$this->MODEL('cache');
        $CacheList=$CacheM->GetCache(array('job','city','com','user','hy'));
        $this->yunset($CacheList);
        
        $adlist=$this->MODEL()->DB_select_all('ad');
        foreach($adlist as $k1=>$v1){
            $adlist_new[$v1['id']]=array('pic'=>FormatPicUrl(array('path'=>$v1['pic_url'])),'ad_name'=>$v1['ad_name']);
            $adclasslist[$v1['class_id']][]=array('pic'=>FormatPicUrl(array('path'=>$v1['pic_url'])),'ad_name'=>$v1['ad_name'],'height'=>$v1['pic_height'],'width'=>$v1['pic_width']);
        }
        $this->yunset('adlist',$adlist_new);
        $this->yunset('adclasslist',$adclasslist);
        
		if($this->config["cityid"]){
			$this->seo("index",$this->config['webtitle'],$this->config['webkeyword'],$this->config['webmeta']);
		}else{
			$this->seo("index");
		}
		$this->yun_tpl(array('index'));
	}
	function top_action(){
		$this->seo("top");
		$this->yun_tpl(array('top'));
	}
	function moblie_action(){
		$this->seo("moblie");
		$this->yun_tpl(array('moblie'));
	}
	function wap_action(){
		$this->seo("wap");
		$this->yun_tpl(array('wap'));
	}
	function weixin_action(){
		$this->seo("weixin");
		$this->yun_tpl(array('weixin'));
	}
	function android_action(){
		$this->seo("android");
		$this->yun_tpl(array('android'));
	}
	function ios_action(){
		$this->seo("ios");
		$this->yun_tpl(array('ios'));
	}
	function site_action(){
		if($this->config["sy_web_site"]!="1"){
			$this->ACT_msg($_SERVER['HTTP_REFERER'], $msg = "��δ������վ��ģʽ��");
		}
		$this->seo("index");
		$this->yun_tpl(array('site'));
	}
	function logout_action(){
		$this->logout();
	}
	function GetHits_action(){
    	if($_GET['id']){
    		$M=$this->MODEL('article');
    		$M->AddNewsHits(array("id"=>(int)$_GET['id']));
    		$news_info=$M->GetNewsBaseOnce(array("id"=>(int)$_GET['id']),array("field"=>"hits"));
    		echo "document.write('".$news_info["hits"]."')";
    	}
    }
	function get_action(){
		$M=$this->MODEL('index');
		$row=$M->GetDescOne(array("id"=>(int)$_GET['id']));
		$top="";$footer="";
		if($row['top_tpl']==1){
            $top=APP_PATH."/app/template/".$this->config['style']."/header";
		}else if($row['top_tpl']==3){
			 $top=$row['top_tpl_dir'];
		}
		if($row['footer_tpl']==1){
            $footer=APP_PATH."/app/template/".$this->config['style']."/footer";
		}else if($row['footer_tpl']==3){
			 $footer=$row['footer_tpl_dir'];
		}
		$seo['title']=$row['title'];
		$seo['keywords']=$row['keyword'];
		$seo['description']=$row['descs'];
		$this->yunset("seo",$seo);
		$this->yunset("name",$row['name']);
		$this->yunset("content",$row['content']);
		$this->header_desc($row['title'],$row['keyword'],$row['descs']);
		$make=APP_PATH."/app/template/".$this->config['style']."/make";
		$make_top=APP_PATH."/app/template/".$this->config['style']."/make_top";
		$this->yuntpl(array($make_top,$top,$make,$footer));
	}
	function clickHits_action(){
		if($_GET['id']){
			$M=$this->MODEL("index");
			$id=(int)$_GET['id'];
			$ad=$M->GetAdOne(array("id"=>$id),array("field"=>"pic_src,id"));
			if(!empty($ad)){
				$ip = fun_ip_get();
				if($this->config['sy_adclick']>"0"){
					$num=$M->GetAdclickNum("`ip`='".$ip."' and `aid`='".$id."' and `addtime`>'".strtotime('-'.$this->config['sy_adclick'].' hour')."'");
					if($num>"0"){
						header('Location: '.$ad['pic_src']);
					}
				}
				$data['aid']=$id;
				$data['uid']=$this->uid;
				$data['ip']=$ip;
				$data['addtime']=time();
				$nid=$M->InsertAdclick($data);
				if($nid){
					$M->AddAdHits($id);
				}
				if(!$ad['pic_src']){
					$ad['pic_src']=$this->config['sy_weburl'];
				}
				header('Location: '.$ad['pic_src']);
			}
		}
	}
	 function savecompic_action(){
		if (!empty($_FILES)){
			$pic=$name='';
			$data=array();
			$tempFile = $_FILES['Filedata'];
			$upload=$this->upload_pic("data/upload/show/");
			$pic=$upload->picture($tempFile);
			$name=@explode('.',$_FILES['Filedata']['name']);
			$picurl=str_replace("data/upload/show","./data/upload/show",$pic);
			$data["picurl"]= $picurl;
			$data['title']=$this->stringfilter($name[0]);
			$data["ctime"]=time();
			$data['uid']=(int)$_POST['uid'];
			$id=$this->obj->insert_into("company_show",$data);
			if($id){
 				echo $name[0]."||".$picurl."||".$id;die;
			}else{
				echo "2";die;
			}
		}
	}
	function saveuserpic_action()
	{
		if (!empty($_FILES))
		{
			$pic=$name='';
			$data=array();
			$tempFile = $_FILES['Filedata'];
			$upload=$this->upload_pic("data/upload/show/");
			$pic=$upload->picture($tempFile);
			$name=@explode('.',$_FILES['Filedata']['name']);
			$picurl=str_replace("data/upload/show","./data/upload/show",$pic);
			$data['picurl']= $picurl;
			$data['title']=$this->stringfilter($name[0]);
			$data['ctime']=time();
			$data['uid']=(int)$_POST['uid'];
			$data['eid']=(int)$_GET['eid'];
			$id=$this->obj->insert_into("resume_show",$data);
			if($id){
 				echo $name[0]."||".$picurl."||".$id;die;
			}else{
				echo "2";die;
			}
		}
	}
}
?>