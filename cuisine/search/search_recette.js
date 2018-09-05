
function getResultsR() { // Effectue une requête et récupère les résultats
		
	var nom = document.getElementById('nom'),
		favori = document.getElementById('favori'),
		printemps = document.getElementById('printemps'),
		ete = document.getElementById('ete'),
		automne = document.getElementById('automne'),
		hiver = document.getElementById('hiver'),
		type = document.getElementById('type'),
		utilisateur = document.getElementById('utilisateur'),
		pays = document.getElementById('pays'),
		facilite = document.getElementById('facilite'),
		cout = document.getElementById('cout'),
		temps_prep = document.getElementById('temps_prep'),
		ingredient = document.getElementById('ids_ing'),
		tag = document.getElementById('tag'),
		video = document.getElementById('video')/*,
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

    xhr.send('nom='+nom.value + '&favori='+favori.checked + '&saison='+saison + '&type='+type.value + '&utilisateur='+utilisateur.value + '&pays='+pays.value + '&facilite='+facilite.value + '&cout='+cout.value + '&temps_prep='+temps_prep.value + '&ingredient='+ingredient.value + '&tag='+tag.value + '&video='+video.checked);
	//xhr.send('param1=' + value1 + '&param2=' + value2);

    return xhr;
}
	
function displayResultsR(response) { // Affiche les résultats d'une requête

	var results = document.getElementById('recette');

	//results.style.display = response.length ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultat
	//console.log(response);

	results.innerHTML = ''; // On vide les résultats

    if (response != '') { // On ne modifie les résultats si on en a obtenu

        response = response.split('||');
        response[0] = response[0].split('|');
        response[1] = response[1].split('|');
        response[2] = response[2].split('|');

        var responseLen = response[0].length;

        for (var i = 0, div ; i < responseLen ; i++) {

        	div = results.appendChild(document.createElement('div'));
        	div.className = '';

        	if(response[2][i] == 'NULL')
        		div.innerHTML = '<a href="../recette/recette.php?id='+response[0][i]+'"><div><p>'+response[1][i]+'</p><img src="https://upload.wikimedia.org/wikipedia/commons/5/59/Empty.png"></div></a>';
        	else
        	{
        		//console.log(response[2][i]);
        		div.innerHTML = '<a href="../recette/recette.php?id='+response[0][i]+'"><div><p>'+response[1][i]+'</p><img src="'+response[2][i]+'"></div></a>';
        	}
        }
    }

}

