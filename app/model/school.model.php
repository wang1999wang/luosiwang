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
class school_model extends model{
	function GetSchoolBaseOnce($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_once("school_base",$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	}
	function GetSchoolContentOnce($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_once("school_content",$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	}
	function GetSchoolGroupOnce($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_once("school_group",$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	}
	function GetSchoolGroupList($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_all("school_group",$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	}
	function GetSchoolBaseList($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_all("school_base",$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	}
    function AddSchoolHits($Where=array()){
		$ID=(int)$Where['id'];
		if(!is_numeric($ID)){
			return null;
		}
        return $this->DB_update_all('school_base',"`hits`=`hits`+'1'","`id`='".$ID."'");
    }
    function GetSchoolNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('school_base',$WhereStr);
    }
    function GetProperty($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('property',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function UpdateSchool($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('school_base',$ValuesStr,$WhereStr);
    }
    function UpdateSchoolContent($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('school_content',$ValuesStr,$WhereStr);
    }
    function AddSchool($Values=array()){
        return $this->insert_into('school_base',$Values);
    }
    function AddSchoolContent($Values=array()){
        return $this->insert_into('school_content',$Values);
    }
    function DeleteSchool($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('school_base',$WhereStr,"");
    }
    function DeleteSchoolContent($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('school_content',$WhereStr,"");
    }
}
?>