<?php
	setlocale(LC_ALL,'fr_FR@euro', 'fr_FR', 'fr', 'FR');

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
		$sql = "SELECT * FROM ingredient i WHERE i.nom LIKE '%$tmp%' ORDER BY i.nom ASC";
		
		$result = $mysqli->query($sql);

		$id = array();
		$nom = array();
		$image = array();

		while (($get_info = $result->fetch_row()) && count($id)<50)
		{
			array_push($id, $get_info[0]);
			array_push($nom, $get_info[1]);
			if($get_info[2])
				array_push($image, $get_info[2]);
			else
				array_push($image, 'NULL');
		}

		$result->free();
		$mysqli->close();

		echo implode('|', $id).'||'.implode('|', $nom).'||'.implode('|', $image);
	}
?>