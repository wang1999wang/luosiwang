<?php
class evaluate_model extends model{ 
	function GetExamList($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){ 
		$WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_all('evaluate_group',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	} 
	function GetExamBaseInfo($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
		$FormatOptions=$this->FormatOptions($Options);
		return $this->DB_select_once('evaluate_group',$WhereStr,$FormatOptions['field']);
	}
	function GetQuestions($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		return $this->DB_select_all('evaluate',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);	
	}
	function UpdateExamBaseInfo($Values=array(),$Where=array()){
        $WhereStr=$this->FormatWhere($Where);
        $ValuesStr=$this->FormatValues($Values);
        return $this->DB_update_all('evaluate_group',$ValuesStr,$WhereStr);
	}
	function GetGradeOne($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		return $this->DB_select_once('evaluate_log',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);	
	}
	function GetGrade($Where=array(),$Options=array()){
		$WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
		$rows=$this->DB_select_all('evaluate_log',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);	
		$uid=array();
		foreach($rows as $key=>$val){
			$uid[]=$val['uid'];
			$rows[$key]['pic']=$this->config['sy_weburl'].'/'.$this->config['sy_friend_icon'];
		}  
		$info=$this->DB_select_all("friend_info","`uid` in(".pylode(',',$uid).")","`uid`,`pic`,`nickname`");
		foreach($rows as $key=>$val){
			foreach($info as $v){
				if($val['uid']==$v['uid']&&$v['pic']){
					$rows[$key]['pic']=$v['pic'];
					$rows[$key]['nickname']=$v['nickname']; 
				}
			}
		} 
		return $rows;
	}
	function SaveGrade($Values=array(),$Where=array()){ 
		$ValuesStr=$this->FormatValues($Values); 
		if($Where){
			$WhereStr=$this->FormatWhere($Where);
			return $this->DB_update_all('evaluate_log',$ValuesStr,$WhereStr);
		}else{ 
			return $this->insert_into('evaluate_log',$Values);
		}
	}
	
	function SaveMessage($Values=array()){ 
		$nid=$this->insert_into('evaluate_leave_message',$Values);
		if($nid&&$Values['examid']){
			$this->DB_update_all("evaluate_group","`comnum`=`comnum`+'1'","`id`='".$Values['examid']."'");
		}
		return $nid;
	}
	function GetGradeRank($Where){
		return $this->DB_select_num('evaluate_log',$Where);
	}
	function SaveLeaveMessage($Values){ 
		$ValuesStr=$this->FormatValues($Values); 
		return $this->DB_insert_once('evaluate_leave_message',$ValuesStr);
	} 
	function GetLeaveMessageList($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options);  
		$rows=$this->DB_select_all('evaluate_leave_message',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	    $uid=array();
		foreach($rows as $key=>$val){
			$uid[]=$val['uid'];
			$rows[$key]['pic']=$this->config['sy_weburl'].'/'.$this->config['sy_friend_icon'];
		}
		
		$info=$this->DB_select_all("friend_info","`uid` in(".pylode(',',$uid).")","`uid`,`pic`,`name`");
		foreach($rows as $key=>$val){
			foreach($info as $v){
				if($val['uid']==$v['uid']){
					$rows[$key]['pic']=$v['pic'];
					$rows[$key]['name']=$v['name'];
				}
			}
		}
		return $rows;
	} 
	function GetUserBaseInfo($Where=array(),$Options=array('field'=>null,'orderby'=>null,'groupby'=>null,'limit'=>null)){
        $WhereStr=$this->FormatWhere($Where);
        $FormatOptions=$this->FormatOptions($Options); 
        return $this->DB_select_once('resume',$WhereStr.$FormatOptions['order'],$FormatOptions['field']);
	} 
}
?>