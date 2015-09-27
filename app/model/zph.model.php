<?php
class zph_model extends model{
	function GetZphOnce($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('zhaopinhui',$WhereStr.$FormatOptions['where'],$FormatOptions['field']);
    }
	function GetZphPic($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('zhaopinhui_pic',$WhereStr.$FormatOptions['where'],$FormatOptions['field']);
    }
	function GetZphComInfo($UserinfoM,$Where=array(),$Options=array()){
		$Options['usertype']='2';
		$cominfo=$UserinfoM->GetUserinfoList($Where,$Options);
		if(count($cominfo)){
			$uids=array();
			foreach($cominfo as $val){
				$uids[]=$val['uid'];
			}
			$comtpl=$this->DB_select_all('company_statis',"`uid` in(".@implode(',',$uids).")","`uid`,`comtpl`");
			foreach($cominfo as $key=>$val){
				foreach($comtpl as $v){
					if($val['uid']==$v['uid']){
						$cominfo[$key]['comtpl']=$v['comtpl'];
					}
				}
			}
		}
		return $cominfo;
	}
    function GetZphComList($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('zhaopinhui_com',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	}
	function GetZphComOnce($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('zhaopinhui_com',$WhereStr.$FormatOptions['where'],$FormatOptions['field']);
    }
	function GetZphList($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('zhaopinhui',$WhereStr.$FormatOptions['where'],$FormatOptions['field']);
    }
	function GetZphPicOnce($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('zhaopinhui_pic',$WhereStr.$FormatOptions['where'],$FormatOptions['field']);
    }
    function AddZhaopinhui($Values=array()){
        return $this->insert_into('zhaopinhui',$Values);
    }
    function AddZphPic($Values=array()){
        return $this->insert_into('zhaopinhui_pic',$Values);
    }
    function UpdateZhaopinhui($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('zhaopinhui',$ValuesStr,$WhereStr);
    }
    function UpdateZphCom($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('zhaopinhui_com',$ValuesStr,$WhereStr);
    }
    function UpdateZphPic($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('zhaopinhui_pic',$ValuesStr,$WhereStr);
    }
    function GetZphComNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('zhaopinhui_com',$WhereStr);
    }
    function DeleteZph($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('zhaopinhui',$WhereStr,"");
    }
    function DeleteZphCom($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('zhaopinhui_com',$WhereStr,"");
    }
    function DeleteZphPic($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('zhaopinhui_pic',$WhereStr,"");
    }
}
?>