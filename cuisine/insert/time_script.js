var minute = [];
minute[0] = 60;
minute[1] = 60;

function minus(index, timestep) {
	minute[index] -= timestep;
	minute[index] = Math.max(minute[index], 0);

	update_temps(index);
}

function plus(index, timestep) {
	minute[index] += timestep;
	minute[index] = Math.min(minute[index], 1439);
	
	update_temps(index);
}

function update_temps(index) {
	var heure = document.getElementById('heure' + index.toString());

	heure.innerHTML = '';

	var tmp = minute[index] / 60;

	tmp = Math.trunc(tmp);

	if(tmp < 10)
		heure.innerHTML += '0' + tmp.toString() + 'h';
	else
		heure.innerHTML += tmp.toString() + 'h';

	tmp = minute[index] % 60;

	if(tmp < 10)
		heure.innerHTML += '0' + tmp.toString() + 'min';
	else
		heure.innerHTML += tmp.toString() + 'min';

	document.getElementById('temps_prep').value = minute;
	switch(index) {
		case 0:
			document.getElementById('temps_prep').value = minute[index];
			break;
		case 1:
			document.getElementById('temps_cuis').value = minute[index];
			break;
	}
}