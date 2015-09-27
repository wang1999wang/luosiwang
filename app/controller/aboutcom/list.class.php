<?php
class list_controller extends common{
	function index_action(){
		$M=$this->MODEL('article');
        $class=$M->GetNewsGroupOnce(array('id'=>(int)$_GET['nid']),array('field'=>"`name`"));
        $this->yunset("classname",$class['name']);
		
		$data['news_class']=$class['name'];
		$this->data=$data;
		$this->seo("newslist");
		$this->news_tpl('list');
	}
}
?>