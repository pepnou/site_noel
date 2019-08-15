<?php
	$mysqli = new mysqli('localhost', 'root', '', 'mydb');

	if ($mysqli->connect_errno) {
		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
		exit;
	}

	mysqli_set_charset($mysqli, "utf8");

	$sql = 'SELECT * FROM user u WHERE u.email LIKE \''.$_POST['email'].'\'';

	if (!$result = $mysqli->query($sql)) {
		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
		exit;
	}

	if ($get_info = $result->fetch_row()) {
		?>
			<p>L'email est déja utilisé</p>
			<form method="POST" action="">
				<input type="text" name="nom" placeholder="Nom" required maxlength="25" value="<?php echo $_POST['nom']; ?>">
				<input type="text" name="prenom" placeholder="Prenom" required maxlength="25" value="<?php echo $_POST['prenom']; ?>">
				<input type="text" name="email" placeholder="Email" required value="<?php echo $_POST['email']; ?>">
				<input type="password" name="mdp" placeholder="Mot de passe" required value="<?php echo $_POST['mdp']; ?>">
				<input type="submit" name="co" value="Valider">
			</form>
		<?php
		$result->free();
	} else {
		$result->free();
		$sql2 = 'INSERT INTO user(nom,prenom,email,mdp) VALUES (\'' . $_POST['nom'] . '\',\'' . $_POST['prenom'] . '\',\'' . $_POST['email'] . '\',\'' . password_hash($_POST['mdp'], PASSWORD_DEFAULT) . '\')';

		if (!$result = $mysqli->query($sql2)) {
			echo "SELECT error in query " . $sql2 . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
			exit;
		}

		if (!$result = $mysqli->query($sql)) {
			echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
			exit;
		}

		$get_info = $result->fetch_row();

		$_SESSION['id'] = $get_info[0];

		$result->free();

		echo "<p>Bienvenue $get_info[1] $get_info[2], <br>Vous etes maintenant inscrit et connecté.<br>Vous pourrez acceder au contenue du site quand votre status sera mis a jour par l'administrateur.<br>N'hésiter pas à le contacter.</p>";

		echo "<p>A bientot sur le site!</p>";

		echo "<p><br><br><a href=\"../../../Acceuil/Presentation/presentation.php\"><Acceuil/a></p>";
	}
?>