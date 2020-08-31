<?php
	require_once "./core/configSite.php";
	require_once "./controllers/viewsController.php";

	// set_time_limit(5000);
	// ini_set("memory_limit" , "5000M");

	$ViewTemplate=new viewsController();
	$ViewTemplate->getTemplate();

?>