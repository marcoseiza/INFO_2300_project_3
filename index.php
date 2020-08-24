<?php include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/main.css">
  <title>Weboard</title>
</head>

<body>
  <header>
    <a href="index.php">Weboard</a>
  </header>
  <div class="main">
    <span class="main__title">
      <span>Better Organization,</span>
      <span>Better Inspiration,</span>
      <span>Better Design.</span>
    </span>
  </div>
  <a href="boards.php">MAKE A BOARD</a>
  <div class="graphic">
    <span>psst...click the boxes!</span>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <div onclick="changecolor(this)"></div>
    <script>
      let divs = document.querySelectorAll('.graphic div')
      divs.forEach(changecolor)
      function changecolor(el) {
        el.style = '--color: hsl(' + Math.floor(360 * Math.random()) + ',100%,' + Math.floor(35 + 15 * Math.random()) + '%)'
      }
    </script>
  </div>
</body>

</html>
