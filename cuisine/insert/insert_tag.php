<?php
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/standard_php_header.php");
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/decode.php");

	$tmp = trim(urldecode($_POST['tag']));

	if($tmp != '') {

		$mysqli = new mysqli('localhost', 'root', '', 'mydb');
		if ($mysqli->connect_errno) {
			exit;
		}
		mysqli_set_charset($mysqli, "utf8");

		//$formattedStr = mysqli_real_escape_string( $mysqli, ucfirst(strtolower($_POST['tag'])));
		$formattedStr = ucfirst_aio_wrap($_POST['tag'], $mysqli);

		$sql = "SELECT t.nom FROM tag t WHERE t.nom='$formattedStr'";
		if (!$result = $mysqli->query($sql))
		{
	 		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}

		if($get_info = $result->fetch_row()) {
			exit;
		}

		$insert = "INSERT INTO tag(nom) VALUES ('$formattedStr')";
		if (!$result = $mysqli->query($insert)) {
	 		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
	 		exit;
		}

		$fetch = "SELECT * FROM tag ORDER BY tag.idT DESC";
		if (!$result = $mysqli->query($fetch)) {
	 		exit;
		}
		$get_info = $result->fetch_row();

		echo $get_info[0]."||".$get_info[1];
	}
?>