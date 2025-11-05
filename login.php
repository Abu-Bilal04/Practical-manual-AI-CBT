<?php include "include/server.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CBT Login Page</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- iziToast -->
  <link href="iziToast/css/iziToast.min.css" rel="stylesheet" />
  <script src="iziToast/js/iziToast.min.js" type="text/javascript"></script>

  <style>
    body, html {
      margin: 0;
      padding: 0;
      overflow: hidden;
      height: 100%;
      width: 100%;
    }
    canvas {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 0;
    }
  </style>
</head>
<body class="flex items-center justify-center bg-gradient-to-tr from-blue-200 to-purple-300 relative">

  <?php if (isset($_GET['msg']) && $_GET['msg'] == "error") { ?>
  <script>
    iziToast.error({
      title: 'Error:',
      message: 'An error occured!',
      position: 'topRight',
      animateInside: true
    });
  </script>
  <?php } ?>

  <!-- Canvas for Apples -->
  <canvas id="appleCanvas"></canvas>

  <!-- Login Card -->
  <div class="relative z-10 bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Login</h2>
    <form class="space-y-4" method="POST">
      <div>
        <label class="block text-gray-600 mb-1">Reg no</label>
        <input type="text" name="regno" class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter your regno." required>
      </div>
      <div>
        <label class="block text-gray-600 mb-1">Password</label>
        <input type="password" name="password" class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600 transition" name="student_login">Login</button>
      <div class="flex justify-center mt-4">
        <a href="index.php" class="px-5 py-2">Back to Home</a>
      </div>

    </form>
  </div>

  <script>
    const canvas = document.getElementById("appleCanvas");
    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const colors = ["#ff0000", "#00ff00", "#0000ff", "#ff69b4", "#ffa500"];
    const apples = [];
    const numApples = 15;

    class Apple {
      constructor() {
        this.radius = 30;
        this.color = colors[Math.floor(Math.random() * colors.length)];
        this.opacity = 0.1;

        // Spawn from random edge
        const edge = Math.floor(Math.random() * 4);
        if (edge === 0) { // left
          this.x = 0;
          this.y = Math.random() * canvas.height;
          this.vx = 2 + Math.random() * 2;
          this.vy = (Math.random() - 0.5) * 2;
        } else if (edge === 1) { // right
          this.x = canvas.width;
          this.y = Math.random() * canvas.height;
          this.vx = -2 - Math.random() * 2;
          this.vy = (Math.random() - 0.5) * 2;
        } else if (edge === 2) { // top
          this.x = Math.random() * canvas.width;
          this.y = 0;
          this.vx = (Math.random() - 0.5) * 2;
          this.vy = 2 + Math.random() * 2;
        } else { // bottom
          this.x = Math.random() * canvas.width;
          this.y = canvas.height;
          this.vx = (Math.random() - 0.5) * 2;
          this.vy = -2 - Math.random() * 2;
        }
      }

      draw() {
        ctx.globalAlpha = this.opacity;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.fill();
        ctx.closePath();
        ctx.globalAlpha = 1;

        // stem
        ctx.fillStyle = "#2d6a4f";
        ctx.fillRect(this.x - 2, this.y - this.radius - 10, 4, 15);
      }

      update() {
        this.x += this.vx;
        this.y += this.vy;

        // bounce off walls
        if (this.x - this.radius < 0 || this.x + this.radius > canvas.width) this.vx *= -1;
        if (this.y - this.radius < 0 || this.y + this.radius > canvas.height) this.vy *= -1;

        this.draw();
      }
    }

    // Collision handling
    function handleCollisions() {
      for (let i = 0; i < apples.length; i++) {
        for (let j = i + 1; j < apples.length; j++) {
          const dx = apples[j].x - apples[i].x;
          const dy = apples[j].y - apples[i].y;
          const dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < apples[i].radius + apples[j].radius) {
            // Simple elastic collision: swap velocities
            const tempVx = apples[i].vx;
            const tempVy = apples[i].vy;
            apples[i].vx = apples[j].vx;
            apples[i].vy = apples[j].vy;
            apples[j].vx = tempVx;
            apples[j].vy = tempVy;
          }
        }
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      apples.forEach(apple => apple.update());
      handleCollisions();
      requestAnimationFrame(animate);
    }

    // Initialize apples
    for (let i = 0; i < numApples; i++) {
      apples.push(new Apple());
    }

    animate();

    // Resize canvas on window resize
    window.addEventListener("resize", () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    });
  </script>
</body>
</html>
