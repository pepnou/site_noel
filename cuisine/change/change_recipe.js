document.getElementById('change').addEventListener("click", change_recipe);

function change_recipe() {
	var id = document.getElementById('recette_id'),
		nom = document.getElementById('nom'),
		quantite = document.getElementById('quantite_preparation'),
		unite = document.getElementById('unite_quantite'),
		temps_prep = document.getElementById('temps_prep'),
		temps_cuis = document.getElementById('temps_cuis'),
		printemps = document.getElementById('printemps'),
		ete = document.getElementById('ete'),
		automne = document.getElementById('automne'),
		hiver = document.getElementById('hiver'),
		pays = document.getElementById('pays'),
		source = document.getElementById('source'),
		facilite = document.getElementById('facilite'),
		cout = document.getElementById('cout'),
		ingredients = document.getElementById('categories'),
		ids_tags = document.getElementById('ids_tags'),
		photos = document.getElementById('photos'),
		steps = document.getElementById('steps');

	var error = document.getElementById('error');
	
	if(nom.value.length == 0) {
		error.innerText = "Un nom doit être spécifié pour la recette.";
		return;
	}
	if(quantite.value == 0) {
		error.innerText = "Une quantité supérieure a 0 doit être spécifiée.";
		return;
	}
	if(unite.value.length == 0) {
		error.innerText = "Une unité pour la quantité doit être spécifiée.";
		return;
	}


	var saison = [];
	saison.push(0);
	if(printemps.checked) {
		saison.push(1);
		saison[0]++;
	}
	if(ete.checked) {
		saison.push(2);
		saison[0]++;
	}
	if(automne.checked) {
		saison.push(3);
		saison[0]++;
	}
	if(hiver.checked) {
		saison.push(4);
		saison[0]++;
	}
	if(saison[0] == 0) {
		error.innerText = "Une recette doit pourvoir être préparée pendant au moins une saison.";
		return;
	}
	saison = saison.join('|');



	if(facilite.value == -1) {
		error.innerText = "Une facilité de préparation approximative doit être spécifiée.";
		return;
	}
	if(cout.value == -1) {
		error.innerText = "Un cout de préparation approximatif doit être spécifié.";
		return;
	}



	var tags_array = [];
	if(ids_tags.value.length == 0) {
		tags_array.push(0);
	} else {
		tags_array.push(ids_tags.value.split("|").length);
		Array.prototype.push.apply(tags_array, ids_tags.value.split("|"));
	}
	tags_array = tags_array.join("|");



	var photos_array = [];
	photos_array.push(photos.children.length);
	for (var i = 0; i < photos.children.length; i++) {
		if(photos.children[i].value.length > 0) {
			photos_array.push(encodeURIComponent(photos.children[i].value));
		}
	}
	photos_array = photos_array.join('|');



	var ingredients_array = [];
	ingredients_array.push(0);
	//console.log("categories: ");
	//console.log(ingredients);
	for(var i = 0; i < ingredients.children.length; i++) {
		var category = ingredients.children[i];
		//console.log("category: ");
		//console.log(category);
		for(var j = 0; j < category.children[4].children.length; j++) {
			var ingredient = category.children[4].children[j];
			//console.log("ingredient: ");
			//console.log(ingredient)

			if(ingredient.children[1].children[0].children[1].value == 0) {
				error.innerText = "Chaque ingrédient doit comporter une quantité supérieure à 0.";
				return;
			}

			ingredients_array.push(ingredient.children[0].children[2].value);
			ingredients_array.push(ingredient.children[1].children[0].children[1].value);
			ingredients_array.push(encodeURIComponent(ingredient.children[1].children[1].children[1].value));

			if(category.tagName.toLowerCase() == "div") {
				ingredients_array.push("");
			} else {
				ingredients_array.push(encodeURIComponent(category.children[0].innerText));
			}

			ingredients_array[0]++;
		}
	}
	ingredients_array = ingredients_array.join('|');

	if(ingredients_array[0] == 0) {
		error.innerText = "Une recette doit au moins comporter un ingredient.";
		return;
	}


	if(steps.children[0].children[1].value.length == 0) {
		error.innerText = "Une recette doit au moins comporter une étape non vide.";
		return;
	}

	var steps_array = [];
	steps_array.push(0);
	for (var i = 0; i < steps.children.length; i++) {
		if(steps.children[i].children[1].value.length > 0) {
			steps_array.push(encodeURIComponent(steps.children[i].children[1].value));
			steps_array.push(encodeURIComponent(steps.children[i].children[3].value));
			steps_array[0]++;
		}
	}
	steps_array = steps_array.join('|');


	var xhr = new XMLHttpRequest();
	xhr.open('POST', './change_recipe.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var request =	'id=' + encodeURIComponent(id.value) + 
					'&nom=' + encodeURIComponent(nom.value) + 
					'&quantite=' + quantite.value + 
					'&unite=' + encodeURIComponent(unite.value) + 
					'&temps_prep=' + temps_prep.value +
					'&temps_cuis=' + temps_cuis.value +
					'&saison=' + saison +
					'&pays=' + encodeURIComponent(pays.value) +
					'&source=' + encodeURIComponent(source.value) + 
					'&facilite=' + facilite.value +
					'&cout=' + cout.value +
					'&ingredients=' + ingredients_array +
					'&ids_tags=' + tags_array +
					'&photos=' + photos_array +
					'&steps=' + steps_array;

	console.log(request);

	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			console.log(xhr.responseText);
			//window.location.replace('/site_noel/cuisine/recette/recette.php?id=' + id.value);
		}
	});

	xhr.send(request);

	//return xhr;
}