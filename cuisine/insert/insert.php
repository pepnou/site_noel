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
					<link rel="stylesheet" type="text/css" href="./insert_style.css">
					<script type="text/javascript" src="./time_script.js"></script>
					<script type="text/javascript" src="./tags_script.js"></script>
				</head>
				<body>
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


					<!--<a href="/site_noel/cuisine/insert/insert.php" style="width: 20%; margin-bottom: 10px;"><h2>Inserer</h2></a>-->
					<h2 style="width: 20%; margin-bottom: 10px; cursor: pointer;" id="insert">Inserer</h2>
					<script type="text/javascript" src="./insert_recipe.js"></script>
					<p id="error"></p>

					<h1>Insertion de Recettes</h1>

					<div id="contenu">
						<div id="Filtres" style="width: min-content;">
							<form action="#">
								<fieldset>
									<legend>
										Informations
									</legend>
									<fieldset>
										<legend>
											Nom
										</legend>
										<div>
											<div>
												<input type="text" name="nom" id="nom" autocomplete="off">
												<label for="nom">Nom</label>
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend>
											Quantité
										</legend>
										<div>
											<div>
												<label for="quantite_preparation">Pour : </label>
												<input type="number" name="quantite_preparation" id="quantite_preparation" min="0" value="0">
											</div>
											<div>
												<label for="unite_quantite">Unité : </label>
												<input type="text" name="unite_quantite" id="unite_quantite" autocomplete="off" value="Personne">
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend>
											Temps
										</legend>
										<div style="width: max-content;">
											<div id="temps">
												<p id="heure0">01h00min</p>
												<input type="button" value=" -- " onclick="minus(0,30);">
												<input type="button" value=" - " onclick="minus(0,5);">
												<input type="button" value=" + " onclick="plus(0,5);">
												<input type="button" value=" ++ " onclick="plus(0,30);">
												<p> Temps de Réalisation</p>
												<input type="hidden" name="temps_preparation" id="temps_prep" value="01:00:00">
											</div>
											<div id="temps">
												<p id="heure1">01h00min</p>
												<input type="button" value=" -- "onclick="minus(1,30);">
												<input type="button" value=" - "onclick="minus(1,5);">
												<input type="button" value=" + " onclick="plus(1,5);">
												<input type="button" value=" ++ " onclick="plus(1,30);">
												<p> Temps de Cuisson</p>
												<input type="hidden" name="temps_prep" id="temps_cuis" value="01:00:00">
											</div>
										</div>
									</fieldset>
									<fieldset>
										<legend>
											Saison
										</legend>
										<div>
											<div>
												<input type="checkbox" name="printemps" id="printemps">
												<label for="printemps">Printemps</label>
											</div>
											<div>
												<input type="checkbox" name="ete" id="ete">
												<label for="ete">Eté</label>
											</div>
											<div>
												<input type="checkbox" name="automne" id="automne">
												<label for="automne">Automne</label>
											</div>
											<div>
												<input type="checkbox" name="hiver" id="hiver">
												<label for="hiver">Hiver</label>
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
													<input type="text" name="pays" id="pays">
													<label for="pays">Pays</label>
												</div>
												<div>
													<input type="text" name="source" id="source">
													<label for="source">Provenance</label>
												</div>
											</div>
										</fieldset>
										<fieldset>
											<legend>
												Réalisation
											</legend>
											<div>
												<div>
													<select name="facilite" id="facilite">
														<option value="-1"></option>
														<option value="0">Très Facile</option>
														<option value="1">Facile</option>
														<option value="2">Moyen</option>
														<option value="3">Difficile</option>
													</select>
													<label for="facilite">Facilité</label>
												</div>
												<div>
													<select name="cout" id="cout">
														<option value="-1"></option>
														<option value="0">bon marché</option>
														<option value="1">moyen</option>
														<option value="2">cher</option>
													</select>
													<label for="cout">Cout</label>
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
											<div id="ing_result" class="ingredient_selection"></div>
											<div id="ing_choisis" class="ingredient_selection"></div>
											<input type="hidden" name="ids_ing" id="ids_ing">


											<div style="display: none;" id="insert_ingredient_form">
												<div style="display: flex; flex-direction: column;">
													<div style="display: flex; flex-direction: row; justify-content: space-around;">
														<label for="ingredient_photo">Image (url) : </label>
														<input type="text">
													</div>
													<input type="button" value="Ajouter ingredient">
												</div>
											</div>

											<script type="text/javascript" src="./search_ingredient.js"></script>


											<!--<fieldset style="margin-top: 10px;">
												<legend>
													Ajout d'ingredient
												</legend>
													<div>
														<div>
															<input type="text" name="nom_ingredient" id="nom_ingredient">
															<label>Nom</label>
														</div>
														<div>
															<input type="url" name="image_ingredient" id="image_ingredient">
															<label>Image (url)</label>
														</div>
														<div>
															<input type="button" value="Ajouter" id="insert_ingredient">
															<script type="text/javascript" src="./insert_ingredient.js"></script>
														</div>
													</div>
											</fieldset>-->
										</fieldset>
										<fieldset>
											<legend>
												Tag
											</legend>
											<div style="flex-direction: row; flex-wrap: wrap; width: initial;" id="tags">
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
															<div style="flex-direction: row;">
																<input type="checkbox" <?php echo "id=\"$tag_id\" onclick=\"tag_clicked('$get_info[0]');\""; ?> >
																<label for=<?php echo "$tag_id"; ?>><?php echo "$tag_nom"; ?></label>
															</div>
														<?php
													}
													$result->free();
												?>
											</div>
											<input type="hidden" id="ids_tags">
											<input type="text" id="tag">
											<input type="button" value="Ajouter un tag" id="AjoutTag">
											<script type="text/javascript" src="./insert_tag.js"></script>
											<input type="hidden" name="tag" id="tag">
										</fieldset>
										<fieldset>
											<legend>
												Photos (url)
											</legend>
											<div id="photos">
											</div>
											<div style="display: flex; flex-direction: row; justify-content: space-around; width: 100%; margin-top: 10px;">
												<input type="button" value="Ajouter une photo" id="AjoutPhoto">
												<input type="button" value="Retirer une photo" id="SupprPhoto">
												<script type="text/javascript">
													var photos = document.getElementById("photos");

													document.getElementById("AjoutPhoto").addEventListener("click", function() {
														var photo = photos.appendChild(document.createElement("input"));

														photo.type = "url";
														photo.id = "photo" + photos.children.length;
													});
													document.getElementById("SupprPhoto").addEventListener("click", function() {
														if( photos.children.length > 0 ) {
															photos.lastChild.remove();
														}
													});
												</script>
											</div>
										</fieldset>
									</fieldset>
								</fieldset>
							</form>
						</div>
						<div id="preparation">
							<h2>Réalisation</h2>
							<div id="realisation">
								<div id="steps">
									<fieldset>
										<legend>
											Etape 1 :
										</legend>
										<textarea rows="7"></textarea>
										<p>Photo (optionnel) :</p>
										<input style="width: 100%;" type="url" id="stepPhoto1">
									</fieldset>
								</div>
								<div style="display: flex; flex-direction: row; justify-content: space-around; width: 100%; margin-top: 10px;">
									<input type="button" value="Ajouter une étape" id="AjoutEtape">
									<input type="button" value="Retirer une étape" id="SupprEtape">
									<script type="text/javascript">
										var steps = document.getElementById("steps");

										document.getElementById("AjoutEtape").addEventListener("click", function() {
											var fieldset = steps.appendChild(document.createElement("fieldset"));
											var legend = fieldset.appendChild(document.createElement("legend"));
											var textarea = fieldset.appendChild(document.createElement("textarea"));
											var photo_descrition = fieldset.appendChild(document.createElement("p"));
											var photo = fieldset.appendChild(document.createElement("input"));

											legend.innerText = "Etape " + steps.children.length + " :";
											textarea.rows = "7";
											textarea.id = "step" + steps.children.length;
											photo_descrition.innerText = "Photo (optionnel) :";
											photo.style.width = "100%";
											photo.type = "url";
											photo.id = "stepPhoto" + steps.children.length;
										});
										document.getElementById("SupprEtape").addEventListener("click", function() {
											if( steps.children.length > 1 ) {
												steps.lastChild.remove();
											}
										});
									</script>
								</div>
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