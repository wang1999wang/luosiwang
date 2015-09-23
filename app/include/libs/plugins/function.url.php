<?php
function smarty_function_url($paramer,$template){
	global $config,$seo;
    $index=$paramer['index'];
     unset($paramer['index']);
     $url  =  get_url($paramer,$config,$seo,$paramer['m'],$index,$template);
	return $url;
}
?>