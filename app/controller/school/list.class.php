<?php
/*
* $Author ��PHPYUN�����Ŷ�
*
* ����: http://www.phpyun.com
*
* ��Ȩ���� 2009-2015 ��Ǩ�γ���Ϣ�������޹�˾������������Ȩ����
*
* ���������δ����Ȩǰ���£�����������ҵ��Ӫ�����ο����Լ��κ���ʽ���ٴη�����
 */
class list_controller extends school_controller{
	function index_action(){
		$M=$this->MODEL('school');
        $class=$M->GetSchoolGroupOnce(array('id'=>(int)$_GET['nid']),array('field'=>"`name`"));
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