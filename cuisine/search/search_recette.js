window.onresize = update_height;


function getResultsR() { // Effectue une requête et récupère les résultats
		
	var nom = document.getElementById('nom'),
		favori = document.getElementById('favori'),
		printemps = document.getElementById('printemps'),
		ete = document.getElementById('ete'),
		automne = document.getElementById('automne'),
		hiver = document.getElementById('hiver'),
		//type = document.getElementById('type'),
		utilisateur = document.getElementById('utilisateur'),
		pays = document.getElementById('pays'),
		facilite = document.getElementById('facilite'),
		cout = document.getElementById('cout'),
		temps_prep = document.getElementById('temps_prep'),
		ingredient = document.getElementById('ids_ing'),
		tag = document.getElementById('tag');
		/*video = document.getElementById('video')/*,
		type = document.getElementById('')*/;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './search_recette.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.addEventListener('readystatechange', function() {
    	if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            displayResultsR(xhr.responseText);
    	}
    });
	
	//var saison = printemps.checked + '|' + ete.checked + '|' + automne.checked + '|' + hiver.checked;

	var saison = [];
	if(printemps.checked)
		saison.push(1);
	if(ete.checked)
		saison.push(2);
	if(automne.checked)
		saison.push(3);
	if(hiver.checked)
		saison.push(4);
	saison = saison.join('|');


	var request =	'nom=' + nom.value + 
					'&favori=' + favori.checked + 
					'&saison=' + saison + 
					//'&type=' + type.value + 
					'&utilisateur=' + utilisateur.value + 
					'&pays=' + pays.value + 
					'&facilite=' + facilite.value + 
					'&cout=' + cout.value + 
					'&temps_prep=' + temps_prep.value + 
					'&ingredient=' + ingredient.value + 
					'&tag=' + tag.value/* + 
					'&video=' + video.checked*/;

	//console.log(request);

    xhr.send(request);
	//xhr.send('param1=' + value1 + '&param2=' + value2);

    return xhr;
}
	
function displayResultsR(response) { // Affiche les résultats d'une requête

	var results = document.getElementById('recette');

	//results.style.display = response.length ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultat
	//console.log('response : ' + response);

	results.innerHTML = ''; // On vide les résultats

	if (response != '') { // On ne modifie les résultats si on en a obtenu
		console.log(response);

		response = response.split('||');
		response[0] = response[0].split('|');
		response[1] = response[1].split('|');
		response[2] = response[2].split('|');

		var responseLen = response[0].length;

		for (var i = 0, div ; i < responseLen ; i++) {

			div = results.appendChild(document.createElement('div'));
			div.className = '';

			var id = response[0][i];
			var name = response[1][i];
			var image;
			if(response[2][i] == 'NULL') {
				image = "/site_noel/general/Empty.png"
			}
			else {
				image = response[2][i];
			}

			var link = div.appendChild(document.createElement('a'));
			var div_int = link.appendChild(document.createElement('div'));
			var nameElement = div_int.appendChild(document.createElement('p'));
			var imageElement = div_int.appendChild(document.createElement('img'));

			link.href = '/site_noel/cuisine/recette/recette.php?id=' + id;
			nameElement.innerText = name;
			imageElement.src = image;
		}

		update_height();
	}

}

function update_height() {
	console.log("updating");

	var results = document.getElementById('recette');
	for (var i = 0; i < results.children.length; i++) {
		var div = results.children[i];
		var div_int = div.children[0].children[0];

		div_int.style.height = "unset";
	}
	for (var i = 0; i < results.children.length; i++) {
		var div = results.children[i];
		var div_int = div.children[0].children[0];

		var height = (div.offsetHeight - 20 - 2).toString() + "px";
		div_int.style.height = height;
	}	
}