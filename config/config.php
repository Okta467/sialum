<?php 
	function base_url($path = 'index.php') {
		echo "/si_seleksi_lomba/" . $path;
	}

	function base_url_return($path = 'index.php') {
		return "/si_seleksi_lomba/" . $path;
	}

    date_default_timezone_set("Asia/Bangkok");
	
	DEFINE("SITE_NAME", "SI Seleksi Pendaftaran Lomba Pendaftaran LKS");
	DEFINE("SITE_NAME_SHORT", "SIDALOM");
?>