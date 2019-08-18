<?php
	if(!isset($_SESSION)) {
		session_start();
	}

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
					<link rel="stylesheet" type="text/css" href="/site_noel/general/gen_style.css">
					<link rel="stylesheet" type="text/css" href="search_style.css">
					<script type="text/javascript" src="search_recette.js"></script>
					<script type="text/javascript" src="search_scripts.js"></script>
					<style type="text/css" id="style_temps">
						#temps > *
						{
							color: orange;
						}
					</style>
				</head>
				<body onload="getResultsR();">
					<header>
						
					</header>

					<?php

						include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/nav.php");

						$mysqli = new mysqli('localhost', 'root', '', 'mydb');

						if ($mysqli->connect_errno)
						{
					 		echo 'Erreur de connexion : errno: ' . $mysqli->errno . ' error: ' . $mysqli->error;
							exit;
						}

						mysqli_set_charset($mysqli, "utf8");
					?>

					<h1>Recherche de Recettes</h1>

					<div id="contenu">
						<div id="Filtres">
							<form action="#">
								<fieldset>
									<legend>
										Filtres
									</legend>
									<fieldset>
										<legend>
											Nom
										</legend>
										<div>
											<div>
												<input type="text" name="nom" id="nom" autocomplete="off">
												<script type="text/javascript">
													document.getElementById('nom').addEventListener('keyup', function(e) {
											        	getResultsR();
											        });
												</script>
												<label for="nom">Nom</label>
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend>
											Favori
										</legend>
										<div>
											<div>
												<input type="checkbox" name="favori" id="favori" onchange="getResultsR();">
												<label for="favori">Favori</label>
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend>
											Saison
										</legend>
										<div>
											<div>
												<input type="checkbox" name="printemps" id="printemps" onchange="getResultsR();">
												<label for="printemps">Printemps</label>
											</div>
											<div>
												<input type="checkbox" name="ete" id="ete" onchange="getResultsR();">
												<label for="ete">Eté</label>
											</div>
											<div>
												<input type="checkbox" name="automne" id="automne" onchange="getResultsR();">
												<label for="automne">Automne</label>
											</div>
											<div>
												<input type="checkbox" name="hiver" id="hiver" onchange="getResultsR();">
												<label for="hiver">Hiver</label>
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend>
											Type de plat
										</legend>
										<div>
											<div>
												<select name="type" id="type" onchange="getResultsR();">
													<option value="-1"></option>
													<?php
														$sql = "SELECT DISTINCT r.type FROM recette r";

														if (!$result = $mysqli->query($sql))
														{
													 		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
													 		exit;
														}

														while ($get_info = $result->fetch_row())
														{
															?>
																<option value="<?php echo $get_info[0]; ?>"><?php echo $get_info[0]; ?></option>
															<?php
														}
														$result->free();
													?>
												</select>
												<label for="type">Catégorie</label>
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend>
											Informations Générales
										</legend>
										<fieldset>
											<legend>
												Origine
											</legend>
											<div>
												<div>
													<select name="utilisateur" id="utilisateur" onchange="getResultsR();">
														<option value="-1"></option>
														<?php
															$sql = "SELECT DISTINCT u.idU, u.nom, u.prenom FROM recette r, user u WHERE r.idU = u.idU";

															if (!$result = $mysqli->query($sql))
															{
														 		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
														 		exit;
															}

															while ($get_info = $result->fetch_row())
															{
																?>
																	<option value="<?php echo $get_info[0]; ?>"><?php echo $get_info[1].' '.$get_info[2]; ?></option>
																<?php
															}
															$result->free();
														?>
													</select>
													<label for="utilisateur">Utilisateur</label>
												</div>
												<div>
													<select name="pays" id="pays" onchange="getResultsR();">
														<option value="-1"></option>
														<?php
															$sql = "SELECT r.pays FROM recette r";

															if (!$result = $mysqli->query($sql))
															{
														 		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
														 		exit;
															}

															while ($get_info = $result->fetch_row())
															{
																?>
																	<option value="<?php echo $get_info[0]; ?>"><?php echo $get_info[0]; ?></option>
																<?php
															}
															$result->free();
														?>
													</select>
													<label for="pays">Pays</label>
												</div>
											</div>
										</fieldset>
										<fieldset>
											<legend>
												Réalisation
											</legend>
											<div>
												<div>
													<select name="facilite" id="facilite" onchange="getResultsR();">
														<option value="-1"></option>
														<option value="0">Très Facile</option>
														<option value="1">Facile</option>
														<option value="2">Moyen</option>
														<option value="3">Difficile</option>
													</select>
													<label for="facilite">Facilité</label>
												</div>
												<div>
													<select name="cout" id="cout" onchange="getResultsR();">
														<option value="-1"></option>
														<option value="0">bon marché</option>
														<option value="1">moyen</option>
														<option value="2">cher</option>
													</select>
													<label for="cout">Cout</label>
												</div>
												<div id="temps">
													<input type="checkbox" name="disable-temps" id="disable-temps" onclick="disable_temps();">
													<p id="heure">01h00min</p>
													<input type="button" value=" - " onclick="minus();" id="minusB" disabled="true">
													<input type="button" value=" + " onclick="plus();" id="plusB" disabled="true">
													<p> Temps de Réalisation max</p>
													<input type="hidden" name="temps_prep" id="temps_prep" value="-1">
												</div>
											</div>
										</fieldset>
										<fieldset>
											<legend>
												Ingredients Inclus
											</legend>
											<div>
												<div>
													<input type="text" name="ingredient" id="ingredient">
													<label for="ingredient">Ingredient</label>
												</div>
											</div>
											<div id="ing_result"></div>
											<div id="ing_choisis"></div>
											<input type="hidden" name="ids_ing" id="ids_ing">
											<script type="text/javascript" src="search_ingredient.js"></script>
										</fieldset>
										<fieldset>
											<legend>
												Tag
											</legend>
											<div>
												<?php
													$sql = 'SELECT * FROM tag';

													if (!$result = $mysqli->query($sql))
													{
												 		echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
												 		exit;
													}

													while ($get_info = $result->fetch_row())
													{
														$tag_id = "tag-".$get_info[0];
														$tag_nom = $get_info[1];
														?>
															<div>
																<input type="checkbox" <?php echo "name=\"$tag_id\" id=\"$tag_id\" onclick=\"tag_clicked('$get_info[0]');\""; ?> >
																<label for=<?php echo "$tag_id"; ?>><?php echo "$tag_nom"; ?></label>
															</div>
														<?php
													}
													$result->free();
												?>
												<input type="hidden" name="tag" id="tag">
											</div>
										</fieldset>
										<!--<fieldset>
											<legend>
												Autre
											</legend>
											<div>
												<div>
													<input type="checkbox" name="video" id="video" onchange="getResultsR();">
													<label for="video">Video explicative</label>
												</div>
											</div>
										</fieldset>-->
									</fieldset>
								</fieldset>
							</form>
						</div>
						<div id="resultats">
							<h2>Resultats</h2>
							<div id="recette">

							</div>
						</div>
					</div>

					<?php
						$mysqli->close();
					?>

					<footer>

					</footer>
				</body>
			</html>
		<?php
	}
?>