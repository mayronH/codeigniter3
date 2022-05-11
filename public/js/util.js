const BASE_URL = "http://localhost/codeigniter3/";

function clearErrors() {
	$(".has-error").removeClass("has-error");
	$(".help-block").html("");
}

function showErrors(error_list) {
	clearErrors();

	$.each(error_list, function (id, message) {
		$(id).parent().parent().addClass("has-error");
		$(id).parent().siblings(".help-block").html(message);
	});
}

function loadingImage(message = "") {
	return "<i class='fa fa-circle-o-notch fa-spin'></i>&nbsp;" + message;
}

function uploadImage(input_file, img, input_path) {
	src_before = img.attr("src");
	img_file = input_file[0].files[0];

	form_data = new FormData();
	form_data.append("image_file", img_file);

	$.ajax({
		url: BASE_URL + "restrict/ajaxImportImage",
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: "POST",
		beforeSend: function () {
			clearErrors();
			input_path.siblings(".help-block").html(loadingImage("Carregando..."));
		},
		success: function (response) {
			if (response["status"] == 1) {
				img.attr("src", response["img_path"]);
				input_path.val(response["img_path"]);
				input_path.siblings(".help-block").html("");
			} else {
				img.attr("src", src_before);
				input_path.siblings(".help-block").html(response["error"]);
			}
		},
		error: function (response) {
			img.attr("src", src_before);
			console.log(response);
		},
	});
}
