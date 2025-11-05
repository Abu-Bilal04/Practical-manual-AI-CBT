<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CBT Portal</title>
  <style>
    /* Reset & base styling */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body, html {
      height: 100%;
      overflow: hidden;
      color: #fff;
    }

    /* Background animation */
    body {
      background: linear-gradient(-45deg, #1a1a2e, #16213e, #0f3460, #533483);
      background-size: 400% 400%;
      animation: gradientBG 10s ease infinite;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      position: relative;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Floating particles */
    .particle {
      position: absolute;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50%;
      animation: float 10s linear infinite;
    }

    @keyframes float {
      0% { transform: translateY(0) scale(1); opacity: 1; }
      100% { transform: translateY(-800px) scale(0.5); opacity: 0; }
    }

    /* Landing content */
    .container {
      text-align: center;
      z-index: 2;
      animation: fadeIn 2s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      font-size: 3.5em;
      letter-spacing: 2px;
      font-weight: 700;
    }

    p {
      margin-top: 10px;
      font-size: 1.2em;
      opacity: 0.85;
    }

    .buttons {
      margin-top: 40px;
    }

    .btn {
      padding: 12px 35px;
      margin: 10px;
      border: none;
      border-radius: 30px;
      background: #fff;
      color: #0f3460;
      font-size: 1em;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background: #0f3460;
      color: #fff;
      transform: scale(1.05);
    }

    /* Modal Styling */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      visibility: hidden;
      opacity: 0;
      transition: all 0.3s ease;
    }

    .modal.active {
      visibility: visible;
      opacity: 1;
    }

    .modal-content {
      background: #16213e;
      padding: 40px;
      border-radius: 15px;
      width: 300px;
      text-align: center;
      position: relative;
      animation: popIn 0.4s ease;
    }

    @keyframes popIn {
      from { transform: scale(0.5); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .modal-content h2 {
      margin-bottom: 20px;
    }

    .modal-content input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      outline: none;
    }

    .close {
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
      font-size: 1.3em;
      color: #fff;
    }

    .login-btn {
      width: 100%;
      padding: 10px;
      border: none;
      background: #0f3460;
      color: #fff;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-btn:hover {
      background: #533483;
    }

    @media (max-width: 600px) {
      h1 { font-size: 2.5em; }
      p { font-size: 1em; }
    }
  </style>
</head>
<body>

  <!-- Floating particles -->
  <script>
    for (let i = 0; i < 20; i++) {
      let particle = document.createElement("div");
      particle.classList.add("particle");
      particle.style.width = `${Math.random() * 10 + 5}px`;
      particle.style.height = particle.style.width;
      particle.style.left = `${Math.random() * 100}%`;
      particle.style.bottom = `${Math.random() * 100}px`;
      particle.style.animationDuration = `${5 + Math.random() * 5}s`;
      document.body.appendChild(particle);
    }
  </script>

  <!-- Main Content -->
  <div class="container">
    <h1>Welcome to <span style="color:#00fff0;">CBT Portal</span></h1>
<p>Empowering students through technology, innovation, and digital excellence.</p>
    <p>Test your knowledge anytime, anywhere.</p>
    <div class="buttons">
      <div class="buttons">
  <button class="btn" onclick="window.location.href='login.php'">Student Login</button>
  <button class="btn" onclick="window.location.href='admin/login.php'">Admin Login</button>
</div>

    </div>
  </div>


  <script>
    
  </script>

</body>
</html>
