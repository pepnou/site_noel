<?php
	session_start();
	setlocale(LC_ALL, 'fr_FR@euro', 'fr_FR', 'fr', 'FR');
	header('Content-Type: text/html; charset=utf-8');

	$mysqli = new mysqli('localhost', 'root', '', 'mydb');
	if ($mysqli->connect_errno) {
		exit;
	}
	mysqli_set_charset($mysqli, "utf8");


	function my_mb_ucfirst($str) {
		echo mb_convert_case(mb_substr($str, 0, 1, "UTF-8"), MB_CASE_UPPER, "UTF-8")."\n";
		echo mb_convert_case(mb_substr($str, 1, NULL, "UTF-8"), MB_CASE_LOWER, "UTF-8")."\n";

		$fc = mb_convert_case(mb_substr($str, 0, 1, "UTF-8"), MB_CASE_UPPER, "UTF-8").mb_convert_case(mb_substr($str, 1, NULL, "UTF-8"), MB_CASE_LOWER, "UTF-8");
		return $fc;
	}

	function my_decode($str) {
		return mysqli_real_escape_string( $mysqli, my_mb_ucfirst(urldecode($str)));
	}


	$idr = $_POST['id'];
	//$nom = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['nom']))));
	$nom = my_decode($_POST['nom']);
	$quantite = $_POST['quantite'];
	$unite = $_POST['unite'];
	$temps_prep = $_POST['temps_prep'];
	$temps_cuis = $_POST['temps_cuis'];
	//$pays = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['pays']))));
	$pays = my_decode($_POST['pays']);
	//$source = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['source']))));
	$source = my_decode($_POST['source']);
	$facilite = $_POST['facilite'];
	$cout = $_POST['cout'];
	$id = $_SESSION['id'];


	//$insert_recipe = "INSERT INTO recette(nom, tempsCuisson, tempsPrep, quantite, uniteQ, source, pays, cout, facilite, idU) VALUES ('$nom', '$temps_cuis', '$temps_prep', '$quantite', '$unite', '$source', '$pays', '$cout', '$facilite', '$id')";
	$change_recipe = "UPDATE recette SET nom = '$nom', tempsCuisson = '$temps_cuis', tempsPrep = '$temps_prep', quantite = '$quantite', uniteQ = '$unite', source = '$source', pays = '$pays', cout = '$cout', facilite = '$facilite', idU = '$id' WHERE idR = $idr";

	/*$yolo = $_POST['nom'];
	echo $yolo."\n";
	$yolo = urldecode($yolo);
	echo $yolo."\n";
	$yolo = my_mb_ucfirst($yolo);
	echo $yolo."\n";
	$yolo = mysqli_real_escape_string( $mysqli, $yolo);
	echo $yolo."\n\n";*/


	//echo $_POST['nom']."\n";
	//echo urldecode($_POST['nom'])."\n";
	//echo strtolower(urldecode($_POST['nom']))."\n";
	//echo ucfirst(strtolower(urldecode($_POST['nom'])))."\n";
	//echo mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['nom']))))."\n\n";

	//echo mb_convert_case(urldecode($_POST['nom']), MB_CASE_UPPER, "UTF-8")."\n";

	echo $idr."\n";
	echo $nom."\n";
	echo $temps_cuis."\n";
	echo $temps_prep."\n";
	echo $quantite."\n";
	echo $unite."\n";
	echo $unite."\n";
	echo $source."\n";
	echo $pays."\n";
	echo $cout."\n";
	echo $facilite."\n";
	echo $id."\n";

	if (!$result = $mysqli->query($change_recipe)) {
		echo "SELECT error in query:\n " . $change_recipe . " \n errno: " . $mysqli->errno . " \n error: " . $mysqli->error;
 		exit;
	}

	/*$fetch = "SELECT r.idR FROM recette r ORDER BY r.idR DESC";
	if (!$result = $mysqli->query($fetch)) {
		echo "SELECT error in query " . $fetch . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
 		exit;
	}
	$get_info = $result->fetch_row();
	$idR = $get_info[0];



	$saison = explode("|", $_POST['saison']);
	if($saison[0] > 0) {
		$saison_sql = "INSERT INTO se_prepare_en(idR, idS) VALUES ";
		for ($i=1; $i < count($saison); $i++) {
			$idS = $saison[$i];
			if($i == 1) {
				$saison_sql .= "('$idR', '$idS')";
			} else {
				$saison_sql .= ", ('$idR', '$idS')";
			}
		}

		if (!$result = $mysqli->query($saison_sql)) {
			echo "SELECT error in query " . $saison_sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
	}


	$ingredients = explode("|", $_POST['ingredients']);
	if($ingredients[0] > 0) {
		$ingredients_sql = "INSERT INTO contient(idI, idR, quantite, unite, category) VALUES";
		for ($i=1; $i < count($ingredients); $i += 4) {
			$idI = $ingredients[$i];
			$quantite = $ingredients[$i + 1];
			$unite = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($ingredients[$i + 2]))));
			$category = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($ingredients[$i + 3]))));
			if($i == 1) {
				$ingredients_sql .= "('$idI', '$idR', '$quantite', '$unite', '$category')";
			} else {
				$ingredients_sql .= ", ('$idI', '$idR', '$quantite', '$unite', '$category')";
			}
		}

		if (!$result = $mysqli->query($ingredients_sql)) {
			echo "SELECT error in query " . $ingredients_sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
	}



	$tags = explode("|", $_POST['ids_tags']);
	if($tags[0] > 0) {
		$tags_sql = "INSERT INTO tague(idR, idT) VALUES ";
		for ($i=1; $i < count($tags); $i++) {
			$idT = $tags[$i];
			if($i == 1) {
				$tags_sql .= "('$idR', '$idT')";
			} else {
				$tags_sql .= ", ('$idR', '$idT')";
			}
		}

		if (!$result = $mysqli->query($tags_sql)) {
			echo "SELECT error in query " . $tags_sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
	}


	$photos = explode("|", $_POST['photos']);
	if($photos[0] > 0) {
		$photos_sql = "INSERT INTO photo(url, idR) VALUES ";
		for ($i=1; $i < count($photos); $i++) {
			$url = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($photos[$i]))));
			if($i == 1) {
				$photos_sql .= "('$url', '$idR')";
			} else {
				$photos_sql .= ", ('$url', '$idR')";
			}
		}

		if (!$result = $mysqli->query($photos_sql)) {
			echo "SELECT error in query " . $photos_sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
	}

	$steps = explode("|", $_POST['steps']);
	if($steps[0] > 0) {
		$steps_sql = "INSERT INTO etape(photo, contenu, idR) VALUES ";
		for ($i=1; $i < count($steps); $i += 2) {
			$contenu = mysqli_real_escape_string( $mysqli, urldecode($steps[$i]));
			$photo = mysqli_real_escape_string( $mysqli, urldecode($steps[$i + 1]));
			if($i == 1) {
				$steps_sql .= "('$photo', '$contenu', '$idR')";
			} else {
				$steps_sql .= ", ('$photo', '$contenu', '$idR')";
			}
		}

		if (!$result = $mysqli->query($steps_sql)) {
			echo "SELECT error in query " . $steps_sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}
	}

	echo $idR;*/
?>