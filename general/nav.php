<nav>
	<a href="../../Accueil/Presentation/presentation.php">Accueil</a>
	<a href="../../message/message/message.php">Messages</a>
	<a href="../../cuisine/search/search.php">Cuisine</a>
	<a href="../../pornic/calendar/pornic.php">Pornic</a>
	<div></div>
	<?php if(isset($_SESSION['id'])) { ?>
		<a href="../../general/connection/deconnection.php">Deconnection</a>
	<?php } else { ?>
		<a href="../../general/connection/connection.php">Connection</a>
	<?php } ?>
</nav>