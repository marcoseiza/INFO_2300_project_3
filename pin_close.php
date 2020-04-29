<?php
  include("includes/init.php");
  include('includes/pin_update.php');
  $get_pin = "SELECT pins.id, pins.name, pins.link, pins.date, pins.description, images.src, images.description FROM  pins INNER JOIN images ON pins.image_id = images.id WHERE pins.id = :id";
  $get_tags = "SELECT tags.name, tags.color FROM tags WHERE tags.pin_id = :id";

  $pin = exec_sql_query($db, $get_pin, array(":id" => $_GET["id"]))->fetchAll();
  $tags = exec_sql_query($db, $get_tags, array(":id" => $_GET["id"]))->fetchAll();
  $board_id = $_GET['board_id'];
  $board_name = (exec_sql_query($db, "SELECT name FROM boards WHERE id = :id", array(":id"=>$board_id))->fetchAll())[0]["name"];
  $pin = $pin[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($pin["name"])))?></title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/pin_close.css">
</head>
<body>
  <header>
    <a href="index.php">Weboard</a>
    <span>
      <a href="boards.php">Boards</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
        <path d="M5 15 l20 0 M25 15 l-10 -10 M25 15 l-10 10"/>
      </svg>
      <a href="pins.php?<?php echo http_build_query(array('board_id'=>$board_id)) ?>">
        <?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($board_name)))?>
      </a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
        <path d="M5 15 l20 0 M25 15 l-10 -10 M25 15 l-10 10"/>
      </svg>
      <span class="current"><?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($pin["name"])))?></span>
    </span>
  </header>
  <div class="back">
    <a href="pins.php?<?php echo http_build_query(array('board_id'=>$board_id)) ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
        <path d="M5 15 l20 0 M25 15 l-10 -10 M25 15 l-10 10"/>
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
      <span class="prevw__name"><?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($pin["name"])))?></span>
      <input type="checkbox" name="options" id="options">
      <div for="options" class="prevw__options">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
          <circle cx="15" cy="5" r="3"/>
          <circle cx="15" cy="15" r="3"/>
          <circle cx="15" cy="25" r="3"/>
        </svg>
      </div>
      <div class="options_menu">
        <a href="pin_close_edit.php?<?php echo http_build_query(array("id"=>$_GET["id"], "board_id"=>$board_id))?>">
          edit
          <svg viewBox="0 0 30 12">
            <path d="M2 2 l20 0 6 4 -6 4 -20 0 0 -9 M6.5 2 l0 8"/>
          </svg>
        </a>
        <form method="post" action="pins.php" class="options_menu__trash">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
            <g class="lid">
              <path  d="
                M 5 8
                h 20

                M 10 8
                v -3
                h 10
                v 3
                "/>
            </g>
            <g class="can">
              <path d="
                M 15 11
                h 8.5
                v 9
                c -0 7 -0.5 7.5 -8.5 7.5
                s -8.5 -0.5 -8.5 -7.5
                v -9
                z

                M 15 14.5
                v 9

                M 11 14.5
                v 9

                M 19 14.5
                v 9
                "/>
            </g>
          </svg>
          <div class="delete_title">delete</div>
          <div class="trash-confirmation">
            <label class="trash-checkmark" for="trash-checkmark-button" onmouseover="background(this)" onmouseout="background(this)">
              <input type="submit" name="trash-confirmation" id="trash-checkmark-button" value="<?php echo $_GET["id"] .','. $board_id?>">
              &#x2713;
            </label>
            <label class="trash-cross" onmouseover="background(this)" onmouseout="background(this)">
              &#10006;
            </label>
          </div>
          <script>
            function background(el) {
              let form = el.parentElement.parentElement,
                  formBackgroundColor = getComputedStyle(form).backgroundColor

              if (formBackgroundColor == 'rgb(227, 227, 227)') {
                form.style.backgroundColor = getComputedStyle(el).color.slice(0, -1) + ', 0.1)'
              } else {
                form.style.backgroundColor = ''
              }
            }
          </script>
        </form>
        <script src="scripts/trash_close.js"></script>
      </div>
      <div class="prevw__tags">
        <?php
        foreach($tags as $tag) {?>
          <a href="pins.php?<?php echo http_build_query(array("tag_name"=>$tag["name"], "board_id"=>$board_id))?>" style="--tag_color: <?php echo $tag["color"]?>"><?php echo htmlspecialchars($tag["name"])?></a>
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
        <?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($pin[4])))?>
      </div>
    </div>
  </main>
</body>
</html>
