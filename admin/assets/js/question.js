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

$(document).ready(() => {
    $('#js-question-save').click(() => {
        let question = $('#question-content').val();
        let questionTopic = $('#question-topic').val();
        let answerA = $('#answer-a').val();
        let answerB = $('#answer-b').val();
        let answerC = $('#answer-c').val();
        let answerD = $('#answer-d').val();
        let answerCorrect = $('#correct-answer').val();
        let questionDiff = $('#difficulty').val();
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
            url: 'question/add-question.php',
            type: 'POST',
            data: data,
            success: (response) => {
                if (response.status == 1) {
                    alert(response.message);
                    $('#addQuestionModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });
});