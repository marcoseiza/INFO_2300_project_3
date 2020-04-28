<?php
include("includes/init.php");
include("includes/pin_add.php");
include("includes/pin_delete.php");
$board_id = htmlspecialchars($_GET["board_id"]);
$board_name = (exec_sql_query($db, "SELECT name FROM boards WHERE id = :id", array(":id"=>$board_id))->fetchAll())[0]["name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/pins.css">
  <title>Document</title>
</head>
<body>
  <header>
    <a href="index.php">Weboard</a>
    <span>
      <a href="boards.php">Boards</a>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
        <path d="M5 15 l20 0 M25 15 l-10 -10 M25 15 l-10 10"/>
      </svg>
      <span class="current"><?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($board_name)))?></span></span>
  </header>

  <main id="main">
    <?php if(isset($_GET["tag_name"])) { ?>
      <div class="tags">
          <span>Active Tag:</span>
          <a href="pins.php?<?php echo http_build_query(array("board_id"=>$board_id))?>">
            <?php echo htmlspecialchars($_GET["tag_name"])?>
            <svg viewbox="0 0 30 30">
                <path d="M15 25 l0 -20 M5 15 l20 0"/>
            </svg>
          </a>
      </div>
    <?php }?>
    <div class="pins_container">
      <input type="checkbox" name="add_pin" id="add_pin" <?php echo $_GET['checked']?>>
      <div class="pins_container__add">
        <div class="pins_container__add__content">
          <label for="add_pin">
            <svg viewbox="0 0 30 30">
              <path d="M15 25 l0 -20 M5 15 l20 0"/>
            </svg>
          </label>
          <div class="pins_container__add__content__form">
            <form class="add_form_pin" action="pins.php" enctype="multipart/form-data" method="post" onkeydown="return event.key != 'Enter';">
              <div class="add_form_pin__img">
                <input type="file" name="add_form_pin_img" id="add_form_pin_img" onchange="pinImgUploaded()" accept="image/*" required>
                <label for="add_form_pin_img">
                  <svg id="img_upload_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <g class="upload-bottom">
                        <path class="upload-bottom" fill="none" stroke-width="2" d="
                                M 7.5 20
                                v 5
                                h 15
                                v -5
                                "/>
                    </g>
                    <g class="upload-arrow">
                        <path class="upload-arrow" fill="none" stroke-width="2" d="
                                M 15 20
                                v -10
                                l -3 3 3 -3 3 3
                                "/>
                    </g>
                  </svg>
                  <span id="add_form_pins_img_message">Upload Screenshot *</span>
                  <?php if (isset($_GET['image_message'])){?>
                  <span class="image_message"><?php echo $_GET['image_message']?></span>
                  <?php }?>
                </label>
                <script>
                  function pinImgUploaded() {
                    let message = document.getElementById('add_form_pins_img_message')
                    message.innerHTML = "Uploaded!"
                    message.classList.add("file_uploaded")
                    document.getElementById('img_upload_svg').style.stroke = "rgb(0, 146, 146)"
                    document.getElementById('img_upload_svg').classList.add('run_svg_animation')
                    window.setTimeout(function(){
                      document.getElementById('img_upload_svg').classList.remove('run_svg_animation')
                    }, 300)
                  }
                </script>
              </div>
              <div class="add_form_pin__prevw">
                <input type="text" class="add_form_pin__prevw__name" name="add_form_pin_name" id="add_form_pin_name" placeholder="Pin's name *" required>
                <?php if (isset($_GET['name_message'])){?>
                <span class="name_message"><?php echo $_GET['name_message']?></span>
                <?php }?>
                <div id="add_form_pin_tag_container">
                  <div id="add_form_pin_tag_list"><input type="text" class="add_form_pin__prevw__tags" id="add_form_pin_tags" placeholder="#tag1 #tag2 #tag3"></div>
                  <input type="text" name="add_form_pin_tags" id="hidden_add_form_pin_tags">
                </div>
                <label for="add_form_pin_link" class="add_form_pin__prevw__link" >
                  <input type="url" name="add_form_pin_link" id="add_form_pin_link" placeholder="URL of website *" required>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <line x1="5" y1="15" x2="25" y2="15"/>
                    <path d="M25 15 l-5 -5 M25 15 l-5 5"/>
                  </svg>
                </label>
                <?php if (isset($_GET['link_message'])){?>
                <span class="link_message"><?php echo $_GET['link_message']?></span>
                <?php }?>
                <textarea name="add_form_pin_notes" placeholder="Place Your Notes Here"></textarea>
                <button type="submit" name="add_form_pin_submit" value="<?php echo $board_id?>">
                  Add Pin
                </button>
                <span class="required">* Fields Are Required</span>
              </div>
            </form>
            <script src="scripts/add_form_pin_tags.js"></script>
          </div>
        </div>
      </div>

      <?php
      // tags.name, pins.id, pins.name, pins.link, pins.description, images.src, images.description
      function pin($board_id, $id, $name, $link, $date, $image_src, $image_desc, $tags) { ?>
        <li class="pin pin_<?php echo htmlspecialchars($id)?>">
          <div class="pin__content">
            <div class="pin__content__img">
              <a href="pin_close.php?<?php echo http_build_query(array("id"=>$id, "board_id"=>$board_id))?>">
                <img src="<?php echo htmlspecialchars($image_src)?>" alt="<?php echo htmlspecialchars($image_desc)?>">
              </a>
            </div>
            <div class="pin__content__prevw">
              <a href="pin_close.php?<?php echo http_build_query(array("id"=>$id, "board_id"=>$board_id))?>" class="pin__content__prevw__name"><?php
              echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($name)))?>
              </a>
              <div for="options" class="pin__content__prevw__options">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                  <circle cx="15" cy="5" r="3"/>
                  <circle cx="15" cy="15" r="3"/>
                  <circle cx="15" cy="25" r="3"/>
                </svg>
              </div>
              <input type="checkbox" name="options" id="options">
              <div class="options_menu">
                <a href="pin_close_edit.php?<?php echo http_build_query(array("id"=>$id, "board_id"=>$board_id))?>">
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
                    <label class="trash-checkmark" for="trash-checkmark-button<?php echo $id?>">
                      <input type="submit" name="trash-confirmation" id="trash-checkmark-button<?php echo $id?>" value="<?php echo $id .','. $board_id ?>">
                      &#x2713;
                    </label>
                    <label class="trash-cross">
                      &#10006;
                    </label>
                  </div>
                </form>
              </div>
              <div class="pin__content__prevw__tags">
                <?php
                foreach($tags as $tag) {?>
                  <a href="pins.php?<?php echo http_build_query(array("tag_name"=>$tag["name"], "board_id"=>$board_id))?>" style="--tag_color: <?php echo htmlspecialchars($tag["color"])?>"><?php echo htmlspecialchars($tag["name"])?></a>
                <?php }
                ?>
              </div>
              <div class="pin__content__prevw__linkbox">
                <a class="pin__content__prevw__linkbox__link" href="<?php echo htmlspecialchars($link)?>" target="_blank" rel="noopener noreferrer">
                  <div>
                    <?php echo preg_replace("/^https?:\/\//", "", $link)?>
                  </div>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <line x1="5" y1="15" x2="25" y2="15"/>
                    <path d="M25 15 l-5 -5 M25 15 l-5 5"/>
                  </svg>
                </a>
              </div>
              <div class="pin__content__prevw__date"><?php echo htmlspecialchars($date)?></div>
            </div>
          </div>
        </li>
      <?php }

        if (isset($_GET["tag_name"])) {
          $get_pins = "SELECT tags.name, tags.color, pins.name, pins.image_id, pins.link, pins.date, images.src, images.description FROM tags INNER JOIN pins ON tags.pin_id = pins.id INNER JOIN images ON pins.image_id = images.id WHERE pins.board_id = :board_id AND tags.name like :name";
          $pins = exec_sql_query($db, $get_pins, array(":board_id" => $board_id,":name" => $_GET["tag_name"]))->fetchAll();

          foreach ($pins as $pin) {
            pin($board_id, $pin["id"], $pin["name"], $pin["link"], $pin["date"], $pin["src"], $pin["description"], array(array("name"=>$pin[0], "color"=>$pin["color"])));
          }

        } else {
          $get_pins = "SELECT pins.id, pins.name, pins.link, pins.date, images.src, images.description FROM pins INNER JOIN images ON pins.image_id = images.id WHERE pins.board_id = :board_id";
          $get_tags = "SELECT tags.name, tags.color FROM tags WHERE tags.pin_id = :id";
          $pins = exec_sql_query($db, $get_pins, array(":board_id" => $board_id))->fetchAll();
          foreach ($pins as $pin) {
            $tags = exec_sql_query($db, $get_tags, array(":id" => $pin["id"]))->fetchAll();
            pin($board_id, $pin["id"], $pin["name"], $pin["link"], $pin["date"], $pin["src"], $pin["description"], $tags);
          }

        }

      ?>
    </div>
    <script src="scripts/trash.js"></script>
  </main>
</body>
</html>
