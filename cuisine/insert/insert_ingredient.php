<?php
	session_start();

	if($_POST['nom_ingredient'] != '') {
		$mysqli = new mysqli('localhost', 'root', '', 'mydb');

		if ($mysqli->connect_errno)
		{
	 		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
			exit;
		}

		mysqli_set_charset($mysqli, "utf8");


		$sql = 'SELECT DISTINCT i.nom FROM ingredient i WHERE i.nom=\''.$_POST['nom_ingredient'].'\'';
		if (!$result = $mysqli->query($sql))
		{
	 		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
		if($get_info = $result->fetch_row()) {
			echo "Allready inserted";
			exit;
		}


		if($_POST['image_ingredient'] != '') {
			$query = 'INSERT INTO ingredient(nom, photo) VALUES (\''.$_POST['nom_ingredient'].'\',\''.$_POST['image_ingredient'].'\')';
		} else {
			$query = 'INSERT INTO ingredient(nom) VALUES (\''.$_POST['nom_ingredient'].'\')';
		}


		if (!$result = $mysqli->query($query))
		{
	 		echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
	}
?>