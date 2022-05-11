$(function () {
	$("#btn_add_course").click(function () {
		clearErrors();
		$("#form_course")[0].reset();
		$("#course_img_path").attr("src", "");
		$("#modal_course").modal();
	});

	$("#btn_add_member").click(function () {
		clearErrors();
		$("#form_member")[0].reset();
		$("#member_photo_path").attr("src", "");
		$("#modal_member").modal();
	});

	$("#btn_add_user").click(function () {
		clearErrors();
		$("#form_user")[0].reset();
		$("#modal_user").modal();
	});

	$("#btn_upload_course_img").change(function () {
		uploadImage($(this), $("#course_img_path"), $("#course_img"));
	});

	$("#btn_upload_member_photo").change(function () {
		uploadImage($(this), $("#member_photo_path"), $("#member_photo"));
	});

	$("#form_course").submit(function () {
		$.ajax({
			url: BASE_URL + "course/saveCourse",
			dataType: "json",
			type: "POST",
			data: $(this).serialize(),
			beforeSend: function () {
				clearErrors();
				$("#btn_save_course")
					.siblings(".help-block")
					.html(loadingImage("Verificando..."));
			},
			success: function (response) {
				if (response["status"] == 1) {
					$("#modal_course").modal("hide");
					swal("Sucesso", "Curso adicionado com sucesso!", "success");
					dt_courses.ajax.reload();
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

	$("#form_member").submit(function () {
		$.ajax({
			url: BASE_URL + "team/saveMember",
			dataType: "json",
			type: "POST",
			data: $(this).serialize(),
			beforeSend: function () {
				clearErrors();
				$("#btn_save_member")
					.siblings(".help-block")
					.html(loadingImage("Verificando..."));
			},
			success: function (response) {
				if (response["status"] == 1) {
					$("#modal_member").modal("hide");
					swal("Sucesso", "Membro adicionado com sucesso!", "success");
					dt_team.ajax.reload();
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

	$("#form_user").submit(function () {
		$.ajax({
			url: BASE_URL + "user/saveUser",
			dataType: "json",
			type: "POST",
			data: $(this).serialize(),
			beforeSend: function () {
				clearErrors();
				$("#btn_save_user")
					.siblings(".help-block")
					.html(loadingImage("Verificando..."));
			},
			success: function (response) {
				if (response["status"] == 1) {
					$("#modal_user").modal("hide");
					swal("Sucesso", "Usuário adicionado com sucesso!", "success");
					dt_users.ajax.reload();
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

	$("#btn_current_user").click(function () {
		$.ajax({
			url: BASE_URL + "user/editUser",
			dataType: "json",
			type: "POST",
			data: { user_id: $("#btn_current_user").attr("data") },
			success: function (response) {
				clearErrors();
				$("#form_user")[0].reset();
				$.each(response["input"], function (id, value) {
					$("#" + id).val(value);
				});
				$("#modal_user").modal();
			},
			error: function (response) {
				console.log(response);
			},
		});

		return false;
	});

	function activeBtnCourse() {
		$(".btn-edit-course").click(function () {
			$.ajax({
				url: BASE_URL + "course/editCourse",
				dataType: "json",
				type: "POST",
				data: { course_id: $(this).attr("course_id") },
				success: function (response) {
					clearErrors();
					$("#form_course")[0].reset();
					$.each(response["input"], function (id, value) {
						$("#" + id).val(value);
					});

					$("#course_img_path").attr("src", response["img"]["course_img"]);
					$("#modal_course").modal();
				},
				error: function (response) {
					console.log(response);
				},
			});
		});

		$(".btn-delete-course").click(function () {
			const course_id = $(this).attr("course_id");

			swal({
				title: "Atenção",
				text: "Tem certeza que quer realizar essa ação?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtonText: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: BASE_URL + "course/deleteCourse",
						dataType: "json",
						type: "POST",
						data: { course_id: course_id },
						success: function () {
							swal("Sucesso", "Ação executada com sucesso", "success");
							dt_courses.ajax.reload();
						},
						error: function (response) {
							console.log(response);
						},
					});
				}
			});
		});
	}

	function activeBtnMember() {
		$(".btn-edit-member").click(function () {
			$.ajax({
				url: BASE_URL + "team/editMember",
				dataType: "json",
				type: "POST",
				data: { member_id: $(this).attr("member_id") },
				success: function (response) {
					clearErrors();
					$("#form_member")[0].reset();
					$.each(response["input"], function (id, value) {
						$("#" + id).val(value);
					});

					$("#member_photo_path").attr("src", response["img"]["member_photo"]);
					$("#modal_member").modal();
				},
				error: function (response) {
					console.log(response);
				},
			});
		});

		$(".btn-delete-member").click(function () {
			const member_id = $(this).attr("member_id");

			swal({
				title: "Atenção",
				text: "Tem certeza que quer realizar essa ação?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtonText: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: BASE_URL + "team/deleteMember",
						dataType: "json",
						type: "POST",
						data: { member_id: member_id },
						success: function () {
							swal("Sucesso", "Ação executada com sucesso", "success");
							dt_team.ajax.reload();
						},
						error: function (response) {
							console.log(response);
						},
					});
				}
			});
		});
	}

	function activeBtnUser() {
		$(".btn-edit-user").click(function () {
			$.ajax({
				url: BASE_URL + "user/editUser",
				dataType: "json",
				type: "POST",
				data: { user_id: $(this).attr("user_id") },
				success: function (response) {
					clearErrors();
					$("#form_user")[0].reset();
					$.each(response["input"], function (id, value) {
						$("#" + id).val(value);
					});
					$("#modal_user").modal();
				},
				error: function (response) {
					console.log(response);
				},
			});
		});

		$(".btn-delete-user").click(function () {
			const user_id = $(this).attr("user_id");

			swal({
				title: "Atenção",
				text: "Tem certeza que quer realizar essa ação?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtonText: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: BASE_URL + "user/deleteUser",
						dataType: "json",
						type: "POST",
						data: { user_id: user_id },
						success: function () {
							swal("Sucesso", "Ação executada com sucesso", "success");
							dt_users.ajax.reload();
						},
						error: function (response) {
							console.log(response);
						},
					});
				}
			});
		});
	}

	const dt_courses = $("#dt_courses").DataTable({
		language: {
			url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json",
		},
		autoWidth: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: BASE_URL + "course/listCourses",
			type: "POST",
		},
		columnDefs: [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		drawCallback: function () {
			activeBtnCourse();
		},
	});

	const dt_team = $("#dt_team").DataTable({
		language: {
			url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json",
		},
		autoWidth: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: BASE_URL + "team/listMembers",
			type: "POST",
		},
		columnDefs: [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		drawCallback: function () {
			activeBtnMember();
		},
	});

	const dt_users = $("#dt_users").DataTable({
		language: {
			url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json",
		},
		autoWidth: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: BASE_URL + "user/listUsers",
			type: "POST",
		},
		columnDefs: [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		drawCallback: function () {
			activeBtnUser();
		},
	});
});
