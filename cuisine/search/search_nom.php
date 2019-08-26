<?php
	$tmp = urldecode($_GET['s']);

	if($tmp == '' || $tmp == ' ')
		echo '';
	else
	{
		$mysqli = new mysqli('localhost', 'root', '', 'mydb');

		if ($mysqli->connect_errno)
		{
	 		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
			exit;
		}

		mysqli_set_charset($mysqli, "utf8");

		$tmp = mysqli_real_escape_string( $mysqli, ucfirst(strtolower($_GET['s'])));
		$sql = "SELECT r.nom FROM recette r WHERE r.nom LIKE '%$tmp%'";
		
		$result = $mysqli->query($sql);

		$tab = array();

		while (($get_info = $result->fetch_row()) && count($tab)<50)
			array_push($tab, $get_info[0]);

		$result->free();
		$mysqli->close();

		echo implode('|', $tab);
	}
?>