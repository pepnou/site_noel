<?php
	session_start();

	$mysqli = new mysqli('localhost', 'root', '', 'mydb');
	if ($mysqli->connect_errno) {
		exit;
	}
	mysqli_set_charset($mysqli, "utf8");

	$nom = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['nom']))));
	$quantite = $_POST['quantite'];
	$unite = $_POST['unite'];
	$temps_prep = $_POST['temps_prep'];
	$temps_cuis = $_POST['temps_cuis'];
	$pays = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['pays']))));
	$source = mysqli_real_escape_string( $mysqli, ucfirst(strtolower(urldecode($_POST['source']))));
	$facilite = $_POST['facilite'];
	$cout = $_POST['cout'];
	$id = $_SESSION['id'];


	$insert_recipe = "INSERT INTO recette(nom, tempsCuisson, tempsPrep, quantite, uniteQ, source, pays, cout, facilite, idU) VALUES ('$nom', '$temps_cuis', '$temps_prep', '$quantite', '$unite', '$source', '$pays', '$cout', '$facilite', '$id')";

	if (!$result = $mysqli->query($insert_recipe)) {
 		exit;
	}

	$fetch = "SELECT r.idR FROM recette r ORDER BY r.idR DESC";
	if (!$result = $mysqli->query($fetch)) {
 		exit;
	}
	$get_info = $result->fetch_row();
	$idR = $get_info[0];



	/*
	'nom=' + nom.value + 
	'&quantite=' + quantite.value + 
	'&unite=' + unite.value + 
	'&temps_prep=' + temps_prep.value +
	'&temps_cuis=' + temps_cuis.value +
	'&saison=' + saison +						<--
	'&pays=' + pays.value +
	'&source=' + source.value + 
	'&facilite=' + facilite.value +
	'&cout=' + cout.value +
	'&ids_ing=' + ids_ing.value +				<--
	'&ids_tags=' + ids_tags.value +				<--
	'&photos=' + photos_array +					<--
	'&steps=' + steps_array;					<--
	*/
	echo $idR;
?>