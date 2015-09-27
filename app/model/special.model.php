<?php
class special_model extends model{
	function GetSpecialAll($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('special',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
	
	function GetSpecialResume($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
        $rows=$this->DB_select_all('special_com',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
		$uid=array();
		foreach($rows as $val){
			$uid[]=$val['uid'];
		}
		$time=strtotime(date("Y-m-d 00:00:00")); 
		$result['num']=$this->DB_select_num("userid_job","`com_id` in(".@implode(',',$uid).") and `datetime`>'".$time."'"); 
		$result['list']=$this->DB_select_all("userid_job","`com_id` in(".@implode(',',$uid).") and `datetime`>'".$time."' order by `id` desc limit 5");
		return $result;
    } 
	function GetSpecial($Where=array(),$Options=array()){  
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('special',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }	
	function UpdateSpecial($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('company_job',$ValuesStr,$WhereStr);
    }
	function GetComNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('special_com',$WhereStr);
    }
	function AddSpecialCom($Values=array()){ 
        return $this->insert_into('special_com',$Values);
    }
}
?>