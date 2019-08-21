(function() {
	var searchElement = document.getElementById('ingredient'),
		results = document.getElementById('ing_result'),
		choisis = document.getElementById('ing_choisis'),
		ids_ing = document.getElementById('ids_ing'),
		selectedResult = -1, // Permet de savoir quel résultat est sélectionné : -1 signifie "aucune sélection"
		previousRequest, // On stocke notre précédente requête dans cette variable
		previousValue = searchElement.value; // On fait de même avec la précédente valeur
	
	var ingredients = [];
	var ids = [];
	
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

		console.log(response);
		console.log(response.length);
	
		results.style.display = (response.length > 4) ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultats
	
		if (response.length > 4) { // On ne modifie les résultats que si on en a obtenu

			response = response.split('||');
			response[0] = response[0].split('|');
			response[1] = response[1].split('|');
			response[2] = response[2].split('|');

			ids = response[0];

			var responseLen = response[0].length;

			results.innerHTML = ''; // On vide les résultats
	
			for (var i = 0, div ; i < responseLen ; i++) {
	
				div = results.appendChild(document.createElement('div'));

				if(response[2][i] == 'NULL') {
					div.innerHTML = '<img src="https://upload.wikimedia.org/wikipedia/commons/5/59/Empty.png">';
				} else {
					div.innerHTML = '<img src="' + response[2][i] + '">';
				}

				div.innerHTML += '<p>' + response[1][i] + '</p>';
				//div.innerHTML += '<input style="width: 30px;" type="number" name="' + 'quantity' + i + '" id="' + 'quantity' + i + '">';
				//div.innerHTML += '<input type="text" size="5" name="' + 'unit' + i + '" id="' + 'unit' + i + '">';

	
				div.addEventListener('click', function(e) {
					chooseResult(e.target);
				});
	
			}
	
		}
	
	}
	
	function chooseResult(result) { // Choisi un des résultats d'une requête et gère tout ce qui y est attaché

		if(result.tagName != 'DIV')
			result = result.parentNode;

		var divs = results.getElementsByTagName('div');
		divs = Array.from(divs)
		
		var pos = divs.indexOf(result);

		if(!ingredients.find(function(element) {
			return element == ids[pos];
		})) {
			var div = choisis.appendChild(document.createElement('div'));
			div.innerHTML = result.innerHTML;

			var quantity = div.appendChild(document.createElement('input'));
			quantity.type = 'number';
			quantity.id = 'quantity' + pos;
			quantity.style = 'width: 30px;'

			var unit = div.appendChild(document.createElement('input'));
			unit.type = 'text';
			unit.size = '7';
			unit.id = 'unit' + pos;

			var button = div.appendChild(document.createElement('input'));
			button.type = 'button';
			button.value = ' - ';
			button.id = 'id_ing'+ids[pos];

			button.addEventListener('click', function(e) {
				removeChosen(e.target);
			});

			ingredients.push(ids[pos]);

			ids_ing.value = ingredients.join('|');
		}

		searchElement.value = previousValue = '';
		results.style.display = 'none'; // On cache les résultats
		result.className = ''; // On supprime l'effet de focus
		selectedResult = -1; // On remet la sélection à "zéro"
		searchElement.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue
	}



	function removeChosen(result) {
		
		var id = result.id.slice(6);
		ingredients.splice(ingredients.indexOf(id),1);
		ids_ing.value = ingredients.join('|');

		result.parentNode.parentNode.removeChild(result.parentNode);
	}
	
	
	
	searchElement.addEventListener('keyup', function(e) {
	
		var divs = results.getElementsByTagName('div');
	
		if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche "haut"
	
			divs[selectedResult--].className = 'horz align-sec align-prim';
	
			if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
				divs[selectedResult].className = 'horz align-sec align-prim result_focus';
			}
	
		}
	
		else if (e.keyCode == 40 && selectedResult < divs.length - 1) { // Si la touche pressée est la flèche "bas"
	
			results.style.display = 'block'; // On affiche les résultats
	
			if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
				divs[selectedResult].className = '';
			}
	
			divs[++selectedResult].className = 'result_focus';
	
		}
	
		else if (e.keyCode == 13 && selectedResult > -1) { // Si la touche pressée est "Entrée"
	
			chooseResult(divs[selectedResult]);
	
		}
	
		else if (searchElement.value != previousValue) { // Si le contenu du champ de recherche a changé
	
			previousValue = searchElement.value;
	
			if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
				previousRequest.abort(); // Si on a toujours une requête en cours, on l'arrête
			}
	
			previousRequest = getResults(previousValue); // On stocke la nouvelle requête
	
			selectedResult = -1; // On remet la sélection à "zéro" à chaque caractère écrit
	
		}
	
	});
	
})();