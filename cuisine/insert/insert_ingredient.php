<?php
	session_start();

	//echo $_POST['nom_ingredient'];
	//echo $_POST['image_ingredient'];

	if($_POST['nom_ingredient'] != '') {
		$mysqli = new mysqli('localhost', 'root', '', 'mydb');

		if ($mysqli->connect_errno)
		{
	 		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
			exit;
		}

		mysqli_set_charset($mysqli, "utf8");

		$nom_ingredient = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['nom_ingredient']))));
		$image_ingredient = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['image_ingredient']))));

		$sql = 'SELECT DISTINCT i.nom FROM ingredient i WHERE i.nom=\''.$nom_ingredient.'\'';
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
			$query = 'INSERT INTO ingredient(nom, photo) VALUES (\''.$nom_ingredient.'\',\''.$image_ingredient.'\')';
		} else {
			$query = 'INSERT INTO ingredient(nom) VALUES (\''.$nom_ingredient.'\')';
		}


		if (!$result = $mysqli->query($query))
		{
	 		echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
	}
?>