<?php
class subscribe_model extends model{
    function GetSubscribeOnce($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('subscribe',$WhereStr,$FormatOptions['field']);
    }
    function UpdateSubscribe($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('resume_tiny',$ValuesStr,$WhereStr);
    }
    function AddSubscribe($Values=array()){
        return $this->insert_into('resume_tiny',$Values);
    }
}
?>