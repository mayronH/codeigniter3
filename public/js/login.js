$(function () {
	$("#login_form").submit(function () {
		$.ajax({
			type: "post",
			url: BASE_URL + "restrict/ajaxLogin",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function () {
				clearErrors();
				$("#btn_login")
					.parent()
					.siblings(".help-block")
					.html(loadingImage("Verificando..."));
			},
			success: function (response) {
				if (response["status"] == 1) {
					$("#btn_login")
						.parent()
						.siblings(".help-block")
						.html(loadingImage("Logando..."));
					window.location = BASE_URL + "restrict";
				} else {
					showErrors(response["error_list"]);
				}
			},
			error: function (response) {
				console.log(response);
			},
		});

		return false;
	});
});
