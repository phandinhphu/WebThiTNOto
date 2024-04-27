/**
 * Path: admin/assets/js/exam.js
 * Description: This file is used to handle the event add of the exam page
*/
$(document).ready(function () {
	$("#js-save").click(function () {
		var examName = $("#exam-name").val();
		var examTime = $("#exam-time").val();
		var examStatus = $("#exam-status").val();
		$.ajax({
			url: "exam/add-exam.php",
			type: "POST",
			data: {
				examName: examName,
				examTime: examTime,
				examStatus: examStatus,
			},
			success: function (response) {
				if (response.status == 1) {
					alert("Add exam successfully");
					$("#addExamModal").modal("hide");
					location.reload();
				} else {
					alert("Add exam failed");
				}
			},
		});
	});
});

/**
 * Path: admin/assets/js/exam.js
 * Description: This file is used to handle the event edit of the exam page
 */
$(document).ready(function () {
	$("#js-edit-close").click(() => {
		$("#editExamModal").modal("hide");
	});

	$("#edit-icon-close").click(() => {
		$("#editExamModal").modal("hide");
	});

	$("#js-edit-save").click(() => {
		var examName = $("#edit-exam-name").val();
		var examTime = $("#edit-exam-time").val();
		var examStatus = $("#edit-exam-status").val();
		$.ajax({
			url: "exam/edit-exam.php",
			type: "POST",
			data: {
				examName: examName,
				examTime: examTime,
				examStatus: examStatus,
			},
			success: function (response) {
				if (response.status == 1) {
					alert(response.message);
					$("#editExamModal").modal("hide");
					location.reload();
				} else {
					alert(response.message);
				}
			},
		});
	});

	const btns = document.querySelectorAll(".js-edit-exam");
	btns.forEach((item) => {
		item.addEventListener("click", () => {
			var examName = item.getAttribute("value");
			$.ajax({
				url: "http://localhost/WebThiTN-Oto/api/exam/getExamByName.php",
				type: "POST",
				data: {
					examName: examName,
				},
				success: function (response) {
					$("#editExamModal").modal("show");
					$("#edit-exam-name").val(response.examName);
					$("#edit-exam-time").val(response.timeLimit);
					$("#edit-exam-status").val(
						response.status == 1 ? "active" : "inactive"
					);
				},
			});
		});
	});
});

/**
 * Path: admin/assets/js/exam.js
 * Description: This file is used to handle the event delete of the exam page
 */
$(document).ready(() => {
	const deleteBtns = document.querySelectorAll(".js-delete-exam");
	deleteBtns.forEach((item) => {
		item.addEventListener("click", () => {
			const option = confirm(
				"Are you sure you want to delete this exam?"
			);
			if (!option) {
				return;
			}

			var examName = item.getAttribute("value");
			$.ajax({
				url: "exam/delete-exam.php",
				type: "POST",
				data: {
					examName: examName,
				},
				success: (response) => {
					if (response.status == 1) {
						alert(response.message);
						location.reload();
					} else {
						alert(response.message);
					}
				},
			});
		});
	});
});

/**
 * Path: admin/assets/js/exam.js
 * Description: This file is used to handle the event hide & show of the exam page
 */
$(document).ready(function () {
	$("#add-exam").click(function () {
		$("#addExamModal").modal("show");
	});
	$("#js-close").click(function () {
		$("#addExamModal").modal("hide");
	});
	$("#icon-close").click(function () {
		$("#addExamModal").modal("hide");
	});
});
