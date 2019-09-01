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
		//$sql = "SELECT * FROM ingredient i WHERE i.nom LIKE '%$tmp%' ORDER BY i.nom ASC";

		$sql = "SELECT i4.idI, i4.nom, i4.photo
				FROM
				(
				        SELECT i1.idI, i1.nom, i1.photo, 1 AS place
				        FROM ingredient i1
				        WHERE i1.nom LIKE '$tmp%'
				    UNION
				        SELECT i2.idI, i2.nom, i2.photo , 2 AS place
				        FROM ingredient i2
				        WHERE (i2.nom LIKE '% $tmp%') OR (i2.nom LIKE '%-$tmp%') OR (i2.nom LIKE '%\'$tmp%')
				    UNION
				        SELECT i3.idI, i3.nom, i3.photo , 3 AS place
				        FROM ingredient i3
				        WHERE (i3.nom LIKE '%$tmp%') AND i3.idI NOT IN
				        (
				            SELECT ingredient.idI
				            FROM ingredient
				            WHERE (ingredient.nom LIKE '% $tmp%') OR (ingredient.nom LIKE '%-$tmp%') OR (ingredient.nom LIKE '%\'$tmp%') OR (ingredient.nom LIKE '$tmp%')
				        )
				) AS i4
				ORDER BY i4.place ASC, i4.nom ASC";
		
		$result = $mysqli->query($sql);

		$id = array();
		$nom = array();
		$image = array();

		while (($get_info = $result->fetch_row()) && count($id)<10)
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