<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Page || Practical Manual System</title>
  <link rel="stylesheet" href="../dist/assets/css/style.css" />
  <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">
  <style>
    .question-card { min-height: 250px; }
    .option { 
      border: 1px solid #ccc; 
      padding: 10px; 
      border-radius: 6px; 
      cursor: pointer; 
      display: flex; 
      align-items: center; 
      gap: 10px;
      transition: all 0.2s ease;
    }
    .option:hover { background: #f1f1f1; }
    .option input { pointer-events: none; }
    .option.active { 
      border-color: #2563eb; 
      background: #e0f2fe; 
      font-weight: bold; 
      color: #1e3a8a;
    }
  </style>
</head>

<body class="bg-gray-100">

  <div class="pc-container">
    <div class="pc-content flex flex-col items-center min-h-screen py-10">

      <!-- Header -->
      <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-6 mb-6">
        <div class="flex justify-between items-center">
          <div>
            <h4 class="font-bold">CSC 201</h4>
            <p class="text-gray-600">Introduction to Programming</p>
          </div>
          <div class="text-right">
            <i class="bi bi-clock-history text-primary"></i>
            <span id="exam-timer" class="font-bold text-lg">01:30:00</span>
          </div>
        </div>
      </div>

      <!-- Question Box -->
      <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-6 question-card">
        <div id="question-text" class="mb-4 font-medium text-lg">
          Question text will appear here...
        </div>

        <div id="options" class="space-y-3">
          <!-- Options will be loaded here dynamically -->
        </div>
      </div>

      <!-- Footer Navigation -->
      <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-4 mt-4 flex justify-between items-center">
        <button id="prev-btn" class="btn btn-secondary px-4 py-2" disabled>Previous</button>
        <span id="progress" class="font-medium">1 out of 10</span>
        <button id="next-btn" class="btn btn-primary px-4 py-2">Next</button>
      </div>

    </div>
  </div>

  <script>
    // Example Questions
    const questions = [
      {
        text: "What does HTML stand for?",
        options: [
          "Hyper Text Markup Language", 
          "High Text Machine Language", 
          "Hyper Tabular Markup Language", 
          "None of the above"
        ],
      },
      {
        text: "Which language is used for styling web pages?",
        options: ["HTML", "JQuery", "CSS", "XML"],
      },
      {
        text: "Which is not a JavaScript Framework?",
        options: ["Python Script", "JQuery", "Django", "NodeJS"],
      },
      {
        text: "Which is used to connect to a Database?",
        options: ["PHP", "HTML", "JS", "All of the above"],
      }
    ];

    let currentQuestion = 0;
    let answers = {};

    const optionLabels = ["A", "B", "C", "D"];

    function loadQuestion() {
      const q = questions[currentQuestion];
      document.getElementById("question-text").innerText = q.text;
      document.getElementById("progress").innerText = 
        (currentQuestion + 1) + " out of " + questions.length;

      const optionsDiv = document.getElementById("options");
      optionsDiv.innerHTML = "";
      q.options.forEach((opt, i) => {
        const div = document.createElement("label");
        div.classList.add("option");
        if (answers[currentQuestion] == i) {
          div.classList.add("active"); // highlight if previously selected
        }
        div.innerHTML = `
          <input type="radio" name="option" value="${i}" ${answers[currentQuestion] == i ? "checked" : ""}>
          <strong>${optionLabels[i]}.</strong> ${opt}
        `;
        div.addEventListener("click", () => {
          answers[currentQuestion] = i;
          loadQuestion(); // refresh UI and keep active highlight
        });
        optionsDiv.appendChild(div);
      });

      // Button states
      document.getElementById("prev-btn").disabled = currentQuestion === 0;
      document.getElementById("next-btn").innerText = 
        currentQuestion === questions.length - 1 ? "Submit" : "Next";
    }

    document.getElementById("prev-btn").addEventListener("click", () => {
      if (currentQuestion > 0) {
        currentQuestion--;
        loadQuestion();
      }
    });

    document.getElementById("next-btn").addEventListener("click", () => {
      if (currentQuestion < questions.length - 1) {
        currentQuestion++;
        loadQuestion();
      } else {
        alert("Exam submitted!"); // Replace with real submit action
      }
    });

    loadQuestion();

    // Countdown Timer
    function startCountdown(duration, display) {
      let timer = duration, hours, minutes, seconds;
      const interval = setInterval(() => {
        hours = Math.floor(timer / 3600);
        minutes = Math.floor((timer % 3600) / 60);
        seconds = timer % 60;

        display.textContent = 
          (hours < 10 ? "0" + hours : hours) + ":" +
          (minutes < 10 ? "0" + minutes : minutes) + ":" +
          (seconds < 10 ? "0" + seconds : seconds);

        if (--timer < 0) {
          clearInterval(interval);
          alert("Time is up! Exam submitted automatically.");
        }
      }, 1000);
    }

    window.onload = function () {
      const examTimeInSeconds = 90 * 60; // 1 hour 30 minutes
      const display = document.getElementById("exam-timer");
      startCountdown(examTimeInSeconds, display);
    };

    // Detect tab switch or minimize
    document.addEventListener("visibilitychange", () => {
      if (document.hidden) {
        alert("Switching tabs, minimizing, or leaving the page will result in automatic submission!");
        // Optionally auto-submit: document.getElementById("next-btn").click();
      }
    });
  </script>

</body>
</html>
