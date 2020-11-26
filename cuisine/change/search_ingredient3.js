
var searchElement = document.getElementById('ingredient'),
	insert_ingredient_form = document.getElementById('insert_ingredient_form'),
	categories_div = document.getElementById('categories'),
	previousRequest;

var selectedResult = -1;

var ingredients = [[]];
var categories = [];
var searchElements = [searchElement];



var focus_changed_event = new CustomEvent("focus_changed");

searchElement.addEventListener('keyup', function(e) {
	handle_key(e);
});
searchElement.addEventListener('focus', function(e) {
	if(searchElement === e.target);
	else {
		searchElement = e.target;
		selectedResult = -1;
	}
	for(var i = 0; i < searchElements.length; i++) {
		searchElements[i].dispatchEvent(focus_changed_event);
	}
});
searchElement.addEventListener('focus_changed', function(e) {
	if(searchElement === e.target);
	else {
		e.target.parentNode.parentNode.parentNode.children[3].style.display = "none";
		e.target.value = '';
	}
});



function handle_key(e) {
	var results = e.target.parentNode.parentNode.parentNode.children[3];
	var divs = results.getElementsByTagName('div');

	if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche "haut"
		divs[selectedResult--].className = 'horz align-sec align-prim';

		if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
			divs[selectedResult].className = 'horz align-sec align-prim result_focus';
		}
		return;
	}

	if (e.keyCode == 40 && selectedResult < results.children.length - 2) { // Si la touche pressée est la flèche "bas"
		results.style.display = 'block'; // On affiche les résultats

		if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
			divs[selectedResult].className = '';
		}

		divs[++selectedResult].className = 'result_focus';
		return;
	}

	if (e.keyCode == 13 && selectedResult > -1) { // Si la touche pressée est "Entrée"
		chooseResult(divs[selectedResult].children[2].value, divs[selectedResult].children[1].innerText, divs[selectedResult].children[0].src);
		return;
	}

	if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
		previousRequest.abort(); // Si on a toujours une requête en cours, on l'arrête
	}

	previousRequest = getResults(e.target.value); // On stocke la nouvelle requête
	selectedResult = -1; // On remet la sélection à "zéro" à chaque caractère écrit
}

function getResults(keywords) { // Effectue une requête et récupère les résultats

	var xhr = new XMLHttpRequest();
	xhr.open('GET', './search_ingredient.php?s='+ encodeURIComponent(keywords));

	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			displayResults(xhr.responseText);
		}
	});

	xhr.send(null);

	return xhr;

}

function displayResults(response) { // Affiche les résultats d'une requête
	var results = searchElement.parentNode.parentNode.parentNode.children[3];

	results.style.display = (response.length > 4 || searchElement.value.length > 0) ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultats

	results.innerHTML = ''; // On vide les résultats

	if (response.length > 4) { // On ne modifie les résultats que si on en a obtenu
		response = response.split('||');
		response[0] = response[0].split('|');
		response[1] = response[1].split('|');
		response[2] = response[2].split('|');

		var responseLen = response[0].length;

		for (var i = 0, div ; i < responseLen ; i++) {
			displayResult(response[0][i], response[1][i], response[2][i]);
		}
	}

	if(searchElement.value.length > 0) {
		div = results.appendChild(document.createElement('div'));
		
		div.innerHTML = insert_ingredient_form.innerHTML;
		div.style = "width: max-content;"
		div.id = "";

		div.children[0].children[1].addEventListener("click", function(e) {
			add_ingredient(e);
		});
	}
}

function displayResult(id, name, image) {
	var results = searchElement.parentNode.parentNode.parentNode.children[3];

	div = results.appendChild(document.createElement('div'));

	var imageElement = div.appendChild(document.createElement('img'));
	var nameElement = div.appendChild(document.createElement('p'));
	var idElement = div.appendChild(document.createElement('input'));

	if(image == 'NULL') {
		imageElement.src = "/site_noel/general/Empty.png";
	} else {
		imageElement.src = image;
	}

	nameElement.innerText = name;

	idElement.type = "hidden";
	idElement.value = id;

	div.addEventListener('click', function(e) {
		chooseResult(id, name, imageElement.src);
	});
}

function add_ingredient(e) {

	var nom_ingredient = searchElement.value,
	image_ingredient = e.target.parentNode.children[0].children[1].value;

	var request =	'nom_ingredient=' + encodeURIComponent(nom_ingredient) + 
					'&image_ingredient=' + encodeURIComponent(image_ingredient);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './insert_ingredient.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var image = (image_ingredient.length == 0)? '/site_noel/general/Empty.png':image_ingredient;

	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			if(xhr.responseText != "Allready inserted") {
				console.log(xhr.responseText);
				chooseResult(xhr.responseText ,nom_ingredient.charAt(0).toUpperCase() + nom_ingredient.slice(1).toLowerCase(), image);
			}
		}
	});

	xhr.send(request);
	return xhr;
}

function chooseResult(id, name, image) { // Choisi un des résultats d'une requête et gère tout ce qui y est attaché

	var cat_index
	for(var i = 0; i < categories_div.children.length; i++) {
		if(categories_div.children[i] === searchElement.parentNode.parentNode.parentNode) {
			cat_index = i;
			break;
		}
	}

	var choisis = searchElement.parentNode.parentNode.parentNode.children[4];
	var results = searchElement.parentNode.parentNode.parentNode.children[3];

	if(!ingredients[cat_index].find(function(element) { return element == id; } ) ) {

		var div = choisis.appendChild(document.createElement('div'));

		var div_ingredient = div.appendChild(document.createElement('div'));
		var ingredient_image = div_ingredient.appendChild(document.createElement('img'));
		var ingredient_name = div_ingredient.appendChild(document.createElement('p'));
		var ingredient_id = div_ingredient.appendChild(document.createElement('input'));

		ingredient_image.src = image;
		ingredient_name.innerText = name;
		ingredient_id.type = "hidden";
		ingredient_id.value = id;

		var div_quantity_unit = div.appendChild(document.createElement('div'));
		var div_quantity = div_quantity_unit.appendChild(document.createElement('div'));
		var div_unit = div_quantity_unit.appendChild(document.createElement('div'));

		var quantity_label = div_quantity.appendChild(document.createElement('p'));
		quantity_label.innerText = 'Quantité : '

		var quantity = div_quantity.appendChild(document.createElement('input'));
		quantity.type = 'number';
		quantity.id = 'quantity' + id;
		quantity.style = 'width: 30px;'
		quantity.value = "0";
		quantity.min = "0";

		var unit_label = div_unit.appendChild(document.createElement('p'));
		unit_label.innerText = 'Unité : ';

		var unit = div_unit.appendChild(document.createElement('input'));
		unit.type = 'text';
		unit.size = '7';
		unit.id = 'unit' + id;

		var button = div_ingredient.appendChild(document.createElement('input'));
		button.type = 'button';
		button.value = ' - ';
		button.id = 'id_ing'+id;

		button.addEventListener('click', function(e) {
			removeChosen(e.target, id);
		});

		ingredients[cat_index].push(id);
	}

	searchElement.value = '';
	results.style.display = 'none'; // On cache les résultats
	selectedResult = -1; // On remet la sélection à "zéro"
	searchElement.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue
}


function removeChosen(result, id) {

	var cat_index
	for(var i = 0; i < categories_div.children.length; i++) {
		if(categories_div.children[i] === result.parentNode.parentNode.parentNode.parentNode) {
			cat_index = i;
			break;
		}
	}
	
	var index = ingredients[cat_index].indexOf(id);
	ingredients[cat_index].splice(index,1);

	result.parentNode.parentNode.remove();
}




var category_name = document.getElementById('new_category');
var global_div = document.getElementById("categories");
var global_index = 0;

document.getElementById("add_new_category").addEventListener("click", function() {
	add_category();
});

function add_category() {
	if(category_name.value.length > 0 && !categories.find(function(element) { return element == category_name.value; } )) {
		var name = category_name.value;

		var fieldset = global_div.appendChild(document.createElement("fieldset"));

		var legend = fieldset.appendChild(document.createElement("legend"));

		var rm_cat = fieldset.appendChild(document.createElement("input"));

		var div = fieldset.appendChild(document.createElement("div"));
		var ing_result = fieldset.appendChild(document.createElement("div"));
		var ing_choisis = fieldset.appendChild(document.createElement("div"));

		div.className = "category";
		div = div.appendChild(document.createElement("div"));

		var input = div.appendChild(document.createElement("input"));
		var label = div.appendChild(document.createElement("label"));

		rm_cat.type = "button";
		rm_cat.value = "Retirer catégorie";

		rm_cat.addEventListener('click', function(e) {
			remove_category(e);
		});

		ing_result.className = "ing_result";
		ing_choisis.className = "ing_choisis";

		legend.innerText = name;

		input.type = "text";
		input.id = "search_" + global_index;

		label.for = "search_" + global_index;
		label.innerText = "Ingredient pour " + name;



		global_index++;
		category_name.value = '';


		input.addEventListener('keyup', function(e) {
			handle_key(e);
		});
		input.addEventListener('focus', function(e) {
			if(searchElement === e.target);
			else {
				searchElement = e.target;
				selectedResult = -1;
			}
			for(var i = 0; i < searchElements.length; i++) {
				searchElements[i].dispatchEvent(focus_changed_event);
			}
		});
		input.addEventListener('focus_changed', function(e) {
			if(searchElement === e.target);
			else {
				e.target.parentNode.parentNode.parentNode.children[3].style.display = "none";
				e.target.value = '';
			}
		});

		categories.push(name);
		searchElements.push(input);
		ingredients.push([]);
	}
}

function remove_category(e) {
	var cat_index
	for(var i = 0; i < categories_div.children.length; i++) {
		if(categories_div.children[i] === e.target.parentNode) {
			cat_index = i;
			break;
		}
	}

	ingredients.splice(cat_index, 1);
	categories.splice(cat_index - 1, 1);
	searchElements.splice(cat_index, 1);

	e.target.parentNode.remove();
}





function manual_cat_insert(name) {
	if(name.length == 0) {
		return;
	}

	var fieldset = global_div.appendChild(document.createElement("fieldset"));

	var legend = fieldset.appendChild(document.createElement("legend"));

	var rm_cat = fieldset.appendChild(document.createElement("input"));

	var div = fieldset.appendChild(document.createElement("div"));
	var ing_result = fieldset.appendChild(document.createElement("div"));
	var ing_choisis = fieldset.appendChild(document.createElement("div"));

	div.className = "category";
	div = div.appendChild(document.createElement("div"));

	var input = div.appendChild(document.createElement("input"));
	var label = div.appendChild(document.createElement("label"));

	rm_cat.type = "button";
	rm_cat.value = "Retirer catégorie";

	rm_cat.addEventListener('click', function(e) {
		remove_category(e);
	});

	ing_result.className = "ing_result";
	ing_choisis.className = "ing_choisis";
	//ing_choisis.id = "cat_"+name+"_ing_choisis"

	legend.innerText = name;

	input.type = "text";
	input.id = "search_" + global_index;

	label.for = "search_" + global_index;
	label.innerText = "Ingredient pour " + name;



	global_index++;
	category_name.value = '';


	input.addEventListener('keyup', function(e) {
		handle_key(e);
	});
	input.addEventListener('focus', function(e) {
		if(searchElement === e.target);
		else {
			searchElement = e.target;
			selectedResult = -1;
		}
		for(var i = 0; i < searchElements.length; i++) {
			searchElements[i].dispatchEvent(focus_changed_event);
		}
	});
	input.addEventListener('focus_changed', function(e) {
		if(searchElement === e.target);
		else {
			e.target.parentNode.parentNode.parentNode.children[3].style.display = "none";
			e.target.value = '';
		}
	});

	categories.push(name);
	searchElements.push(input);
	ingredients.push([]);
}

function manual_ing_insert(id, name, image, cat, quantite, unite) {
	var cat_index = 0;

	if(cat != "") {
		for(cat_index = 0;cat_index < categories.length; cat_index++) {
			if(categories[cat_index] == cat) {
				break;
			}
		}
		cat_index++;
		choisis = document.getElementById("cat_"+cat+"_ing_choisis");
	}

	var choisis = document.getElementById("categories").children[cat_index].children[4];

	console.log(cat_index);

	var div = choisis.appendChild(document.createElement('div'));

	var div_ingredient = div.appendChild(document.createElement('div'));
	var ingredient_image = div_ingredient.appendChild(document.createElement('img'));
	var ingredient_name = div_ingredient.appendChild(document.createElement('p'));
	var ingredient_id = div_ingredient.appendChild(document.createElement('input'));

	ingredient_image.src = image;
	ingredient_name.innerText = name;
	ingredient_id.type = "hidden";
	ingredient_id.value = id;

	var div_quantity_unit = div.appendChild(document.createElement('div'));
	var div_quantity = div_quantity_unit.appendChild(document.createElement('div'));
	var div_unit = div_quantity_unit.appendChild(document.createElement('div'));

	var quantity_label = div_quantity.appendChild(document.createElement('p'));
	quantity_label.innerText = 'Quantité : '

	var quantity = div_quantity.appendChild(document.createElement('input'));
	quantity.type = 'number';
	quantity.id = 'quantity' + id;
	quantity.style = 'width: 30px;'
	quantity.value = quantite;
	quantity.min = "0";

	var unit_label = div_unit.appendChild(document.createElement('p'));
	unit_label.innerText = 'Unité : ';

	var unit = div_unit.appendChild(document.createElement('input'));
	unit.type = 'text';
	unit.size = '7';
	unit.id = 'unit' + id;
	unit.value = unite

	var button = div_ingredient.appendChild(document.createElement('input'));
	button.type = 'button';
	button.value = ' - ';
	button.id = 'id_ing'+id;

	button.addEventListener('click', function(e) {
		removeChosen(e.target, id);
	});

	ingredients[cat_index].push(id);
}