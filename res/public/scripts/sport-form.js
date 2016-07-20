var lastFile = null;
$('#fileupload').fileupload({
	url : apiUrl + '/gossi.trixionary/upload',
	dataType : 'json',
	acceptFileTypes : /(\.|\/)(jpe?g|png)$/i,
	done : function(e, data) {
		lastFile = data.result;
		if (lastFile.error) {
			$('#uploaded').text(lastFile.error).addClass('text-danger');
		} else {
			$('#uploaded').text(lastFile.filename).removeClass('text-danger');
			$('#upload-delete').removeClass('hidden');
			$('#preview').attr('src', lastFile.url).removeClass('hidden');
			$('#filename').val(lastFile.filename);
		}

		$('#progress').addClass('hidden');
	},
	progressall : function(e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#progress .progress-bar').css('width', progress + '%');
	}
}).on('fileuploadadd', function(e, data) {
	if (lastFile !== null && data.files[0].name !== lastFile.filename) {
		deletePicture(lastFile);
		$('#filename').val('');
		$('#upload-delete').addClass('hidden');
		$('#preview').attr('src', '').addClass('hidden');
	}
	$('#skill_picture_delete').val('');
	$('#progress').removeClass('hidden');
});
$('#upload-delete').on('click', function(e) {
	if (lastFile) {
		deletePicture(lastFile);
	}
	$('#skill_picture_delete').val('1');
	$('#filename').val('');
	$('#uploaded').text('');
	$('#preview').addClass('hidden');
	$('#upload-delete').addClass('hidden');
});

function deletePicture(file) {
	var xhr = new XMLHttpRequest();
	xhr.open('DELETE', apiUrl + '/gossi.trixionary/upload/' + file.filename, true);
	xhr.send();
	return xhr;
}

// ------
/*
 * acceptFileTypes: /(\.|\/)(jpe?g|png)$/i, done: function (e, data) { lastFile =
 * data.result.files[0]; if (lastFile.error) {
 * $('#uploaded').text(lastFile.error).addClass('text-danger'); } else {
 * $('#uploaded').text(lastFile.name).removeClass('text-danger');
 * $('#filename').val(lastFile.name); $('#upload-delete').removeClass('hidden');
 * $('#sequence_delete').val(''); } $('#preview').attr('src',
 * lastFile.url).removeClass('hidden'); $('#progress').addClass('hidden');
 * $('#fileupload').val(''); }, progressall: function (e, data) { var progress =
 * parseInt(data.loaded / data.total * 100, 10); $('#progress
 * .progress-bar').css( 'width', progress + '%' ); } }).on('fileuploadadd',
 * function (e, data) { if (lastFile !== null && data.files[0].name !==
 * lastFile.name) { var xhr = new XMLHttpRequest(); xhr.open('DELETE',
 * lastFile.deleteUrl, true); xhr.send(); $('#filename').val(''); }
 * $('#progress').removeClass('hidden'); }); $('#upload-delete').on('click',
 * function (e) { $('#sequence_delete').val('1'); $('#uploaded').text('');
 * $('#preview').addClass('hidden'); $('#upload-delete').addClass('hidden'); });
 */