<?php
	session_start();
	setlocale(LC_ALL,'fr_FR@euro', 'fr_FR', 'fr', 'FR');

	$mysqli = new mysqli('localhost', 'root', '', 'mydb');

	if ($mysqli->connect_errno)
	{
 		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
		exit;
	}

	mysqli_set_charset($mysqli, "utf8");

	if($_POST['favori'] == '1') {
		$sql='INSERT INTO `favori` (`idU`, `idR`) VALUES ('.$_SESSION['id'].', '.$_POST['recette'].');';
	} else {
		$sql='DELETE FROM `favori` WHERE `favori`.`idU` = '.$_SESSION['id'].' AND `favori`.`idR` = '.$_POST['recette'];
	}
	
	$mysqli->query($sql);
?>