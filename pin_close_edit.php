<?php
  include("includes/init.php");
  include("includes/pin_update.php");
  $get_pin = "SELECT pins.id, pins.name, pins.link, pins.date, pins.description, images.src, images.description FROM  pins INNER JOIN images ON pins.image_id = images.id WHERE pins.id = :id";
  $get_tags = "SELECT tags.name, tags.color FROM tags WHERE tags.pin_id = :id";

  $pin = exec_sql_query($db, $get_pin, array(":id" => $_GET["id"]))->fetchAll();
  $tags = exec_sql_query($db, $get_tags, array(":id" => $_GET["id"]))->fetchAll();
  $board_id = $_GET['board_id'];
  $pin = $pin[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/pin_close_edit.css">
</head>
<body>
  <div class="back">
    <a href="pin_close.php?<?php echo http_build_query(array("id"=>$_GET["id"], "board_id"=>$board_id))?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
        <path d="M5 5 l20 20 M5 25 l20 -20"/>
      </svg>
      <span>Close edit</span>
    </a>
  </div>
  <form class="update_form_pin" action="pin_close_edit.php" enctype="multipart/form-data" method="post" onkeydown="return event.key != 'Enter';">
    <div class="image">
      <input type="file" name="update_form_pin_img" id="update_form_pin_img" onchange="pinImgUploaded()" accept="image/*">
      <label for="update_form_pin_img">
        <div class="label_img">
          <span>Image Preview</span>
          <img src="<?php echo $pin["src"]?>" alt="<?php echo $pin["description"]?>">
        </div>
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
        <span id="update_form_pins_img_message">Upload Screenshot</span>
      </label>
      <script>
        function pinImgUploaded() {
          let message = document.getElementById('update_form_pins_img_message')
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
    <div class="prevw">
      <input type="text" name="update_form_pin_name" id="name" class="prevw__name" value="<?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($pin["name"])))?>">
      <div class="prevw__tags">

        <!-- list of preexisting tags in specific format so that they can be deleted -->
        <div id="update_form_pin_tag_list"><?php
        foreach($tags as $key => $tag) {?><span id="form_tag_numb_<?php echo $key?>" style='background-color:<?php echo $tag["color"]?>'><?php echo htmlspecialchars($tag["name"])?></span><?php }?><input type="text" class="update_form_pin__prevw__tags" id="update_form_pin_tags" placeholder="add or delete"></div>

        <!-- make hidden value of the input by looping through existing tags -->
        <?php
        $hidden_value = '';
        foreach($tags as $tag) {
          $hidden_value .= '#' . htmlspecialchars($tag["name"]) . ' ' . $tag["color"];
        }?>

        <input type="text" name="update_form_pin_tags" id="hidden_update_form_pin_tags"
               value="<?php echo $hidden_value?>">
      </div>
      <label for="link" class="prevw__link" >
        <input type="url" name="update_form_pin_link" id="link" value="<?php echo $pin["link"]?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
          <line x1="5" y1="15" x2="25" y2="15"/>
          <path d="M25 15 l-5 -5 M25 15 l-5 5"/>
        </svg>
      </label>
      <div class="prevw__description">
        <textarea name="update_form_pin_notes" placeholder="Place Your Notes Here"><?php echo str_replace("&amp;","&",str_replace('&#39;',"'",htmlspecialchars($pin[4])))?></textarea>
      </div>
      <button type="submit" name="update_form" value="<?php echo $_GET["id"] . ',' . $board_id?>">
        Edit Pin
      </button>
    </div>
    <script src="scripts/add_tag_close.js"></script>
  </form>
</body>
</html>
