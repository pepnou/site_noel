<?php
	session_start();

	if(!isset($_SESSION['id']) && (!isset($_POST['email']) || !isset($_POST['mdp'])))
	{
		?>
			<!DOCTYPE html>
			<html>
				<head>
					<title>Connection</title>
					<link rel="stylesheet" type="text/css" href="../../general/gen_style.css">
				</head>

				<body>
					<form method="POST" action="">
						<input type="text" name="email" placeholder="Email" required>
						<input type="password" name="mdp" placeholder="Mot de passe" required>
						<input type="submit" name="co" value="Valider">
					</form>
				</body>
			</html>
		<?php
	}
	else if(!isset($_SESSION['id']))
	{
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
				<!DOCTYPE html>
				<html>
					<head>
						<title>Connection</title>
						<link rel="stylesheet" type="text/css" href="../../general/gen_style.css">
						<script type="text/javascript" src="../../general/connection.js"></script>
					</head>

					<body>
						<p>L'email est incorrect ou n'existe pas</p>
						<form method="POST" action="">
							<input type="text" name="email" placeholder="Email" required value="<?php echo $_POST['email']; ?>">
							<input type="password" name="mdp" placeholder="Mot de passe" required value="<?php echo $_POST['mdp']; ?>">
							<input type="submit" name="co" value="Valider">
						</form>
					</body>
				</html>
			<?php
			$result->free();
		}
		else if(!password_verify($_POST['mdp'], $get_info[4]))
		{
			?>
				<!DOCTYPE html>
				<html>
					<head>
						<title>Connection</title>
						<link rel="stylesheet" type="text/css" href="../../general/gen_style.css">
						<script type="text/javascript" src="../../general/connection.js"></script>
					</head>

					<body>
						<p>Le mot de passe est incorrect</p>
						<form method="POST" action="">
							<input type="text" name="email" placeholder="Email" required value="<?php echo $_POST['email']; ?>">
							<input type="password" name="mdp" placeholder="Mot de passe" required value="<?php echo $_POST['mdp']; ?>">
							<input type="submit" name="co" value="Valider">
						</form>
					</body>
				</html>
			<?php
			$result->free();
		}
		else
		{
			$_SESSION['id'] = $get_info[0];
		}
	}
?>