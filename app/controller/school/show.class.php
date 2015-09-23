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
class show_controller extends school_controller{
	function index_action(){   
		$id=(int)$_GET['id'];
		$M=$this->MODEL('school');
		$news=$M->GetSchoolBaseOnce(array('id'=>$id));
		$row=$M->GetSchoolContentOnce(array('nbid'=>$id)); 
        $news_class=$M->GetSchoolGroupOnce(array('id'=>$news['nid']));
		//$news['content']=$row['content'];
        $news['class_name']=$news_class['name'];
		$news_last=$M->GetSchoolBaseOnce(array("`id`<'".$id."'"),array('orderby'=>" `id` desc"));
 	 
		if(!empty($news_last)){ 
			if($this->config[sy_news_rewrite]=="2"){
				$news_last["url"]=$this->config['sy_weburl']."/school/".date("Ymd",$news_last["datetime"])."/".$news_last['id'].".html";
			}else{
				$news_last["url"]= Url('school',array('c'=>'show',"id"=>$news_last[id]),"1"); 
			}
		} 
		$news_next=$M->GetSchoolBaseOnce(array("`id`>'".$id."'"),array('orderby'=>" `id` desc"));
		if(!empty($news_next)){
			if($this->config[sy_news_rewrite]=="2"){
				$news_next["url"]=$this->config['sy_weburl']."/school/".date("Ymd",$news_next["datetime"])."/".$news_next['id'].".html";
			}else{
				$news_next["url"]= Url('school',array('c'=>'show',"id"=>$news_next[id]),"1"); 
			} 
		}
		$class=$M->GetSchoolGroupOnce(array("id"=>$news['nid']));
		if($news["keyword"]!="")
		{
			$keyarr = @explode(",",$news["keyword"]);
			if(is_array($keyarr) && !empty($keyarr))
			{
				foreach($keyarr as $key=>$value){
					$sqlkeyword[]= " `keyword` LIKE '%$value%'";
				}
				$sqlkw = @implode(" OR ",$sqlkeyword); 
				$about=$M->GetSchoolBaseList(array("(".$sqlkw.") and `id`<>'".$id."' and `newsphoto`<>''"),array("orderby"=>'`id` desc ','limit'=>3));
				if(is_array($about)){
					foreach($about as $k=>$v){
						if($this->config[sy_news_rewrite]=="2"){
							$about[$k]["url"]=$this->config['sy_weburl']."/school/".date("Ymd",$v["datetime"])."/".$v['id'].".html";
						}else{
							$about[$k]["url"]= Url('school',array('c'=>'show',"id"=>$v[id]),"1"); 
						}
						
					}
				}
			}
		}
		$info=$news;
		$data['news_title']=$news['title'];
		$data['news_keyword']=$news['keyword']; 
		$data['news_class']=$class['name'];
		$description=$news['description']?$news['description']:$news['content'];
		$data['news_desc']=$this->GET_content_desc($description); 
		$this->data=$data;

		
		$info["news_class"]=$class['name'];
		$info["last"]=$news_last;
		$info["next"]=$news_next;
		$info["like"]=$about;
        //$info['content']=htmlspecialchars_decode($info['content']);
		$this->yunset("Info",$info);
        
        switch($_GET['nid']){
            case 5:$seo='xinwenzhongxin';break;
            case 3:$seo='huodongzhongxin';break;
            default:$seo='echrdongtai';break;
        }
        $seo='echaxuetang';
		
		$this->seo($seo);
        
        $this->yunset(array('title'=>$info['title'],'keywords'=>$info['keywords'],'description'=>$info['description']));
        
		$this->news_tpl('show');
	} 
}
?>