<?php
class crmsync_controller extends common{

	function index_action(){
		//��ѯ��ͬ����Ч�û�����

		$usercount = $this->obj->DB_select_num("company22","`sync`='0' AND `name`<>'' AND (`linkphone`<>'' OR  `linktel`<>'')");
		$this->yunset("usercount",$usercount);
		$this->yunset("config",$this->config);
		$this->yuntpl(array('admin/admin_crmsync'));
	}
	//�û�ͬ������
	function sync_action(){	
		set_time_limit(0);
		if($_POST['count'] && $_POST['limit']){
			//��ѯ��������������
			$company = $this->obj->DB_select_all("company22","`sync`='0' AND `name`<>'' AND (`linkphone`<>'' OR  `linktel`<>'') ORDER BY uid DESC limit ".$_POST['limit'],"`uid`,`name`,`hy`,`mun`,`provinceid`,`cityid`,`address`,`website`,`linkman`,`linkphone`,`linktel`,`linkmail`");
			if(is_array($company)){
				include PLUS_PATH."/com.cache.php";
				include PLUS_PATH."/industry.cache.php";
				include PLUS_PATH."/city.cache.php";				
				foreach($company as $key=>$value){ 
					$jsonvalue['uid'] = $value['uid'];
					$jsonvalue['name'] = iconv("gbk","utf-8",$value['name']);
					$jsonvalue['hy'] = iconv("gbk","utf-8",$industry_name[$value['hy']]);
					$jsonvalue['comnum'] = iconv("gbk","utf-8",$comclass_name[$value['mun']]);
					$jsonvalue['area'] = iconv("gbk","utf-8",$city_name[$value['provinceid']].$city_name[$value['cityid']]);
					$jsonvalue['address'] = iconv("gbk","utf-8",$value['address']);
					$jsonvalue['url'] = $value['website'];
					$jsonvalue['linkman'] = iconv("gbk","utf-8",$value['linkman']);
					if(!$value['linkphone']){
						$jsonvalue['moblie'] = $value['linktel'];
					}else{
						$jsonvalue['moblie'] = $value['linkphone'];
					}
					$jsonvalue['email'] = $value['linkmail'];
					$Arr[] = $jsonvalue;
				}
				//ת��JSON
				$Crmjson['crmjson'] = json_encode($Arr);
				//����ͨ����Կ
				$Crmjson['crmkey']  = $this->config['crmkey'];
				$Crmjson['crmname'] = $this->config['crmname'];
				
				//CURL POST ����
				$url = 'http://www.crm.com/index.php?m=sync';//���յ�ַ
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//�����Ƿ񷵻���Ϣ
				curl_setopt($ch, CURLOPT_POST, 1);//����ΪPOST��ʽ
				curl_setopt($ch, CURLOPT_POSTFIELDS, $Crmjson);//POST����
				$response = curl_exec($ch);//���շ�����Ϣ
				if(curl_errno($ch)){//��������ʾ������Ϣ
					//print curl_error($ch);
				}
				curl_close($ch); //�ر�curl����
	
				$nowcount = count($company);
				$response = json_decode($response);
			
				if($response->state == '1')
				{
					if($response->uids)
					{
						$this->obj->DB_update_all("company22","`sync`='1'","`uid` IN (".$response->uids.")");
						$nowcount = count(explode(',',$response->uids));
					}
					$count = $_POST['count']-$nowcount;
					if($count<=0)
					{
						echo json_encode(array('state'=>'0'));
					}else{
						echo json_encode(array('state'=>'1','count'=>$count));
					}
				}else{
					echo json_encode(array('state'=>'2'));
				}
			}
		}else{
			echo json_encode(array('state'=>'2'));
		}
	}

	//����
	function save_action(){
 		if($_POST["config"]){
		 unset($_POST["config"]);
		   foreach($_POST as $key=>$v){
		    	$config=$this->obj->DB_select_num("admin_config","`name`='$key'");
			   if($config==false){
				$this->obj->DB_insert_once("admin_config","`name`='$key',`config`='".iconv("utf-8", "gbk", $v)."'");
			   }else{
				$this->obj->DB_update_all("admin_config","`config`='".iconv("utf-8", "gbk", $v)."'","`name`='$key'");
			   }
		 	}
			$this->web_config(); 
			$this->ACT_layer_msg("��վ�������óɹ���",9,1);
		 }
	}
}
?>