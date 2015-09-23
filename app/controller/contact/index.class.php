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
class index_controller extends common{ 
	function index_action(){	
        $adlist=$this->MODEL()->DB_select_all('ad');
        foreach($adlist as $k1=>$v1){
            $adlist_new[$v1['id']]=array('pic'=>FormatPicUrl(array('path'=>$v1['pic_url'])));
        }
        $this->yunset('adlist',$adlist_new);
		$this->seo("lianxiwomen");
		$this->yun_tpl(array('index'));
	} 
    function save_leaveword_action(){
		if(trim($_POST['username'])==''){
			$this->ACT_layer_msg("姓名不能为空！",8,$_SERVER['HTTP_REFERER']);
		}else{
			$value="`name`='".trim($_POST['username'])."',";
			$value.="`sex`='".trim($_POST['sex'])."',";
			$value.="`phone`='".trim($_POST['tel'])."',";
			$value.="`qq_email`='".trim($_POST['email'])."',";
			$value.="`content`='".trim($_POST['content'])."'";
			if($_POST['id']){
				$id=$_POST['id'];
				$oid=$this->obj->DB_update_all("leaveword",$value,"`id`='".$_POST['id']."'");
			}else{
				$oid=$this->obj->DB_insert_once("leaveword",$value);
				$id=$oid;
			}
			$oid?$this->ACT_layer_msg("留言(ID:".$id.")保存成功！",9,$_SERVER['HTTP_REFERER'],2,1):$this->ACT_layer_msg("保存失败，请销后再试！",8,$_SERVER['HTTP_REFERER']);
		}
	}
}
?>