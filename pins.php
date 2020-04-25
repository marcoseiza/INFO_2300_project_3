<?php
include("includes/init.php");
$board_id = $_GET["board_id"];
include("includes/pin_add.php");

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
  <!-- <script
    src="https://code.jquery.com/jquery-3.5.0.min.js"
    integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
    crossorigin="anonymous"></script> -->
  <main>
    <div class="pins_container">
      <input type="checkbox" name="add_pin" id="add_pin">
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
                  <span id="add_form_pins_img_message">Upload Screenshot</span>
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
                <input type="text" class="add_form_pin__prevw__name" name="add_form_pin_name" id="add_form_pin_name" placeholder="Pin's name" required>
                <div id="add_form_pin_tag_container">
                  <div id="add_form_pin_tag_list"><input type="text" class="add_form_pin__prevw__tags" id="add_form_pin_tags" placeholder="#tag1 #tag2 #tag3"></div>
                  <input type="text" name="add_form_pin_tags" id="hidden_add_form_pin_tags">
                </div>
                <label for="add_form_pin_link" class="add_form_pin__prevw__link" >
                  <input type="url" name="add_form_pin_link" id="add_form_pin_link" placeholder="URL of website" required>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <line x1="5" y1="15" x2="25" y2="15"/>
                    <path d="M25 15 l-5 -5 M25 15 l-5 5"/>
                  </svg>
                </label>
                <textarea name="add_form_pin_notes" placeholder="Place Your Notes Here"></textarea>
                <button type="submit" name="add_form_pin_submit" value="<?php echo $board_id?>">
                  Add Pin
                </button>
              </div>
            </form>
            <script src="scripts/add_form_pin_tags.js"></script>
          </div>
        </div>
      </div>
      <?php
      if (!isset($_GET["board_id"])) {
        echo "<a href='pins.php?board_id=1'>CLICK HERE TO GO TO BOARD 1</a>";
      }
      // tags.name, pins.id, pins.name, pins.link, pins.description, images.src, images.description
      function pin($board_id, $id, $name, $link, $date, $image_src, $image_desc, $tags) { ?>
        <li class="pin pin_<?php echo $id?>">
          <div class="pin__content">
            <div class="pin__content__bookmark">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 2 30 30">
                  <g class="outline">
                      <path stroke-width="2" d="M 15 3h 7.5v 20l -7.5 5 -7.5 -5v -20z"/>
                      <g class="animation">
                          <path stroke-width="2" d="M 15 3h 7.5v 20l -7.5 5 -7.5 -5v -20z"/>
                      </g>
                  </g>
              </svg>
            </div>
            <div class="pin__content__img">
              <a href="pin_close.php?id=<?php echo $id?>&board_id=<?php echo $board_id?>">
                <img src="<?php echo $image_src?>" alt="<?php echo $image_desc?>">
              </a>
            </div>
            <div class="pin__content__prevw">
              <span class="pin__content__prevw__name"><?php echo $name?></span>
              <div class="pin__content__prevw__options">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                  <circle cx="15" cy="5" r="3"/>
                  <circle cx="15" cy="15" r="3"/>
                  <circle cx="15" cy="25" r="3"/>
                </svg>
              </div>
              <div class="pin__content__prevw__tags">
                <?php
                foreach($tags as $tag) {?>
                  <a href="pins.php?tag_name=<?php echo $tag["name"]?>&board_id=<?php echo $board_id?>" style="--tag_color: lightgrey"><?php echo $tag["name"]?></a>
                <?php }
                ?>
              </div>
              <div class="pin__content__prevw__linkbox">
                <a class="pin__content__prevw__linkbox__link" href="<?php echo $link?>" target="_blank" rel="noopener noreferrer">
                  <div>
                    <?php echo preg_replace("/^https?:\/\//", "", $link)?>
                  </div>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                    <line x1="5" y1="15" x2="25" y2="15"/>
                    <path d="M25 15 l-5 -5 M25 15 l-5 5"/>
                  </svg>
                </a>
              </div>
              <div class="pin__content__prevw__date"><?php echo $date?></div>
            </div>
          </div>
        </li>
      <?php }

        if (isset($_GET["tag_name"])) {
          $get_pins = "SELECT tags.name, pins.name, pins.image_id, pins.link, pins.date, images.src, images.description FROM tags INNER JOIN pins ON tags.pin_id = pins.id INNER JOIN images ON pins.image_id = images.id WHERE pins.board_id = :board_id AND tags.name like :name";
          $pins = exec_sql_query($db, $get_pins, array(":board_id" => $board_id,":name" => $_GET["tag_name"]))->fetchAll();

          foreach ($pins as $pin) {
            pin($board_id, $pin["id"], $pin["name"], $pin["link"], $pin["date"], $pin["src"], $pin["description"], array(array("name"=>$pin[0])));
          }

        } else {
          $get_pins = "SELECT pins.id, pins.name, pins.link, pins.date, images.src, images.description FROM pins INNER JOIN images ON pins.image_id = images.id WHERE pins.board_id = :board_id";
          $get_tags = "SELECT tags.name FROM tags WHERE tags.pin_id = :id";
          $pins = exec_sql_query($db, $get_pins, array(":board_id" => $board_id))->fetchAll();
          foreach ($pins as $pin) {
            $tags = exec_sql_query($db, $get_tags, array(":id" => $pin["id"]))->fetchAll();
            pin($board_id, $pin["id"], $pin["name"], $pin["link"], $pin["date"], $pin["src"], $pin["description"], $tags);
          }

        }

      ?>
    </div>
  </main>
</body>
</html>
