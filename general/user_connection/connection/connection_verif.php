<?php
	$mysqli = new mysqli('localhost', 'root', '', 'mydb');

	if ($mysqli->connect_errno)
	{
		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
		exit;
	}

	mysqli_set_charset($mysqli, "utf8");

	$sql = 'SELECT * FROM user u WHERE u.email LIKE \''.$_POST['email'].'\'';

	if (!$result = $mysqli->query($sql))
	{
		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
		exit;
	}

	if (!$get_info = $result->fetch_row())
	{
		?>
			<p>L'email est incorrect ou n'existe pas</p>
			<form method="POST" action="">
				<input type="text" name="email" placeholder="Email" required value="<?php echo $_POST['email']; ?>">
				<input type="password" name="mdp" placeholder="Mot de passe" required value="<?php echo $_POST['mdp']; ?>">
				<input type="submit" name="co" value="Valider">
			</form>
		<?php
		$result->free();
	}
	else if(!password_verify($_POST['mdp'], $get_info[4]))
	{
		?>
			<p>Le mot de passe est incorrect</p>
			<form method="POST" action="">
				<input type="text" name="email" placeholder="Email" required value="<?php echo $_POST['email']; ?>">
				<input type="password" name="mdp" placeholder="Mot de passe" required value="<?php echo $_POST['mdp']; ?>">
				<input type="submit" name="co" value="Valider">
			</form>
		<?php
		$result->free();
	}
	else
	{
		$_SESSION['id'] = $get_info[0];
		$result->free();
		?>
			<script type="text/javascript">
				//window.location.replace('.');
				location.reload(/*true*/);
			</script>
		<?php
	}
?>