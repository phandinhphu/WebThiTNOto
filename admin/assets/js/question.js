/**
 * Path: admin/assets/js/question.js
 * Description: show & hide add question modal
 */
$(document).ready(() => {
	$("#add-question").click(function () {
		$("#addQuestionModal").modal("show");
	});
	$("#js-question-close").click(function () {
		$("#addQuestionModal").modal("hide");
	});
	$("#question-icon-close").click(function () {
		$("#addQuestionModal").modal("hide");
	});
});

/**
 * Path: admin/assets/js/question.js
 * Description: add question modal
 */
$(document).ready(() => {
	$("#js-question-save").click(() => {
		let question = $("#question-content").val();
		let questionTopic = $("#question-topic").val();
		let answerA = $("#answer-a").val();
		let answerB = $("#answer-b").val();
		let answerC = $("#answer-c").val();
		let answerD = $("#answer-d").val();
		let answerCorrect = $("#correct-answer").val();
		let questionDiff = $("#difficulty").val();
		let data = {
			question: question,
			questionTopic: questionTopic,
			answerA: answerA,
			answerB: answerB,
			answerC: answerC,
			answerD: answerD,
			answerCorrect: answerCorrect,
			questionDiff: questionDiff,
		};
		$.ajax({
			url: "question/add-question.php",
			type: "POST",
			data: data,
			success: (response) => {
				if (response.status == 1) {
					alert(response.message);
					$("#addQuestionModal").modal("hide");
					location.reload();
				} else {
					alert(response.message);
				}
			},
		});
	});
});

/**
 * Path: admin/assets/js/question.js
 * Description: edit question
 */
$(document).ready(() => {
	const btnsEdit = document.querySelectorAll(".js-edit-question");
    var idQuestion;
	btnsEdit.forEach((item) => {
        item.addEventListener("click", () => {
            idQuestion = item.getAttribute("value");
			$.ajax({
				url: "http://localhost/WebThiTN-Oto/api/question/getQuestionById.php",
				type: "POST",
				data: {
					id: idQuestion,
				},
				success: (response) => {
					let question = response.question;
					let questionTopic = response.chuDe;
					let answerA = response.optionA;
					let answerB = response.optionB;
					let answerC = response.optionC;
					let answerD = response.optionD;
					let answerCorrect = response.answer;
					let questionDiff = response.difficulty;
					$("#editQuestionModal").modal("show");
					$("#edit-content").val(question);
					$("#edit-topic").val(questionTopic);
					$("#edit-answer-a").val(answerA);
					$("#edit-answer-b").val(answerB);
					$("#edit-answer-c").val(answerC);
					$("#edit-answer-d").val(answerD);
					$("#edit-correct-answer").val(answerCorrect);
					$("#edit-difficulty").val(questionDiff);
				},
			});
		});
	});

    $('#js-edit-question-save').click(() => {
        let id = idQuestion;
        let question = $("#edit-content").val();
        let questionTopic = $("#edit-topic").val();
        let answerA = $("#edit-answer-a").val();
        let answerB = $("#edit-answer-b").val();
        let answerC = $("#edit-answer-c").val();
        let answerD = $("#edit-answer-d").val();
        let answerCorrect = $("#edit-correct-answer").val();
        let questionDiff = $("#edit-difficulty").val();
        let data = {
            id: id,
            question: question,
            questionTopic: questionTopic,
            answerA: answerA,
            answerB: answerB,
            answerC: answerC,
            answerD: answerD,
            answerCorrect: answerCorrect,
            questionDiff: questionDiff,
        };
        $.ajax({
            url: "question/edit-question.php",
            type: "POST",
            data: data,
            success: (response) => {
                if (response.status == 1) {
                    alert(response.message);
                    $("#editQuestionModal").modal("hide");
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
        });
    });

	$("#js-edit-question-close").click(() => {
		$("#editQuestionModal").modal("hide");
	});

	$("#edit-question-icon-close").click(() => {
		$("#editQuestionModal").modal("hide");
	});
});

/**
 * Path: admin/assets/js/question.js
 * Description: delete question
 */
$(document).ready(() => {
    const btnsDelete = document.querySelectorAll(".js-delete-question");
    btnsDelete.forEach((item) => {
        item.addEventListener('click', () => {
            $confim = confirm('Are you sure to delete this question?');
            if (!$confim) {
                return;
            }
            
            let id = item.getAttribute('value');
            $.ajax({
                url: 'question/delete-question.php',
                type: 'POST',
                data: {
                    id: id,
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