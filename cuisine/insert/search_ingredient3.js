/*var searchElements = [document.getElementById('ingredient')];

searchElements[0].addEventListener("cat", function(){
	console.log("test");
});

var event = new CustomEvent("cat");

document.onclick = function(){searchElements[0].dispatchEvent(event);};*/






var searchElement = document.getElementById('ingredient'),
	/*results = document.getElementById('ing_result'),
	choisis = document.getElementById('ing_choisis'),*/
	insert_ingredient_form = document.getElementById('insert_ingredient_form'),
	previousRequest;

var selectedResult = -1;

var ingredients = [];
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
		e.target.parentNode.parentNode.parentNode.children[2].style.display = "none";
		e.target.value = '';
	}
});

function handle_key(e) {
	var results = e.target.parentNode.parentNode.parentNode.children[2];
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

	/*if (e.keyCode == 13 && selectedResult > -1) { // Si la touche pressée est "Entrée"
		chooseResult(divs[selectedResult].children[2].value, divs[selectedResult].children[1].innerText, divs[selectedResult].children[0].src);
		return;
	}*/

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
	var results = searchElement.parentNode.parentNode.parentNode.children[2];

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
		div.id = "ingredient_form";

		div.children[0].children[1].addEventListener("click", function() {
			add_ingredient();
		});
	}
}

function displayResult(id, name, image) {
	var results = searchElement.parentNode.parentNode.parentNode.children[2];

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

function add_ingredient() {
	var form = document.getElementById("ingredient_form");

	var nom_ingredient = searchElement.value,
	image_ingredient = form.children[0].children[0].children[1].value;

	var request =	'nom_ingredient=' + encodeURIComponent(nom_ingredient) + 
					'&image_ingredient=' + encodeURIComponent(image_ingredient);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './insert_ingredient.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var image = (image_ingredient.length == 0)? '/site_noel/general/Empty.png':image_ingredient;

	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			if(xhr.responseText != "Allready inserted") {
				chooseResult(xhr.responseText ,nom_ingredient.charAt(0).toUpperCase() + nom_ingredient.slice(1).toLowerCase(), image);
			}

		}
	});

	xhr.send(request);
	return xhr;
}

function chooseResult(id, name, image) { // Choisi un des résultats d'une requête et gère tout ce qui y est attaché

	if(!ingredients.find(function(element) { return element == id; } ) ) {

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

		ingredients.push(id);
	}

	searchElement.value = '';
	results.style.display = 'none'; // On cache les résultats
	selectedResult = -1; // On remet la sélection à "zéro"
	searchElement.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue
}

function removeChosen(result, id) {
	
	var index = ingredients.indexOf(id);
	ingredients.splice(index,1);

	result.parentNode.parentNode.parentNode.removeChild(result.parentNode.parentNode);
}









var category_name = document.getElementById('new_category');
var global_div = document.getElementById("catégories");
var global_index = 0;

document.getElementById("add_new_category").addEventListener("click", function() {
	add_category();
});

function add_category() {
	if(!categories.find(function(element) { return element == category_name.value; } )) {
		var name = category_name.value;

		var fieldset = global_div.appendChild(document.createElement("fieldset"));

		var legend = fieldset.appendChild(document.createElement("legend"));
		var div = fieldset.appendChild(document.createElement("div"));
		fieldset.appendChild(document.createElement("div"));
		fieldset.appendChild(document.createElement("div"));

		div = div.appendChild(document.createElement("div"));

		var input = div.appendChild(document.createElement("input"));
		var label = div.appendChild(document.createElement("label"));

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
				e.target.parentNode.parentNode.parentNode.children[2].style.display = "none";
				e.target.value = '';
			}
		});

		categories.push(name);
		searchElements.push(input);
	}
}