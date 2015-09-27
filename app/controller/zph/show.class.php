<?php
class show_controller extends zph_controller{ 
	function index_action(){   
		$this->Zphpublic_action();
		$id=(int)$_GET['id'];
		$M=$this->MODEL('zph');
		$row=$M->GetZphOnce(array("id"=>$id)); 
		$row["stime"]=strtotime($row['starttime'])-mktime();
		$row["etime"]=strtotime($row['endtime'])-mktime();
		$rows=$M->GetZphPic(array("zid"=>$id));
		$data['zph_title']=$row['title'];
		$data['zph_desc']=$this->GET_content_desc($row['body']);
		$this->data=$data;
		$this->yunset("Info",$row);
		$this->yunset("Image_info",$rows);
		$this->seo("zph_show");
		$this->zph_tpl('zphshow'); 
	} 
}
?>