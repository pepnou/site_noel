var ingredients = [];
var quantite_ini;
//var personnes;

var photo = [];
var photo_act = 0;

/*function setup_ing(quantite) {
	ingredients.push(quantite);
}*/

/*function setup_pers(nbr) {
	personnes = nbr;
}*/

/*function ing_min() {
	if(personnes > 1)
	{
		for (var i = ingredients.length - 1; i >= 0; i--) {
			ingredients[i] = ingredients[i]/personnes * ( personnes - 1 );
			document.getElementById('i'+i).innerHTML = ingredients[i];
		}
		personnes--;
		document.getElementById('ing').innerHTML = personnes;
	}
}

function ing_plus() {
	for (var i = ingredients.length - 1; i >= 0; i--) {
		ingredients[i] = ingredients[i]/personnes * ( personnes + 1 );
		document.getElementById('i'+i).innerHTML = ingredients[i];
	}
	personnes++;
	document.getElementById('ing').innerHTML = personnes;
}*/


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
		var photo_element = document.getElementById('photo')/*,
			photo_div = document.getElementById('photo_div')*/;

		photo_act = (photo_act + photo.length - 1) % photo.length;
		photo_element.src = photo[photo_act];
		//photo_div.style = 'background-image: url('+photo[photo_act]+');';
	}
}

function photo_plus() {
	if(photo.length>1)
	{
		var photo_element = document.getElementById('photo'),
			photo_div = document.getElementById('photo_div');

		photo_act = (photo_act + 1) % photo.length;
		photo_element.src = photo[photo_act];
		photo_div.style = 'background-image: url('+photo[photo_act]+');';
	}
}

function photo_load() {
	alert('test');
	var photo_element = document.getElementById('photo'),
		photo_div = document.getElementById('photo_div'),
		photo_cont = document.getElementById('preparation');

	var photo_h = photo_element.clientHeight,
		photo_w = photo_element.clientWidth,
		r = photo_w/photo_h,
		max_h = 500,
		max_w = photo_cont.clientWidth,
		w,h;

	if(max_w/r > max_h)
	{
		h = max_h;
		w = r * h;
	}
	else
	{
		w = max_w;
		h = w / r;
	}

	photo_div.style  = 'background-image: url('+photo[photo_act]+');'+'width: '+w+'px;'+'height: '+h+'px;';

	console.log(w);
	console.log(h);
	console.log(r);
	console.log(max_h);
	console.log(max_w);
}