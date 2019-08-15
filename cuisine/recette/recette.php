<?php
	session_start();

	if(!isset($_SESSION['id']))
	{
		include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/user_connection/connection/connection.php");
	}
	else
	{
					?>
			<!DOCTYPE html>
			<html>
				<head>
					<title>Tableau de bord</title>
					<link rel="stylesheet" type="text/css" href="../../general/gen_style.css">
					<link rel="stylesheet" type="text/css" href="recette_style.css">
					<script type="text/javascript" src="recette_scripts.js"></script>
				</head>
				<body>
					<header>
						
					</header>

					<?php include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/nav.php"); ?>

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

						if(!$info_recette = $result->fetch_row())
						{

						}

						$result->free();

						$info_recette[2] = explode(':', $info_recette[2]);
						$info_recette[2] = $info_recette[2][0].' h '.$info_recette[2][1].' min';

						$info_recette[3] = explode(':', $info_recette[3]);
						$info_recette[3] = $info_recette[3][0].' h '.$info_recette[3][1].' min';

						$cout = ['Bon Marché','Moyen','Cher'];
						$facilite = ['Très Facile','Facile','Moyen','Difficile'];
					?>

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
											<p>Utilisateur : <?php echo $info_recette[15].' '.$info_recette[16]; ?></p>
										</div>
										<?php
											if($info_recette[6])
											{
												?>
													<div>
														<p>Source : <?php echo $info_recette[6]; ?></p>
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
											<p>Catégorie : <?php echo $info_recette[9]; ?></p>
										</div>
										<div>
											<p>Facilté : <?php echo $facilite[$info_recette[11]]; ?></p>
										</div>
										<div>
											<p>Cout : <?php echo $cout[$info_recette[10]]; ?></p>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<legend>
										Ingredients
									</legend>
									<div id="ingredient">
										<div>
											<p>Quantités pour </p>
											<!--<input type="button" name="ing_min" id="ing_min" value=" - " onclick="ing_min();">
											<p id="ing"><?php//echo $info_recette[4]; ?></p>
											<input type="button" name="ing_plus" id="ing_plus" value=" + " onclick="ing_plus();">
											<p>  <?php //echo $info_recette[5]; ?></p>-->

											<input type="number" name="ing" id="ing" min="1" oninput="ing_change();" value="<?php echo $info_recette[4]; ?>">
											<p>  <?php echo $info_recette[5]; ?></p>
											<script type="text/javascript">
												setup_pers(<?php echo $info_recette[4]; ?>);
											</script>
										</div>
										<?php
											$sql = 'SELECT DISTINCT i.nom, i.photo, c.quantite, c.unite FROM contient c, ingredient i WHERE c.idI = i.idI AND c.idR = '.$_GET['id'];

											if (!$result = $mysqli->query($sql))
											{
												echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
												exit;
											}

											$i=0;

											while ($get_info = $result->fetch_row())
											{
												?>
													<div>
														<?php
															if($get_info[1])
															{
																?>
																	<img src="<?php echo $get_info[1]; ?>">
																<?php
															}
															else
															{
																?>
																	<img src="https://upload.wikimedia.org/wikipedia/commons/5/59/Empty.png">
																<?php
															}
														?>
														<p><?php echo $get_info[0]; ?></p>
														<p id="<?php echo 'i'.$i; ?>"><?php echo $get_info[2]; ?></p>
														<p><?php echo ' '.$get_info[3]; ?></p>
														<script type="text/javascript">
															setup_ing(<?php echo $get_info[2]; ?>);
														</script>
													</div>
												<?php
												$i++;
											}
											$result->free();
										?>
									</div>
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
											setup_photo('<?php echo $get_info[1]; ?>');
										</script>
										<div id="photo_div" onresize="photo_load();">
											<img src="<?php echo $get_info[1]; ?>" id="photo" onload="photo_load();">
											<input type="button" name="photo_min" value=" - " onclick="photo_min();">
											<input type="button" name="photo_plus" value=" + " onclick="photo_plus();">
										</div>
									<?php
								}


								while ($get_info = $result->fetch_row())
								{
									?>
										<script type="text/javascript">
											setup_photo('<?php echo $get_info[1]; ?>');
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
																	<img src="<?php echo $get_info[1]; ?>">
																<?php
															}
														?>
														<p><?php echo $get_info[2]; ?></p>
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
		<?php
	}
?>



