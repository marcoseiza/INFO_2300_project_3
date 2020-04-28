<?php
include("includes/init.php");
include("includes/board_add.php");
include("includes/board_update.php");
include("includes/board_delete.php");

$board_sql = "SELECT * FROM boards";
$boards = exec_sql_query($db, $board_sql)->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/boards.css">
  <title>Document</title>
</head>
<?php

function board($id, $name, $color, $date, $name_update_message, $update_id) { ?>
  <div class="board">
    <a href="pins.php?board_id=<?php echo $id?>" class="board__iframe_wrap">
      <div class="board__iframe_container">
        <iframe src="pins.php?<?php echo http_build_query(array("board_id"=>$id))?>" tabindex="-1" scrolling="no" loading="lazy" importance="low" sandbox></iframe>
      </div>
    </a>
    <?php if (!empty($name_update_message) && $update_id == $id) {
      $checked = "checked=''";
    } ?>
    <input type="checkbox" name="edit_board" id="edit_board<?php echo $id?>" <?php echo $checked?>>
    <div class="board__info">
      <span class="board__info__name">
        <svg viewBox="0 0 28 22" style="--color:<?php echo htmlspecialchars($color)?>">
          <path d="M2 20 L2 2 l10 0 3 3 L26 5 L 26 20 Z"/>
        </svg>
        <span><?php echo htmlspecialchars($name)?></span>
      </span>
      <span class="board__info__date"><?php echo htmlspecialchars($date)?></span>
      <div for="options" class="board__info__options">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
          <circle cx="15" cy="5" r="3"/>
          <circle cx="15" cy="15" r="3"/>
          <circle cx="15" cy="25" r="3"/>
        </svg>
      </div>
      <input type="checkbox" name="options" id="options">
      <div class="board__info__options_menu">
        <label for="edit_board<?php echo $id?>">
          edit
          <svg viewBox="0 0 30 12">
            <path d="M2 2 l20 0 6 4 -6 4 -20 0 0 -9 M6.5 2 l0 8"/>
          </svg>
        </label>
        <form method="post" action="" class="board__info__options_menu__trash">
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
            <label class="trash-checkmark" for="trash-checkmark-button<?php echo $id?>">
              <input type="submit" name="trash-confirmation" id="trash-checkmark-button<?php echo $id?>" value="<?php echo $id?>">
              &#x2713;
            </label>
            <label class="trash-cross">
              &#10006;
            </label>
          </div>
        </form>
      </div>
    </div>
    <form method="POST" action="boards.php" class="board__edit">
      <label for="edit_board<?php echo $id?>" class="board__edit__exit">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
          <path d="M5 5 l20 20 M5 25 l20 -20"/>
        </svg>
      </label>
      <span>Edit</span>
      <div class="board__edit__name">
        <input type="color" name="board_color" id="board_color<?php echo $id?>" class="board_color"
                value="<?php echo htmlspecialchars($color)?>"
                oninput="board_add_color(this)">
        <label for="board_color<?php echo $id?>">
          <svg viewBox="0 0 28 22" style="fill:<?php echo htmlspecialchars($color)?>; stroke:<?php echo htmlspecialchars($color)?>;">
            <path d="M2 20 L2 2 l10 0 3 3 L26 5 L 26 20 Z"/>
          </svg>
        </label>
        <input type="text" name="board_name" id="board_name" value="<?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($name)))?>">
      </div>
      <?php if (!empty($name_update_message) && $update_id == $id) { ?>
      <span class="message"><?php echo $name_update_message ?>!</span>
      <?php } ?>
      <label for="board_edit_submit<?php echo $id?>" class="board__edit__submit">
        Done
        <input type="submit" name="board_edit_submit" id="board_edit_submit<?php echo $id?>" value="<?php echo $id?>">
      </label>
    </form>
  </div>
<?php }?>


<body>
  <header>
    <a href="index.php">Weboard</a>
    <span>
      <span class="current">Boards</span>
    </span>
  </header>
  <main>
    <input type="checkbox" name="form_expand" id="form_expand" <?php echo $checked?>>
    <div class="add_board">
      <label for="form_expand">
        <svg viewbox="0 0 30 30">
          <path d="M15 25 l0 -20 M5 15 l20 0"/>
        </svg>
      </label>
      <form action="boards.php" method="post">
        <?php if (!empty($name_add_message)) { ?>
        <span><?php echo $name_add_message ?>!</span>
        <?php } ?>
        <div class="name">
          <input type="color" name="board_color" id="board_color" value="#D3D3D3" oninput="board_add_color(this)">
          <label for="board_color">
            <svg viewBox="0 0 28 22" id="board_add_svg">
              <path d="M2 20 L2 2 l10 0 3 3 L26 5 L 26 20 Z"/>
            </svg>
          </label>
          <input type="text" name="board_name" id="board_name"
                  value="<?php echo htmlspecialchars($name)?>"
                  placeholder="Board Name *" required>
        </div>
        <label for="board_add_submit" class="board__add__submit">
          Add Board
          <input type="submit" name="board_add_submit" id="board_add_submit">
        </label>
      </form>
    </div>
    <?php
    foreach($boards as $board) {
      board($board["id"], $board["name"], $board["color"], $board["date"], $name_update_message, $update_id);
    }
    ?>
  </main>
  <script>
    function board_add_color(el) {
      let svg = el.nextElementSibling.querySelector('svg')
      console.log(el, svg)
      svg.style.fill = el.value
      svg.style.stroke = el.value
    }
  </script>
  <script src="scripts/board_options.js"></script>
</body>
</html>
