var countDown;
var exam_name;
var test_date;

document.querySelectorAll(".btn.btn-start").forEach((btn) => {
	btn.addEventListener("click", async () => {
		const examName = btn.getAttribute("exam-name");

		const response = await fetch(
			"http://localhost/WebThiTN-Oto/api/question/getRandomQuestion.php?exam_name=" +
				examName
		);
		const { data: questions, timeLimit, totalQuestion } = await response.json();

		exam_name = examName;

		const col = document.querySelector(".col");
		col.classList.remove("l-8");
		col.classList.remove("l-o-2");
		col.classList.add("l-6", "l-o-6");

		document.getElementById("fixed-info").style.display = "block";
		document.getElementById("total-question").textContent =`Số câu hỏi: ${totalQuestion}`;
		document.querySelector("#fixed-info h2").textContent = `Tên bài thi: ${questions[0].chuDe}`;

		const panel = document.querySelector(".panel-group");
		panel.innerHTML = "";

		questions.forEach((question, index) => {
			const panelQuestion = document.createElement("div");
			panelQuestion.classList.add("panel", "panel-info");
			panelQuestion.innerHTML = `
                <div id="${question.id}" class="panel-body">
                    <div class="panel-heading">Câu hỏi ${index + 1}</div>
                    <div class="panel-body">${question.question}</div>
                    <div class="panel-footer">
                        <div class="radio">
                            <label><input type="radio" value="A" name="group-${
								question.id
							}">A. ${question.optionA}</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="B" name="group-${
								question.id
							}">B. ${question.optionB}</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="C" name="group-${
								question.id
							}">C. ${question.optionC}</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" value="D" name="group-${
								question.id
							}">D. ${question.optionD}</label>
                        </div>
                    </div>
                </div>
            `;
			panel.appendChild(panelQuestion);
		});

		const btnSubmit = document.createElement("button");
		btnSubmit.classList.add("btn", "btn-primary");
		btnSubmit.innerHTML = "Nộp bài";
		col.appendChild(btnSubmit);

		btnSubmit.addEventListener("click", () => {
			handleBtnSubmitClick(timeLimit, totalQuestion);
		});

		generateListBtnId(questions);

		document.querySelectorAll("input[type=radio]").forEach((radio) => {
			radio.addEventListener("change", () => {
				document.querySelectorAll(".list-id-item").forEach((id) => {
					if (radio.name === id.id) {
						id.style.backgroundColor = "green";
					}
				});
			});
		});

		let timeLeft = timeLimit * 60;

		countDown = setInterval(() => {
			timeLeft--;

			const minutes = Math.floor(timeLeft / 60);
			const seconds = timeLeft % 60;

			const formatTime = `${minutes}:${
				seconds < 10 ? "0" + seconds : seconds
			}`;

			document.getElementById("time-left").textContent =
				"Thời gian còn lại: " + formatTime;

			if (timeLeft < 0) {
				clearInterval(countDown);
				alert("Hết giờ làm bài");
				const groupByName = {};
				const userAnswers = {};

				document
					.querySelectorAll("input[type=radio]")
					.forEach((radio) => {
						if (!groupByName[radio.name]) {
							groupByName[radio.name] = [];
						}
						groupByName[radio.name].push(radio);

						if (radio.checked) {
							userAnswers[radio.name] = radio.value;
						}
					});
				
				let timeComplete = `${timeLimit}:00`;
				submitAnswer({ userAnswers, timeComplete, totalQuestion }, timeout = 0);
			}
		}, 1000);
	});
});

function handleBtnSubmitClick(timeLimit, totalQuestion) {
	let isComplete = true;
	const groupByName = {};
	const userAnswers = {};

	document.querySelectorAll("input[type=radio]").forEach((radio) => {
		if (!groupByName[radio.name]) {
			groupByName[radio.name] = [];
		}
		groupByName[radio.name].push(radio);

		if (radio.checked) {
			userAnswers[radio.name] = radio.value;
		}
	});

	for (const key in groupByName) {
		if (groupByName[key].every((radio) => !radio.checked)) {
			isComplete = false;
			break;
		}
	}
	
	if (!isComplete) {
		alert("Vui lòng hoàn thành tất cả các câu hỏi");
	} else {
		clearInterval(countDown);

		let timeCompleteDom = document.getElementById("time-left").textContent;
		let minute = timeCompleteDom.split(" ")[4].split(":")[0];
		let second = timeCompleteDom.split(" ")[4].split(":")[1];
		let timeRemaining = minute * 60 + second * 1;
		let tmp = timeLimit * 60 - timeRemaining;
		let timeComplete;
		if (Math.floor(tmp / 60) <= 0) {
			timeComplete = `${tmp % 60} giây`;
		} else {
			timeComplete = `${Math.floor(tmp / 60)} phút ${tmp % 60} giây`;
		}
		const data = {
			userAnswers,
			timeComplete,
			totalQuestion
		};
		submitAnswer(data);
	}
}

async function submitAnswer(data, timeout = 1) {
	if (timeout == 1) {
		let comfirm = confirm("Bạn có chắc chắn muốn nộp bài không?");
		if (!comfirm) {
			return;
		}
	}

	clearInterval(countDown);

	const response = await fetch(
		"http://localhost/WebThiTN-Oto/api/question/chamdiem.php",
		{
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify(data),
		}
	);
	const { score, msg, timeComplete, testDate } = await response.json();

	test_date = testDate;

	$("#modalResult").modal("show");

	const scoreDom = document.getElementById("score");
	scoreDom.textContent = `${score}`;

	const msgDom = document.getElementById("msg");
	msgDom.textContent = `${msg}`;

	const timeCompleteDom = document.getElementById("time-comple");
	timeCompleteDom.textContent = `Thời gian làm bài: ${timeComplete}`;

	$("#modalResult").on("hidden.bs.modal", function (e) {
		window.location.href = "http://localhost/WebThiTN-Oto/?module=pages&action=thithu";
	})
}

function generateListBtnId(questions) {
	const listId = document.querySelector("#list-id .row");

	questions.forEach((question, index) => {
		const col = document.createElement("div");
		col.classList.add("col", "l-2");

		const a = document.createElement("a");
		a.id = `group-${question.id}`;
		a.classList.add("btn", "btn-primary", "list-id-item");
		a.setAttribute("href", `#${question.id}`);
		a.style.margin = "5px";
		a.style.display = "block";
		a.textContent = index + 1;
		col.appendChild(a);
		listId.appendChild(col);
	});
}

document.getElementById('btn-view-result').addEventListener('click', async () => {
	const response = await fetch('http://localhost/WebThiTN-Oto/api/question/getLatestQuestion.php?exam_name=' + exam_name + '&test_date=' + test_date);
	const { data: questions } = await response.json();

	const listAnswerDOM = document.getElementById('list-answer');
	listAnswerDOM.innerHTML = '';
	questions.forEach((question, index) => {
		const div = document.createElement('div');
		div.classList.add('divst-group-item');
		div.innerHTML = `
			<div class="panel-heading">Câu hỏi ${index + 1}</div>
			<div class="panel-body" style="color: ${question.result === 0 ? 'red' : 'green'}">
				<i class="fa fa-check" aria-hidden="true"></i>
				${question.question}
			</div>
			<div class="panel-footer">
				<div class="radio" style="
					display: flex;
					flex-direction: column;
				">
					<label><input type="radio" value="A" name="group-${question.id}" ${
						question.answerUser === 'A' ? 'checked' : ''
					} disabled>A. ${question.optionA}</label>

					<label><input type="radio" value="B" name="group-${question.id}" ${
						question.answerUser === 'B' ? 'checked' : ''
					} disabled>B. ${question.optionB}</label>

					<label><input type="radio" value="C" name="group-${question.id}" ${
						question.answerUser === 'C' ? 'checked' : ''
					} disabled>C. ${question.optionC}</label>

					<label><input type="radio" value="D" name="group-${question.id}" ${
						question.answerUser === 'D' ? 'checked' : ''
					} disabled>D. ${question.optionD}</label>
				</div>
				<div class="panel-footer">Đáp án đúng: ${question.answer}</div>
			</div>
		`;
		listAnswerDOM.appendChild(div);
	});

	$("#modalViewResult").modal("show");
});