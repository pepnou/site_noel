<?php	
	session_start();
	$_SESSION = array();
	session_destroy();
?>

<!DOCTYPE html>
<html>
	<head>
		<!--<title>Deconnection</title>
		<link rel="stylesheet" type="text/css" href="../../general/gen_style.css">
		<script type="text/javascript" src="connection.js"></script>-->
	</head>
	<body>
		<!--<p >Vous avez été déconnecté</p>
		<p>vous allez être rediriger vers l'accueil dans <span id="time">3</span> secondes</p>
		<script type="text/javascript">
			startTimer();
		</script>
		<p>Ou cliquer <a href="presentation.php">ici</a> en cas de non-redirection.</p>-->
		<script type="text/javascript">
			window.location.replace('/site_noel/Accueil/Presentation/presentation.php');
		</script>
	</body>
</html>