<?php
class job_model extends model{
    function GetFinderNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('finder',$WhereStr);
    }
    function GetBlackOne($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('blacklist',$WhereStr,$FormatOptions['field']);
    }
    function GetBlackList($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('blacklist',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function GetComjobOne($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('company_job',$WhereStr,$FormatOptions['field']);
    }
    function GetComjoblinkOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('company_job_link',$WhereStr,$FormatOptions['field']);
    }
    function GetComjobList($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('company_job',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
	function DelJob($jobids){
		$this->DB_delete_all("company_job","`id` in (".$jobids.")","");
		$this->DB_delete_all("company_job_link","`jobid` in (".$jobids.")","");
	}
    function GetComjobNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('company_job',$WhereStr);
    }
    function UpdateComjob($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('company_job',$ValuesStr,$WhereStr);
    }
	function AddCompanyJob($Values=array()){
        return $this->insert_into('company_job',$Values);
    }
    function GetUserJobNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('userid_job',$WhereStr);
    }
    function GetComMsgNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $num=$this->DB_select_num('company_msg',$WhereStr);
		if($num<1){
			$num=0;
		}
		return $num;
    }
    function GetApplyList($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('userid_job',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function GetLookJobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('look_job',$WhereStr,$FormatOptions['field']);
    }
    function AddLookJob($Values=array()){
        return $this->insert_into('look_job',$Values);
    }
    function UpdateLookJob($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('look_job',$ValuesStr,$WhereStr);
    }
    function GetUseridJobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('userid_job',$WhereStr,$FormatOptions['field']);
    }
    function GetUseridJob($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('userid_job',$WhereStr,$FormatOptions['field']);
    }
    function GetUseridMsgOne($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('userid_msg',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function AddUseridJob($Values=array()){
        return $this->insert_into('userid_job',$Values);
    }
    function GetFavJobOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('fav_job',$WhereStr,$FormatOptions['field']);
    }
    function AddFavJob($Values=array()){
        return $this->insert_into('fav_job',$Values);
    }
    function AddCompanyShow($Values=array()){
        return $this->insert_into('company_show',$Values);
    }
    function AddMsg($Values=array()){
        return $this->insert_into('msg',$Values);
    }
}
?>