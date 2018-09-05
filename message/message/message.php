<?php
	session_start();

	if(!isset($_SESSION['id']))
	{
		include("../../general/connection/connection.php");
	}
	else
	{
		?>
			<!DOCTYPE html>
			<html>
				<head>
					<title>Tableau de bord</title>
					<link rel="stylesheet" type="text/css" href="../../general/gen_style.css">
				</head>
				<body>
					<header>
						
					</header>

					<?php include("../../general/nav.php"); ?>

					<div id="contenu">
					</div>

					<footer>

					</footer>
				</body>
			</html>
		<?php
	}
?>