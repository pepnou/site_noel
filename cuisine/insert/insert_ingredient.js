document.getElementById('insert_ingredient').addEventListener("click", function() {
	var nom_ingredient = document.getElementById('nom_ingredient'),
	image_ingredient = document.getElementById('image_ingredient');

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './insert_ingredient.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var request =	'nom_ingredient=' + encodeURIComponent(nom_ingredient.value) + 
					'&image_ingredient=' + encodeURIComponent(image_ingredient.value);

	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			console.log(xhr.responseText);
		}
	});

	xhr.send(request);

	return xhr;
});