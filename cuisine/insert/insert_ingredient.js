function insert_ingredient() { // Effectue une requête et récupère les résultats
		
	var nom_ingredient = document.getElementById('nom_ingredient'),
		image_ingredient = document.getElementById('image_ingredient');

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './insert_ingredient.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var request =	'nom_ingredient=' + nom_ingredient.value + 
					'&image_ingredient=' + image_ingredient.value;

	xhr.addEventListener('readystatechange', function() {
    	if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            console.log(xhr.responseText);
    	}
    });

	xhr.send(request);

	return xhr;
}