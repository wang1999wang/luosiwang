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
class cars_controller extends common{ 
	function news_tpl($tpl){
        $_GET['fuzai_min']=intval($_GET['fuzai_min']);
        if(!($_GET['fuzai_min']>0&&$_GET['fuzai_min']<=15)){
            $_GET['fuzai_min']=0;
        }
        $_GET['fuzai']=intval($_GET['fuzai']);
        if(!($_GET['fuzai']>0&&$_GET['fuzai']<=15)){
            $_GET['fuzai']=15;
        }
        $_GET['tishenggaodu_min']=intval($_GET['tishenggaodu_min']);
        if(!($_GET['tishenggaodu_min']>0&&$_GET['tishenggaodu_min']<=15)){
            $_GET['tishenggaodu_min']=0;
        }
        $_GET['tishenggaodu']=intval($_GET['tishenggaodu']);
        if(!($_GET['tishenggaodu']>0&&$_GET['tishenggaodu']<=15)){
            $_GET['tishenggaodu']=15;
        }
        $tishenggaodu_per=($_GET['tishenggaodu']/15*100).'%';
        $tishenggaodu_min_per=($_GET['tishenggaodu_min']/15*100).'%';
        
        $fuzai_min_per=($_GET['fuzai_min']/15*100).'%';
        $fuzai_per=($_GET['fuzai']/15*100).'%';
        
        $this->yunset('get',$_GET);
        $this->yunset('tishenggaodu_per',$tishenggaodu_per);
        $this->yunset('tishenggaodu_min_per',$tishenggaodu_min_per);
        $this->yunset('fuzai_min_per',$fuzai_min_per);
        $this->yunset('fuzai_per',$fuzai_per);
        
        $CacheList=$this->MODEL('cache')->GetCache('com');
        $this->yunset($CacheList);
		$this->yuntpl(array('default/cars/'.$tpl));
	}
}
?>