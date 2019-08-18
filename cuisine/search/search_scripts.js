var minute = 60;

function minus() {
	if(minute > 0)
	{
		minute -=30;
	}
	update_temps();
}

function plus() {
	if(minute < 1410)
	{
		minute += 30;
	}
	update_temps();
}

function update_temps() {
	var h = document.getElementById('heure');

	h.innerHTML = '';

	var tmp = minute/60;
	tmp = Math.trunc(tmp);
	if(tmp<10)
		h.innerHTML += '0'+tmp.toString()+'h';
	else
		h.innerHTML +=tmp.toString()+'h';

	tmp = minute%60;
	if(tmp < 10)
		h.innerHTML += '0'+tmp.toString()+'min';
	else
		h.innerHTML += tmp.toString()+'min';

	document.getElementById('temps_prep').value = minute;
	
	getResultsR();
}

function disable_temps() {
	if(document.getElementById('disable-temps').checked)
	{
		document.getElementById('minusB').disabled = false;
		document.getElementById('plusB').disabled = false;
		document.getElementById('style_temps').innerHTML = '#temps > * {color: #000;}';
		document.getElementById('temps_prep').value = minute;
	}
	else
	{
		document.getElementById('minusB').disabled = true;
		document.getElementById('plusB').disabled = true;
		document.getElementById('style_temps').innerHTML = '#temps > * {color: orange;}';
		document.getElementById('temps_prep').value = -1;
	}
	getResultsR();
}



var tags = [];

function tag_clicked(id) {
	var checkbox = document.getElementById('tag-'+id);
	var tag = document.getElementById('tag');

	var index = tags.indexOf(id);
	
	if(checkbox.checked)
	{
		if(index == -1)
		{
			tags.push(id);
		}
	}
	else
	{
		if(index != -1)
		{
			tags.splice(index,1);
		}
	}
	
	tag.value = tags.join('|');

	getResultsR();
}