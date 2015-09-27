<?php
class list_controller extends cars_controller{
	function index_action(){
		$M=$this->MODEL('article');
        $class=$M->GetNewsGroupOnce(array('id'=>(int)$_GET['nid']),array('field'=>"`name`"));
        $this->yunset("classname",$class['name']);
		
		$data['news_class']=$class['name'];
		$this->data=$data;
        $this->yunset('s_list',array(1,3,8,18,7));
		$this->seo("newslist");
		$this->news_tpl('list');
	}
}
?>