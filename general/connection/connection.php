<?php
	if(!isset($_SESSION))
		session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Connection</title>
		<link rel="stylesheet" type="text/css" href="../../general/gen_style.css">
	</head>

	<body>
		<div id="connection">
			<h1>Connection</h1>
			<?php
				if(!isset($_SESSION['id']) && (!isset($_POST['email']) || !isset($_POST['mdp'])))
				{
			?>
			<form method="POST" action="">
				<input type="text" name="email" placeholder="Email" required>
				<input type="password" name="mdp" placeholder="Mot de passe" required>
				<input type="submit" name="co" value="Valider">
			</form>
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
								window.location.replace('');
							</script>
						<?php
					}
				}
				else
				{
					?>
						<script type="text/javascript">
							window.location.replace('../../Accueil/Presentation/presentation.php');
						</script>
					<?php
				}
			?>
		</div>
	</body>
</html>