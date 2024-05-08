$(document).ready(function () {
	const btnStart = document.querySelectorAll(".btn-primary");
	btnStart.forEach((btn) => {
		btn.addEventListener("click", () => {
			let examName = btn.getAttribute("exam-name");

			$.ajax({
				url: "http://localhost/WebThiTN-Oto/api/question/getRandomQuestion.php",
				type: "GET",
				data: {
					exam_name: examName,
				},
				success: (res) => {
					let col = document.querySelector(".col");
					col.classList.remove("l-o-2");
					col.classList.add("l-o-4");

					let fixeInfo = document.getElementById("fixed-info");
					fixeInfo.style.display = "block";

					let panel = document.querySelector(".panel-group");
					panel.innerHTML = "";

					let questions = res.data;
					questions.forEach((question, index) => {
						let panelQuestion = document.createElement("div");
						panelQuestion.classList.add("panel");
						panelQuestion.classList.add("panel-info");
						panelQuestion.innerHTML = `
                            <div id="${question.id}" class="panel-body">
                                <div class="panel-heading">Câu hỏi ${
									index + 1
								}</div>
                                <div class="panel-body">${
									question.question
								}</div>
                                <div class="panel-footer">
                                    <div class="radio">
                                        <label><input type="radio" name="group-${
											question.id
										}">A. ${question.optionA}</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="group-${
											question.id
										}">B. ${question.optionB}</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="group-${
											question.id
										}">C. ${question.optionC}</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="group-${
											question.id
										}">D. ${question.optionD}</label>
                                    </div>
                                </div>
                            </div>
                        `;
						panel.appendChild(panelQuestion);
					});

					
					let btnSubmit = document.createElement("button");
					btnSubmit.classList.add("btn");
					btnSubmit.classList.add("btn-primary");
					btnSubmit.innerHTML = "Nộp bài";
					document.querySelector(".col").appendChild(btnSubmit);
					
					generateListBtnId(questions);

					const inputRadio = document.querySelectorAll("input[type=radio]");
					const listId = document.querySelectorAll(".list-id-item");

					inputRadio.forEach((radio) => {
						radio.addEventListener("change", () => {
							listId.forEach((id) => {
								if (radio.name === id.id) {
									id.style.backgroundColor = "green";
								}
							});
						});
					});

					var timeLeft = 5400;

					let countDown = setInterval(() => {
						timeLeft--;

						let minutes = Math.floor(timeLeft / 60);
						let seconds = timeLeft % 60;

						let formatTime = `${minutes}:${
							seconds < 10 ? "0" + seconds : seconds
						}`;

						document.getElementById('time-left').textContent =
							"Thời gian còn lại: " + formatTime;

						if (timeLeft < 0) {
							clearInterval(countDown);
							alert("Hết giờ làm bài");
                            window.location.href = "http://localhost/WebThiTN-Oto/?module=pages&action=thithu";
						}
					}, 1000);
				},
			});
		});
	});
});

function generateListBtnId(data) {
	let listId = document.querySelector("#list-id .row");
	data.forEach((question) => {
		let col = document.createElement("div");
		col.classList.add("col");
		col.classList.add("l-2-4");

		let a = document.createElement("a");
		a.id = `group-${question.id}`;
		a.classList.add("btn");
		a.classList.add("btn-primary");
		a.classList.add("list-id-item");
		a.setAttribute("href", `#${question.id}`);
		a.style.margin = "5px";
		a.style.display = "block";
		a.textContent = data.indexOf(question) + 1;
		col.appendChild(a);
		listId.appendChild(col);
	});
}