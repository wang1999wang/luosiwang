<?php
		$files=$_FILES['fileToUpload'];
		move_uploaded_file($files['tmp_name'],"../../data/web_img/water.png");
		echo "{";
		echo		"url: 'dddddd',\n";
		echo		"s_thumb: 'dddddddddd'\n";
		echo "}";

?>