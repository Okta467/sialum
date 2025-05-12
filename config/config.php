<?php 
	function base_url($path = 'index.php') {
		echo "/sialum/" . $path;
	}

	function base_url_return($path = 'index.php') {
		return "/sialum/" . $path;
	}

    date_default_timezone_set("Asia/Bangkok");
	
	DEFINE("SITE_NAME", "SMK Madyatama Palembang");
	DEFINE("SITE_NAME_SHORT", "SIALUM");
?>