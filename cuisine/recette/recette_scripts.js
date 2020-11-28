var ingredients = [];
var quantite_ini;
//var personnes;

var photo = [];
var photo_act = 0;

function setup_ing(quantite) {
	ingredients.push(quantite/quantite_ini);
}

function setup_pers(quantite) {
	quantite_ini = quantite;
}

function ing_change() {
	var q_act = document.getElementById('ing').value;
	if(q_act > 0)
	{
		for (var i = ingredients.length - 1; i >= 0; i--) {
			document.getElementById('i'+i).innerHTML = ingredients[i] * q_act;
		}
	}
	else
	{
		for (var i = ingredients.length - 1; i >= 0; i--) {
			document.getElementById('i'+i).innerHTML = 0;
		}
	}
}

function setup_photo(url_photo) {
	photo.push(url_photo);
}

function photo_min() {
	if(photo.length>1)
	{
		/*console.log("photo min : " + photo_act + " -> " + ((photo_act - 1 + photo.length) % photo.length));

		//var photo_element = document.getElementById('photo');
		var photo_div = document.getElementById('photo_div');

		photo_act = (photo_act + photo.length - 1) % photo.length;
		//photo_element.src = photo[photo_act];
		//photo_div.style = 'background-image: url('+photo[photo_act]+');';
		photo_div.style.backgroundImage = 'url('+photo[photo_act]+')';*/

		var photo_element = document.getElementById('photo');
		photo_act = (photo_act + photo.length - 1) % photo.length;

		photo_element.src = photo[photo_act];
	}
	
	
}

function photo_plus() {
	if(photo.length>1)
	{
		/*console.log("photo plus : " + photo_act + " -> " + ((photo_act + 1) % photo.length));
		

		//var photo_element = document.getElementById('photo');
		var photo_div = document.getElementById('photo_div');

		photo_act = (photo_act + 1) % photo.length;
		//photo_element.src = photo[photo_act];
		//photo_div.style = 'background-image: url('+photo[photo_act]+');';
		photo_div.style.backgroundImage = 'url('+photo[photo_act]+')';*/

		var photo_element = document.getElementById('photo');
		photo_act = (photo_act + 1) % photo.length;

		photo_element.src = photo[photo_act];
	}
}

var ing_index = 0;
function display_ingredient(nom, photo, quantite, unite, category) {
	var ing = document.getElementById("ingredient");

	var cat;
	if(category.length == 0) {
		cat = ing;
	} else {
		var cat = document.getElementById("category" + category);

		if(cat == null) {
			cat = ing.appendChild(document.createElement("fieldset"));
			var legend = cat.appendChild(document.createElement("legend"));

			cat.id = "category" + category;
			legend.innerHTML = category;
		}
	}

	var div1 = cat.appendChild(document.createElement("div"));
	var div2 = div1.appendChild(document.createElement("div"));

	var img = div2.appendChild(document.createElement("img"));
	var p1 = div2.appendChild(document.createElement("p"));
	var p2 = div2.appendChild(document.createElement("p"));
	var p3 = div2.appendChild(document.createElement("p"));

	img.src = photo;

	p1.innerText = nom;
	p2.innerText = quantite;
	p2.id = "i" + ing_index;
	p3.innerText = unite;

	setup_ing(quantite);

				/*
				<img src="<?php echo $get_info[1]; ?>">

				<p><?php echo $get_info[0]; ?></p>
				<p id="<?php echo 'i'.$i; ?>"><?php echo $get_info[2]; ?></p>
				<p><?php echo ' '.$get_info[3]; ?></p>

				<script type="text/javascript">
					setup_ing(<?php echo $get_info[2]; ?>);
				</script>
				*/
	ing_index++;
}




var fav = 0;
var recette;
function fav_init(fav_i, r) {
	fav = fav_i;
	recette = r;

	fav_update_img();
}

function fav_change() {
	fav = (fav + 1) % 2;

	fav_update_img();
	fav_update_db();
}

function fav_update_db() {
	var xhr = new XMLHttpRequest();
    xhr.open('POST', './recette_fav.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	var request =	'recette=' + recette + 
					'&favori=' + fav ;

	xhr.send(request);
}

function fav_update_img() {
	var fav_img = document.getElementById("fav_img");

	if(fav) {
		fav_img.src = "star_lit.png";
	} else {
		fav_img.src = "star_unlit.png";
	}
	fav_img.style = "height: 20px";
}