<?php
  include("includes/init.php");
  $get_pin = "SELECT pins.id, pins.name, pins.link, pins.date, pins.description, images.src, images.description FROM  pins INNER JOIN images ON pins.image_id = images.id WHERE pins.id = :id";
  $get_tags = "SELECT tags.name FROM tags WHERE tags.pin_id = :id";

  $pin = exec_sql_query($db, $get_pin, array(":id" => $_GET["id"]))->fetchAll();
  $tags = exec_sql_query($db, $get_tags, array(":id" => $_GET["id"]))->fetchAll();
  $pin = $pin[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/pin_close.css">
</head>
<body>
  <div class="back">
    <a href="pins.php?board_id=<?php echo $_GET["board_id"]?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
        <line x1="5" y1="15" x2="25" y2="15"/>
        <path d="M25 15 l-10 -10 M25 15 l-10 10"/>
      </svg>
      <span>Back</span>
    </a>
  </div>
  <main>
    <div class="image">
      <a href="<?php echo $pin["link"]?>" target="_blank" rel="noopener noreferrer">
        <img src="<?php echo $pin["src"]?>" alt="<?php echo $pin["description"]?>">
      </a>
    </div>
    <div class="prevw">
      <span class="prevw__name"><?php echo $pin["name"]?></span>
      <div class="prevw__options">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
          <circle cx="15" cy="5" r="3"/>
          <circle cx="15" cy="15" r="3"/>
          <circle cx="15" cy="25" r="3"/>
        </svg>
      </div>
      <div class="prevw__tags">
        <?php
        foreach($tags as $tag) {?>
          <a style="--tag_color: lightgrey"><?php echo $tag["name"]?></a>
        <?php }
        ?>
      </div>
      <div class="prevw__linkbox">
        <a class="prevw__linkbox__link" href="<?php echo $pin["link"]?>" target="_blank" rel="noopener noreferrer">
          <div>
            <?php echo preg_replace("/^https?:\/\//", "", $pin["link"])?>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
            <line x1="5" y1="15" x2="25" y2="15"/>
            <path d="M25 15 l-5 -5 M25 15 l-5 5"/>
          </svg>
        </a>
      </div>
      <div class="prevw__date"><?php echo $pin["date"]?></div>
      <div class="prevw__description">
        <?php echo $pin[4]?>
      </div>
    </div>
  </main>
</body>
</html>
