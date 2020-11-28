<?php
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/standard_php_header.php");
	include($_SERVER['DOCUMENT_ROOT']."/site_noel/general/decode.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tableau de bord</title>
		<link rel="stylesheet" type="text/css" href="/site_noel/general/gen_style.css">
		<link rel="stylesheet" type="text/css" href="./change_style.css">
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

			$query = "Select * FROM recette r WHERE r.idU=" . $_SESSION['id'] . " AND r.idR=". $_GET['id'];
			if (!$result = $mysqli->query($query))
			{
				echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
				exit;
			}

			if (!($recette = $result->fetch_row()))
			{
				// pas de recette avec cet index ou l'utilisateur n 'est pas celui qui l a ajouté
				exit;
			}
			$result->free();
		?>

		<h2 style="width: 20%; margin-bottom: 10px; cursor: pointer;" id="change">Modifier</h2>
		<script type="text/javascript" src="./change_recipe.js"></script>
		<p id="error"></p>


		<input type="hidden" id="recette_id" value="<?php echo $_GET['id']; ?>">



		<h1>Modification de Recettes</h1>

		<div id="contenu">
			<div id="Filtres" style="width: min-content;">
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
								<input type="text" name="nom" id="nom" autocomplete="off" value="<?php echo htmlspecialchars($recette[1], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); ?>">
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
								<input type="number" name="quantite_preparation" id="quantite_preparation" min="0" value="<?php echo htmlspecialchars($recette[4], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); ?>">
							</div>
							<div>
								<label for="unite_quantite">Unité : </label>
								<input type="text" name="unite_quantite" id="unite_quantite" autocomplete="off" value="<?php echo htmlspecialchars($recette[5], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); ?>" >
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
								<input type="hidden" name="temps_preparation" id="temps_prep" value="<?php echo $recette[3]; ?>">
							</div>
							<div id="temps">
								<p id="heure1">01h00min</p>
								<input type="button" value=" -- "onclick="minus(1,30);">
								<input type="button" value=" - "onclick="minus(1,5);">
								<input type="button" value=" + " onclick="plus(1,5);">
								<input type="button" value=" ++ " onclick="plus(1,30);">
								<p> Temps de Cuisson</p>
								<input type="hidden" name="temps_prep" id="temps_cuis" value="<?php echo $recette[2]; ?>">
											
							</div>
						</div>
						<?php
							print( "<script>init(0,\"".$recette[3]."\"); init(1,\"".$recette[2]."\");</script>");
						?>
					</fieldset>
					<fieldset>
						<legend>
							Saison
						</legend>
						<div>
							<div>
								<?php
									$query = "SELECT * FROM se_prepare_en spe JOIN saison s ON spe.idS = s.idS WHERE spe.idR=".$_GET['id']." AND s.saisoncol=\"printemps\"";
									if (!$result = $mysqli->query($query))
									{
										echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
										exit;
									}
								?>
								<input type="checkbox" name="printemps" id="printemps" <?php if($result->fetch_row()) {echo "checked";} ?>>
								<?php $result->free() ?>
								<label for="printemps">Printemps</label>
							</div>
							<div>
								<?php
									$query = "SELECT * FROM se_prepare_en spe JOIN saison s ON spe.idS = s.idS WHERE spe.idR=".$_GET['id']." AND s.saisoncol=\"été\"";
									if (!$result = $mysqli->query($query))
									{
										echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
										exit;
									}
								?>
								<input type="checkbox" name="ete" id="ete" <?php if($result->fetch_row()) {echo "checked";} ?>>
								<?php $result->free() ?>
								<label for="ete">Eté</label>
							</div>
							<div>
								<?php
									$query = "SELECT * FROM se_prepare_en spe JOIN saison s ON spe.idS = s.idS WHERE spe.idR=".$_GET['id']." AND s.saisoncol=\"automne\"";
									if (!$result = $mysqli->query($query))
									{
										echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
										exit;
									}
								?>
								<input type="checkbox" name="automne" id="automne" <?php if($result->fetch_row()) {echo "checked";} ?>>
								<?php $result->free() ?>
								<label for="automne">Automne</label>
							</div>
							<div>
								<?php
									$query = "SELECT * FROM se_prepare_en spe JOIN saison s ON spe.idS = s.idS WHERE spe.idR=".$_GET['id']." AND s.saisoncol=\"hiver\"";
									if (!$result = $mysqli->query($query))
									{
										echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
										exit;
									}
								?>
								<input type="checkbox" name="hiver" id="hiver" <?php if($result->fetch_row()) {echo "checked";} ?>>
								<?php $result->free() ?>
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
									<input type="text" name="pays" id="pays" value="<?php echo htmlspecialchars($recette[7], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); ?>">
									<label for="pays">Pays</label>
								</div>
								<div>
									<input type="text" name="source" id="source" value="<?php echo htmlspecialchars($recette[6], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); ?>">
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
										<option value="0" <?php if($recette[9] == 0) {echo "selected";} ?>>Très Facile</option>
										<option value="1" <?php if($recette[9] == 1) {echo "selected";} ?>>Facile</option>
										<option value="2" <?php if($recette[9] == 2) {echo "selected";} ?>>Moyen</option>
										<option value="3" <?php if($recette[9] == 3) {echo "selected";} ?>>Difficile</option>
									</select>
									<label for="facilite">Facilité</label>
								</div>
								<div>
									<select name="cout" id="cout">
										<option value="-1"></option>
										<option value="0" <?php if($recette[8] == 0) {echo "selected";} ?>>bon marché</option>
										<option value="1" <?php if($recette[8] == 1) {echo "selected";} ?>>moyen</option>
										<option value="2" <?php if($recette[8] == 2) {echo "selected";} ?>>cher</option>
									</select>
									<label for="cout">Cout</label>
								</div>
							</div>
						</fieldset>















						<fieldset>
							<legend>
								Ingredients Inclus
							</legend>
							<div id="categories">
								<div class="category">
									<div></div>
									<div></div>
									<div>
										<div>
											<input type="text" id="ingredient">
											<label for="ingredient">Ingredient</label>
										</div>
									</div>
									<div class="ing_result"></div>
									<div class="ing_choisis"></div>
								</div>
							</div>
							<div style="display: none;" id="insert_ingredient_form">
								<div style="display: flex; flex-direction: column;">
									<div style="display: flex; flex-direction: row; justify-content: space-around;">
										<label for="ingredient_photo">Image (url) : </label>
										<input type="text">
									</div>
									<input type="button" value="Ajouter ingredient">
								</div>
							</div>

							<fieldset>
								<legend>
									Ajouter une catégorie.
								</legend>
								<div>
									<div style="justify-content: space-around;">
										<input type="text" id="new_category">
										<input type="button" id="add_new_category" value="Ajouter">
									</div>
								</div>
							</fieldset>

							<script type="text/javascript" src="./search_ingredient3.js"></script>

							<?php
								$sql = "SELECT DISTINCT c.category FROM contient c WHERE c.idR=".$_GET['id']." AND c.category IS NOT NULL";

								if (!$result = $mysqli->query($sql))
								{
									echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
									exit;
								}

								while ($cats = $result->fetch_row())
								{
									print("<script>manual_cat_insert(\"". addslashes($cats[0]) ."\");</script>");
								}
								$result->free();

								$sql = "SELECT i.idI, i.nom, i.photo, c.category, c.quantite, c.unite FROM contient c JOIN ingredient i ON c.idI=i.idI WHERE c.idR=".$_GET['id'];
								if (!$result2 = $mysqli->query($sql))
								{
									echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
									exit;
								}

								while ($ings = $result2->fetch_row())
								{
									print("<script>manual_ing_insert(\"".addslashes($ings[0])."\",\"".addslashes($ings[1])."\",\"".addslashes($ings[2])."\",\"".addslashes($ings[3])."\",\"".addslashes($ings[4])."\",\"".addslashes($ings[5])."\");</script>");
								}
								$result2->free();
							?>
						</fieldset>











						<fieldset>
							<legend>
								Tag
							</legend>
							<input type="hidden" id="ids_tags">
							<div style="flex-direction: row; flex-wrap: wrap; width: initial;" id="tags">
								<?php
									$recette_tags = array();
									$sql = 'SELECT t.idT FROM tague t WHERE t.idR = '.$_GET['id'];

									if (!$result = $mysqli->query($sql))
									{
										echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
										exit;
									}
									while ($get_info = $result->fetch_row())
									{
										array_push($recette_tags, $get_info[0]);
									}
									$result->free();


									$sql = 'SELECT * FROM tag';

									if (!$result = $mysqli->query($sql))
									{
										echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
										exit;
									}

									while ($get_info = $result->fetch_row())
									{
										$checked = array_search($get_info[0], $recette_tags);

										$tag_id = "tag-".$get_info[0];
										$tag_nom = $get_info[1];
										?>
											<div style="flex-direction: row;">
												<input type="checkbox" <?php echo "id=\"$tag_id\" onclick=\"tag_clicked('$get_info[0]');\""; ?> <?php if($checked === FALSE){}else{echo "checked";} ?> >
												<label for=<?php echo "$tag_id"; ?>><?php echo "$tag_nom"; ?></label>
											</div>
										<?php

										if($checked === FALSE){}
										else {
											echo "<script type=\"text/javascript\">tag_clicked('$get_info[0]');</script>";
										}
									}
									$result->free();
								?>
							</div>
							
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
							<?php
								$recette_tags = array();
									$sql = 'SELECT * FROM photo p WHERE p.idR = '.$_GET['id'].' ORDER BY idP ASC';

									if (!$result = $mysqli->query($sql))
									{
										echo "SELECT error in query " . $sql . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
										exit;
									}

									$index = 0;

									while ($get_info = $result->fetch_row())
									{
										?>
											<input type="url" id = "photo <?php echo "$index" ?>" value="<?php echo htmlspecialchars($get_info[1], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8"); ?>">
										<?php
										$index += 1;
									}
									$result->free();
							?>
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
											photos.lastElementChild.remove();
										}
									});
								</script>
							</div>
						</fieldset>
					</fieldset>
				</fieldset>
			</div>
			<div id="preparation">
				<h2>Réalisation</h2>
				<div id="realisation">
					<div id="steps">
						<?php 
							$query = "Select * FROM etape e WHERE e.idR=". $_GET['id']." ORDER BY e.idE";
							if (!$result = $mysqli->query($query))
							{
								echo "SELECT error in query " . $query . " errno: " . $mysqli->errno . " error: " . $mysqli->error;
								exit;
							}

							$index = 1;

							while ($step = $result->fetch_row())
							{
								print("<fieldset>
									<legend>
										Etape ".$index." :
									</legend>
									<textarea rows=\"7\">".$step[2]."</textarea>
									<p>Photo (optionnel) :</p>
									<input style=\"width: 100%;\" type=\"url\" id=\"stepPhoto".$index."\" value=\"".htmlspecialchars($step[1], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8")."\">
								</fieldset>");
								$index += 1;
							}
							$result->free();
						?>
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
									steps.lastElementChild.remove();
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