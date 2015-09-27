<?php
class list_controller extends article_controller{
	function index_action(){
		$M=$this->MODEL('article');
        $class=$M->GetNewsGroupOnce(array('id'=>(int)$_GET['nid']),array('field'=>"`name`"));
        $this->yunset("classname",$class['name']);
		
		$data['news_class']=$class['name'];
		$this->data=$data;
        
        switch($_GET['nid']){
            case 5:$seo='xinwenzhongxin';break;
            case 3:$seo='huodongzhongxin';break;
            default:$seo='echrdongtai';break;
        }
		
		$this->seo($seo);
		$this->news_tpl('list');
	}
}
?>