<?php
class index_controller extends common{
	function index_action()
	{
		if($this->config['sy_linksq']=="1")
		{
			header("location:".Url('error'));
		}
		if($_POST['submit'])
		{
			session_start();
			if(md5($_POST['authcode'])!=$_SESSION['authcode'])
			{
				unset($_SESSION['authcode']);
				$this->ACT_layer_msg("验证码不正确！",8,$_SERVER['HTTP_REFERER']);
			}
			$data['link_name']=trim($_POST['title']);
			$data['link_url']=$_POST['url'];
			$data['link_type']=$_POST['type'];
			$data['link_time']=mktime();
			if($_POST['phototype']!='')
			{
				$data['img_type']=$_POST['phototype'];

				if($_POST['phototype']==1)
				{
					$upload=$this->upload_pic("upload/friend/",false);
					$pictures=$upload->picture($_FILES['uplocadpic'],false);

					$data['pic']=$pictures;
				}else{
					$data['pic']=$_POST['uplocadpic'];
				}
			}
			$M=$this->MODEL("link");
			$nbid=$M->AddLink($data);
			isset($nbid)?$this->ACT_layer_msg("请等待管理员审核！",9,$_SERVER['HTTP_REFERER']):$this->ACT_layer_msg("添加失败！",8,$_SERVER['HTTP_REFERER']);
		}
		$this->seo("friend");
		$this->yun_tpl(array('index'));
	}
}
?>