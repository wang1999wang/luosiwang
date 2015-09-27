<?php
class hr_model extends model{
    function GetToolboxClassOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('toolbox_class',$WhereStr,$FormatOptions['field']);
    }
    function GetToolboxDocOne($Where=array(),$Options=array('field'=>null)){
        $WhereStr='';
        $WhereStr.=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('toolbox_doc',$WhereStr,$FormatOptions['field']);
    }
    function UpdateToolboxDoc($Values=array(),$Where=array()){
        $WhereStr='';
        $WhereStr.=$this->FormatWhere($Where);
        $ValuesStr.=$this->FormatValues($Values);
        return $this->DB_update_all('toolbox_doc',$ValuesStr,$WhereStr);
    }
}
?>