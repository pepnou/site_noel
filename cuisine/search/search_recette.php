<?php
	session_start();

	/*$tmp = urldecode($_GET['s']);
	
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

		$tmp = $_GET['s'];
		$sql = "SELECT * FROM ingredient i WHERE i.nom LIKE '%$tmp%'";
		
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
	}*/
	//echo $_POST['nom'].'||'.$_POST['favori'].'||'.$_POST['saison'].'||'.$_POST['facilite'].'||'.$_POST['cout'].'||'.$_POST['temps_prep'].'||'.$_POST['ingredient'].'||'.$_POST['tag'].'||'.$_POST['video'];

	/*$sql_sub_querry = [];
	if($_POST['ingredient'] != '')
		$sql_sub_querry[] =  '( SELECT r.nom
								FROM recette r, contient c
								WHERE r.idR = c.idR AND (c.idI = '.implode(' OR c.idI = ', explode('|', $_POST['ingredient'])).')
								GROUP BY r.idR
								HAVING COUNT(DISTINCT c.idI) = '.count(explode('|', $_POST['ingredient'])).') AS filtre_ing fi';

	if($_POST['tag'] != '')
		//$tag = 't.idT = '.implode(' OR t.idT = ', explode('|', $_POST['tag']));
		$sql_sub_querry[] =  '( SELECT r.nom
								FROM recette r, tague t
								WHERE r.idR = t.idR AND (t.idI = '.implode(' OR t.idI = ', explode('|', $_POST['tag'])).')
								GROUP BY r.idR
								HAVING COUNT(DISTINCT t.idI) = '.count(explode('|', $_POST['tag'])).') AS filtre_tag ft';

	if(count($sql_sub_querry) != 0)
		$sql_from_part = ' , '.implode(' , ', $sql_sub_querry);*/


	$mysqli = new mysqli('localhost', 'root', '', 'mydb');

	if ($mysqli->connect_errno)
	{
 		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
		exit;
	}

	mysqli_set_charset($mysqli, "utf8");


	$sql_cond = array();

	if($_POST['nom'] != '')
		$sql_cond[] = ' ( r.nom LIKE \'%'.$_POST['nom'].'%\' ) ';

	if($_POST['favori'] == 'true')
		$sql_cond[] = ' ( r.idR = f.idR AND f.idU = 1 ) ';//$sql_cond[] = ' ( r.idR = f.idR AND f.idU = '.$_SESSION['id'].' ) ';

	if($_POST['saison'] != '')
		$sql_cond[] = ' ( r.idR = s.idR AND ( s.idS = '.implode(' OR s.idS = ', explode('|', $_POST['saison'])).' )) ';

	if($_POST['type'] != -1)
		$sql_cond[] = ' ( r.type = \''.$_POST['type'].'\' ) ';

	if($_POST['utilisateur'] != -1)
		$sql_cond[] = ' ( r.idU = '.$_POST['utilisateur'].' ) ';

	if($_POST['pays'] != -1)
		$sql_cond[] = ' ( r.pays = \''.$_POST['pays'].'\' ) ';

	if($_POST['facilite'] != -1)
		$sql_cond[] = ' ( r.facilite <= '.$_POST['facilite'].' ) ';

	if($_POST['cout'] != -1)
		$sql_cond[] = ' ( r.cout <= '.$_POST['cout'].' ) ';

	if($_POST['temps_prep'] != -1)
	{
		$temps_prep = sprintf("%'.02d",intdiv($_POST['temps_prep'], 60)).':'.sprintf("%'.02d",$_POST['temps_prep']%60).':00';
		$sql_cond[] = ' ( ADDTIME(r.tempsPrep, r.tempsCuisson) <= \''.$temps_prep.'\' ) ';
	}

	if($_POST['ingredient'] != '')
		$sql_cond[] = '( r.nom = (SELECT r2.nom
						FROM recette r2, contient c
						WHERE r2.nom = r.nom AND r2.idR = c.idR AND (c.idI = '.implode(' OR c.idI = ', explode('|', $_POST['ingredient'])).')
						GROUP BY r2.idR
						HAVING COUNT(DISTINCT c.idI) = '.count(explode('|', $_POST['ingredient'])).'))';

	if($_POST['tag'] != '')
		$sql_cond[] = '( r.nom = (SELECT r2.nom
						FROM recette r2, tague t
						WHERE r2.nom = r.nom AND r2.idR = t.idR AND (t.idT = '.implode(' OR t.idT = ', explode('|', $_POST['tag'])).')
						GROUP BY r2.idR
						HAVING COUNT(DISTINCT t.idT) = '.count(explode('|', $_POST['tag'])).'))';

	if($_POST['video'] == 'true')
		$sql_cond[] = ' ( r.video IS NOT NULL ) ';


	$sql_where_part = '';
	if(count($sql_cond) > 0)
		$sql_where_part = ' WHERE '.implode(' AND ', $sql_cond);


	$sql = "SELECT DISTINCT r.idR, r.nom
			FROM recette r, favori f, se_prepare_en s
			$sql_where_part";

	//echo $sql;



	$result = $mysqli->query($sql);

	$id = array();
	$nom = array();
	$image = array();

	while (($get_info = $result->fetch_row()) && count($id)<50)
	{
		array_push($id, $get_info[0]);
		array_push($nom, $get_info[1]);


		$sql2 =    'SELECT p.url
					FROM recette r, photo p
					WHERE r.idR = p.idR AND r.idR = '.$get_info[0];

		$result2 = $mysqli->query($sql2);

		if($get_info2 = $result2->fetch_row())
			array_push($image, $get_info2[0]);
		else
			array_push($image, 'NULL');

		$result2->free();
	}

	$result->free();
	$mysqli->close();

	if(count($id)>0)
		echo implode('|', $id).'||'.implode('|', $nom).'||'.implode('|', $image);
	else
		echo '';

	//echo $sql;

?>