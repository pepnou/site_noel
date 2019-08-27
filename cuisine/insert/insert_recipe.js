document.getElementById('insert').addEventListener("click", insert_recipe);

function insert_recipe() {
	var nom = document.getElementById('nom'),
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
		ing_choisis = document.getElementById('ing_choisis'),
		ids_tags = document.getElementById('ids_tags'),
		photos = document.getElementById('photos'),
		steps = document.getElementById('steps');
	
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
	saison = saison.join('|');


	var tags_array = [];
	tags_array.push(ids_tags.value.split("|").length);
	tags_array.push(ids_tags.value.split("|"));
	tags_array = tags_array.join("|");


	var photos_array = [];
	photos_array.push(photos.children.length);
	for (var i = 0; i < photos.children.length; i++) {
		if(photos.children[i].value.length > 0) {
			photos_array.push(encodeURIComponent(photos.children[i].value));
		}
	}
	photos_array = photos_array.join('|');

	var steps_array = [];
	steps_array.push(steps.children.length)
	for (var i = 0; i < steps.children.length; i++) {
		if(steps.children[i].children[1].value.length > 0) {
			steps_array.push(encodeURIComponent(steps.children[i].children[1].value));
			steps_array.push(encodeURIComponent(steps.children[i].children[3].value));
		}
	}
	steps_array = steps_array.join('|');


	var ingredients_array = [];
	ingredients_array.push(ing_choisis.children.length);
	for (var i = 0; i < ing_choisis.children.length; i++) {
		ingredients_array.push(ing_choisis.children[i].children[1].children[0].children[1].id.slice("quantity".length));
		ingredients_array.push(ing_choisis.children[i].children[1].children[0].children[1].value);
		ingredients_array.push(encodeURIComponent(ing_choisis.children[i].children[1].children[1].children[1].value));
	}
	ingredients_array = ingredients_array.join('|');


	var xhr = new XMLHttpRequest();
	xhr.open('POST', './insert_recipe.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var request =	'nom=' + encodeURIComponent(nom.value) + 
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
			//console.log(xhr.responseText);
			window.location.replace('/site_noel/cuisine/recette/recette.php?id=' + xhr.responseText);
		}
	});

	xhr.send(request);

	return xhr;
}