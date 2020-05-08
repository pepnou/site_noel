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

function init(index, time) {
	parsed_time = time.split(':');
	minute[index] = parseInt(parsed_time[0], 10) * 60 + parseInt(parsed_time[1], 10);

	update_temps(index)
}

function update_temps(index) {
	var time = '';
	var heure = document.getElementById('heure' + index.toString());

	heure.innerHTML = '';

	var tmp = minute[index] / 60;

	tmp = Math.trunc(tmp);

	if(tmp < 10) {
		heure.innerHTML += '0' + tmp.toString() + 'h';
		time += '0' + tmp.toString() + ':';
	} else {
		heure.innerHTML += tmp.toString() + 'h';
		time += tmp.toString() + ':';
	}

	tmp = minute[index] % 60;

	if(tmp < 10) {
		heure.innerHTML += '0' + tmp.toString() + 'min';
		time += '0' + tmp.toString() + ':';
	} else {
		heure.innerHTML += tmp.toString() + 'min';
		time += tmp.toString() + ':';
	}

	time += '00'

	switch(index) {
		case 0:
			document.getElementById('temps_prep').value = time;
			break;
		case 1:
			document.getElementById('temps_cuis').value = time;
			break;
	}
}