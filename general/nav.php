<nav>
	<a href="/site_noel/Accueil/Presentation/presentation.php">Accueil</a>
	<!--<a href="/site_noel/message/message/message.php">Messages</a>-->
	<a href="/site_noel/cuisine/search/search.php">Cuisine</a>
	<!--<a href="/site_noel/pornic/calendar/pornic.php">Pornic</a>-->
	<div></div>
	<?php if(isset($_SESSION['id'])) { ?>
		<a href="/site_noel/general/user_connection/deconnection/deconnection.php">Deconnection</a>
	<?php } else { ?>
		<a href="/site_noel/general/user_connection/connection/connection.php">Connection</a>
	<?php } ?>
</nav>