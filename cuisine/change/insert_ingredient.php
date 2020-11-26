<?php
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/standard_php_header.php");
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/decode.php");

	//echo $_POST['nom_ingredient'];
	//echo $_POST['image_ingredient'];

	$tmp = trim(urldecode($_POST['nom_ingredient']))

	if($tmp != '') {
		$mysqli = new mysqli('localhost', 'root', '', 'mydb');

		if ($mysqli->connect_errno)
		{
	 		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
			exit;
		}

		mysqli_set_charset($mysqli, "utf8");

		//$nom_ingredient = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['nom_ingredient']))));
		//$image_ingredient = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['image_ingredient']))));

		$nom_ingredient = ucfirst_aio_wrap($_POST['nom_ingredient'], $mysqli);
		$image_ingredient = ucfirst_aio_wrap($_POST['image_ingredient'], $mysqli);
		

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

		$fetch = "SELECT i.idI FROM ingredient i WHERE i.nom = '$nom_ingredient' ORDER BY i.idI DESC";
		if (!$result = $mysqli->query($fetch))
		{
	 		echo "SELECT error in query " . $fetch . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
		$get_info = $result->fetch_row();
		echo $get_info[0];
	}
?>