<?php
class index_model extends model{
    function GetAdOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('ad',$WhereStr,$FormatOptions['field']);
    }
    function GetAdclickNum($Where){
        return $this->DB_select_num('adclick',$Where);
    }
    function InsertAdclick($Values=array()){
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_insert_once('adclick',$ValuesStr);
    }
	function AddAdHits($id){
		$this->DB_update_all("ad","`hits`=`hits`+1","`id`='".$id."'");
	}
    function GetDescOne($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_once('description',$WhereStr);
    }
}
?>