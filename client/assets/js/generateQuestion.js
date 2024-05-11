document.querySelectorAll(".btn-primary").forEach((btn) => {
	btn.addEventListener("click", async () => {
		const examName = btn.getAttribute("exam-name");

		const response = await fetch(
			"http://localhost/WebThiTN-Oto/api/question/getRandomQuestion.php?exam_name=" +
				examName
		);
		const { data: questions } = await response.json();

		const col = document.querySelector(".col");
		col.classList.remove("l-8");
		col.classList.remove("l-o-2");
		col.classList.add("l-6", "l-o-6");

		document.getElementById("fixed-info").style.display = "block";

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

		btnSubmit.addEventListener("click", handleBtnSubmitClick);

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

		let timeLeft = 5400;

		const countDown = setInterval(() => {
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
				window.location.href =
					"http://localhost/WebThiTN-Oto/?module=pages&action=thithu";
			}
		}, 1000);
	});
});

function handleBtnSubmitClick() {
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
		console.table(userAnswers);
	}
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
