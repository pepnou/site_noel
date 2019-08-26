var tags_array = [];

function tag_clicked(id) {
	var checkbox = document.getElementById('tag-'+id);
	var ids_tags = document.getElementById('ids_tags');

	var index = tags_array.indexOf(id);
	
	if(checkbox.checked)
	{
		if(index == -1)
		{
			tags_array.push(id);
		}
	}
	else
	{
		if(index != -1)
		{
			tags_array.splice(index,1);
		}
	}
	
	ids_tags.value = tags_array.join('|');

	console.log(ids_tags.value);
}