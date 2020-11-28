<?php
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/standard_php_header.php");
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/decode.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tableau de bord</title>
		<link rel="stylesheet" type="text/css" href="/site_noel/general/gen_style.css">
		<link rel="stylesheet" type="text/css" href="recette_style.css">
		<script type="text/javascript" src="recette_scripts.js"></script>
	</head>
	<body>
		<header>
						
		</header>

		<?php include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/nav.php"); ?>

		<div class="horz align-prim">
			<?php
				if(!isset($_GET['id']))
				{

				}

				$mysqli = new mysqli('localhost', 'root', '', 'mydb');

				if ($mysqli->connect_errno)
				{
					echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
					exit;
				}

				mysqli_set_charset($mysqli, "utf8");



				$sql = 'SELECT DISTINCT r.*, u.* FROM recette r, user u WHERE r.idR != 0 AND r.idU = u.idU AND r.idR = '.$_GET['id'];

				if (!$result = $mysqli->query($sql))
				{
					echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
					exit;
				}
				$info_recette = $result->fetch_row();



				if($_SESSION['id'] == $info_recette[13]) {
					echo "<a href=\"/site_noel/cuisine/change/change.php?id=".$_GET['id']."\" style=\"width: 20%; margin-bottom: 10px;\"><h2>Modifier</h2></a>";
				}

				$result->free();

				$info_recette[2] = explode(':', $info_recette[2]);
				$info_recette[2] = $info_recette[2][0].' h '.$info_recette[2][1].' min';

				$info_recette[3] = explode(':', $info_recette[3]);
				$info_recette[3] = $info_recette[3][0].' h '.$info_recette[3][1].' min';

				$cout = ['Bon Marché','Moyen','Cher'];
				$facilite = ['Très Facile','Facile','Moyen','Difficile'];
			?>

			<button class="horz align-sec" style="margin-bottom: 10px;" onclick="fav_change();">
				<img id="fav_img">
				<h3>Favori</h3>
			</button>

			<?php
				$sql = 'SELECT f.* FROM favori f WHERE f.idR = '.$_GET['id'].' AND f.idU = '.$_SESSION['id'];

				if (!$result = $mysqli->query($sql))
				{
					echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
					exit;
				}

				$favori_fetch = $result->fetch_row();
				if($favori_fetch) {
					echo '<script>fav_init(1,'.$_GET['id'].');</script>';
				} else {
					echo '<script>fav_init(0,'.$_GET['id'].');</script>';
				}
			?>
		</div>


		<h1>
			<?php echo $info_recette[1]; ?>
		</h1>

		<div id="contenu">
			<div id="information">
				<fieldset>
					<legend>
						Informations
					</legend>
					<fieldset>
						<legend>
							Temps
						</legend>
						<div>
							<div>
								<p>Temps de préparation : <?php echo $info_recette[3]; ?></p>
							</div>
							<div>
								<p>Temps de cuisson : <?php echo $info_recette[2]; ?></p>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>
							Origine
						</legend>
						<div>
							<?php
								if($info_recette[7])
								{
									?>
										<div>
											<p>Pays : <?php echo $info_recette[7]; ?></p>
										</div>
									<?php
								}
							?>
							<div>
								<p>Utilisateur : <?php echo $info_recette[14].' '.$info_recette[15]; ?></p>
							</div>
							<?php
								if($info_recette[6])
								{
									?>
										<div>
											<p>Provenance : <?php echo $info_recette[6]; ?></p>
										</div>
									<?php
								}
							?>
						</div>
					</fieldset>
					<fieldset>
						<legend>
							Générale
						</legend>
						<div>
							<div>
								<p>Facilté : <?php echo $facilite[$info_recette[9]]; ?></p>
							</div>
							<div>
								<p>Cout : <?php echo $cout[$info_recette[8]]; ?></p>
							</div>
						</div>
					</fieldset>
					<fieldset id="ingredient">
						<legend>
							Ingredients
						</legend>
						<!--<div id="ingredient">-->
							<div style="margin-bottom: 5px;">
								<div>
									<p>Quantités pour </p>
									<input type="number" name="ing" id="ing" min="1" oninput="ing_change();" value="<?php echo $info_recette[4]; ?>">
									<p>  <?php echo $info_recette[5]; ?></p>
									<script type="text/javascript">
										setup_pers(<?php echo $info_recette[4]; ?>);
									</script>
								</div>
							</div>

							<?php
								$idR = $_GET['id'];
								$sql = "SELECT DISTINCT i.nom, i.photo, c.quantite, c.unite, c.category FROM contient c, ingredient i WHERE c.idI = i.idI AND c.idR = $idR ORDER BY c.idR ASC, c.idC ASC";

								if (!$result = $mysqli->query($sql)) {
									echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
									exit;
								}

								$i=0;
								while ($get_info = $result->fetch_row()) {
									$nom = $get_info[0];
									$photo = $get_info[1];
									$quantite = $get_info[2];
									$unite = $get_info[3];
									$category = $get_info[4];

									if($get_info[1] == "") {
										$photo = "/site_noel/general/Empty.png";
									}

									//echo "\n<script type=\"text/javascript\">display_ingredient(\"$nom\", \"$photo\", $quantite, \"$unite\", \"$category\");</script>";
									//echo "\n<script type=\"text/javascript\">display_ingredient(\"".htmlspecialchars($nom, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8")."\", \"".htmlspecialchars($photo, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8")."\", ".htmlspecialchars($quantite, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8").", \"".htmlspecialchars($unite, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8")."\", \"".htmlspecialchars($category, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8")."\");</script>";
									echo "\n<script type=\"text/javascript\">display_ingredient(\"".addslashes($nom)."\", \"".addslashes($photo)."\", ".addslashes($quantite).", \"".addslashes($unite)."\", \"".addslashes($category)."\");</script>";
									//echo "\n<script type=\"text/javascript\">display_ingredient(json_encode(utf8_encode($nom)), json_encode(utf8_encode($photo)), json_encode(utf8_encode($quantite)), json_encode(utf8_encode($unite)), json_encode(utf8_encode($category)));</script>";
								}
								$result->free();
							?>
						<!--</div>-->
					</fieldset>
				</fieldset>
			</div>
			<div id="preparation">
				<?php
					$sql = 'SELECT * FROM photo p WHERE p.idR = '.$_GET['id'];

					if (!$result = $mysqli->query($sql))
					{
						echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
						exit;
					}

					if($get_info = $result->fetch_row())
					{
						?>
							<script type="text/javascript">
								setup_photo('<?php echo /*htmlspecialchars($get_info[1], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8");*/ addslashes($get_info[1]); ?>');
							</script>
							<div id="photo_div">
								<img src="<?php echo htmlspecialchars($get_info[1], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); /*addslashes($get_info[1]);*/ ?>" id="photo">
								<div id="photo_button_div">
									<input type="button" name="photo_min" value=" - " onclick="photo_min();">
									<input type="button" name="photo_plus" value=" + " onclick="photo_plus();">
								</div>
							</div>
						<?php
					}


					while ($get_info = $result->fetch_row())
					{
						?>
							<script type="text/javascript">
								setup_photo('<?php echo /*htmlspecialchars($get_info[1], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8");*/ addslashes($get_info[1]); ?>');
							</script>
						<?php
					}
					$result->free();
				?>
				<h2>Preparation</h2>
				<div id="etapes">
					<?php
						$sql = 'SELECT * FROM etape e WHERE e.idR = '.$_GET['id'].' ORDER BY e.idE ASC';

						if (!$result = $mysqli->query($sql))
						{
							echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
							exit;
						}

						$i = 1;

						while ($get_info = $result->fetch_row())
						{
							?>
								<fieldset>
									<legend>
										Etape <?php echo $i; ?>
									</legend>
									<div>
										<div>
											<?php
												$i++;
												if($get_info[1])
												{
													?>
														<img src="<?php echo htmlspecialchars($get_info[1], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); ?>">
													<?php
												}
											?>
											<p><?php echo str_replace("\n", "<br>", $get_info[2]); ?></p>
										</div>
									</div>
								</fieldset>
							<?php
						}
						$result->free();
					?>
				</div>
			</div>
		</div>

		<footer>

		</footer>
	</body>
</html>