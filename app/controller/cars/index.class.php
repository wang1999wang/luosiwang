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
class index_controller extends cars_controller{ 
	function index_action(){	
        //1,���ţ�2,����
        switch($_GET['id']){
            case 1:$seo='remenchexing';break;
            case 2:$seo='cuxiaochexing';break;
            default:$seo='chachejiazu';break;
        }
		$this->seo($seo);
		$this->news_tpl('index');
	} 
}
?>