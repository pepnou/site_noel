<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	setlocale(LC_ALL,'fr_FR@euro', 'fr_FR', 'fr', 'FR');

	if(!isset($_SESSION['id']))
	{
		include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/user_connection/connection/connection.php");
		exit();
	}
?>