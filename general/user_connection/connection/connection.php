<?php
	if(!isset($_SESSION)) {
		session_start();
	}
	setlocale(LC_ALL,'fr_FR@euro', 'fr_FR', 'fr', 'FR');
	
	if(isset($_SESSION['id'])) {
		?>
			<script type="text/javascript">
				window.location.replace('/site_noel/Accueil/Presentation/presentation.php');
				//window.location.replace('/');
			</script>
		<?php
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Connection</title>
		<link rel="stylesheet" type="text/css" href="/site_noel/general/gen_style.css">
		<link rel="stylesheet" type="text/css" href="/site_noel/general/user_connection/user_connection.css">
	</head>

	<body>
		<?php include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/nav.php"); ?>
		<div id="title">
			<h1>Connection</h1>
			<?php
				if( !isset($_POST['email']) || !isset($_POST['mdp']) ) {
					include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/user_connection/connection/connection_init.php");
				} else {
					include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/user_connection/connection/connection_verif.php");
				}
			?>
		</div>
	</body>
</html>