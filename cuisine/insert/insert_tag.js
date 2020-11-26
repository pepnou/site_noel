var tags = document.getElementById("tags");
var tag = document.getElementById("tag");

document.getElementById("AjoutTag").addEventListener("click", function() {

	var xhr = new XMLHttpRequest();
	xhr.open('POST', './insert_tag.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var request =	'tag=' + encodeURIComponent(tag.value);

	console.log(request);

	xhr.addEventListener('readystatechange', function() {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			console.log(xhr.responseText);
			displayTag(xhr.responseText);
		}
	});

	xhr.send(request);

	return xhr;
});

function displayTag (response) {

	if (response != '') {
		response = response.split('||');
		//console.log(response[0] + "   " + response[1]);

		var div = tags.appendChild(document.createElement('div'));
		var checkbox = div.appendChild(document.createElement('input'));
		var label = div.appendChild(document.createElement('label'));

		div.style = "flex-direction: row;";

		checkbox.type = "checkbox";
		checkbox.id = "tag-" + response[0];
		checkbox.onclick = function(event) {tag_clicked(response[0])};

		label.htmlFor = checkbox.id;
		label.innerText = response[1];
	}
}