<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update_form"])) {

  $tags_input = explode('#', $_POST['update_form_pin_tags']);
  array_splice($tags_input, 0, 1);

  $tags = array();
  $tag_names = array();

  for ($i=0; $i<(sizeof($tags_input)); $i++) {
    $tag = explode(' ', $tags_input[$i]);
    $tag[0] = filter_var($tag[0], FILTER_SANITIZE_STRING);

    if (!in_array($tag[0], $tag_names)) {
      array_push($tag_names, $tag[0]);
      array_push($tags, $tag);
    }
  }

  $name = $_POST['update_form_pin_name'];
  $link = $_POST['update_form_pin_link'];
  $notes = $_POST['update_form_pin_notes'];

  $temp = explode(',', $_POST["update_form"]);
  $id = $temp[0];
  $board_id = $temp[1];

  $valid = TRUE;

  if (!preg_match("/^[0-9A-Za-z'&,. _-]*$/", $name)) {$valid = FALSE; $name_message = "Invalid pin name";}


  if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) {
    $valid = FALSE; $link_message = "Invalid url";
  }

  if (!empty($_FILES['update_form_pin_img']['tmp_name'])) {

    $image = $_FILES['update_form_pin_img'];
    $check_image = getimagesize($image['tmp_name']);
    if ($check_image == FALSE) {

      $valid = FALSE; $image_message = "File is not an image";

    } else {
      $sql_get_image_id = "SELECT image_id FROM pins WHERE pins.id = :id";
      $sql_get_image_src = "SELECT src FROM images WHERE id = :id";
      $image_id = (exec_sql_query($db, $sql_get_image_id, array(":id"=>$id))->fetchAll())[0]["image_id"];
      $image_src = (exec_sql_query($db, $sql_get_image_src, array(":id"=>$image_id))->fetchAll())[0]["src"];

      $image_path = 'uploads/images/' . $image_id . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

      unlink($image_src);
      move_uploaded_file($image['tmp_name'], $image_src);
    }
  }

  if ($valid) {

    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $link = filter_var($link, FILTER_SANITIZE_URL);
    $notes = filter_var($notes, FILTER_SANITIZE_STRING);

    $sql_pin = "UPDATE pins SET name = :name, link = :link, description = :notes WHERE id = :id";
    $sql_tag_delete = "DELETE FROM tags WHERE pin_id = :id";
    $sql_tag_add = "INSERT INTO tags (pin_id, name, color) VALUES (:pin_id, :tag_name, :tag_color)";


    exec_sql_query($db, $sql_pin, array(":name"=>$name, ":link"=>$link, ":notes"=>$notes, ":id"=>$id));
    exec_sql_query($db, $sql_tag_delete, array(":id"=>$id));

    foreach($tags as $tag) {
      exec_sql_query($db, $sql_tag_add, array(":pin_id"=>$id, ":tag_name"=>$tag[0], ":tag_color"=>$tag[1]));
    }
    $header_location = "Location: pin_close.php?" . http_build_query(array("id"=>$id, "board_id"=>$board_id));
    header($header_location);

  } else {

    $header_location = "Location: pin_close_edit.php?" . http_build_query(array("id"=>$id,
                                                                                    "board_id"=>$board_id,
                                                                                    "name_message"=>$name_message,
                                                                                    "link_message"=>$link_message,
                                                                                    "image_message"=>$image_message));
    header($header_location);
  }

  // redirect to board
}

?>
