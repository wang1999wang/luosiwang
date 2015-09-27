<?php
class redeem_model extends model
{
    function GetRewardClass($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('reward_class',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function GetRewardOne($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_once('reward',$WhereStr,$FormatOptions['field']);
    }
    function GetReward($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('reward',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function GetChange($Where=array(),$Options=array()){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);
        return $this->DB_select_all('change',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
    }
    function AddChange($Values=array()){
        return $this->insert_into('change',$Values);
    }
    function UpdateReward($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('reward',$ValuesStr,$WhereStr);
    }

    function DeleteOncejob($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_delete_all('once_job',$WhereStr);
    }

    function GetOncejobNum($Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        return $this->DB_select_num('once_job',$WhereStr);
    }
}
?>