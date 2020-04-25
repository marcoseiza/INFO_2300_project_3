<?php

function uploadImage($image) {
  $file = 'uploads/images/' . basename($_FILES[$image]['name']);
  $uploadable = TRUE;
  $message = TRUE;

  $check = getimagesize($_FILES[$image]['tmp_name']);
  if ($check == FALSE) {
    $uploadable = FALSE;
    $message = "File is not an image";
  }

  if (file_exists($file)) {
    $uploadable = FALSE;
    $message = "File already exists";
  }

  // if ($_FILES[$image]['size'] > 500000) {
  //   $uploadable = FALSE;
  //   $message = "File is too large";
  // }

  if ($uploadable) {
    if (move_uploaded_file($_FILES[$image]['tmp_name'], $file)) {
      $message = TRUE;
    } else {
      $message = "There was a problem uploading your file";
    }
  }

  return array($file, $message);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["add_form_pin_submit"])) {

  $tags_input = explode('#', $_POST['add_form_pin_tags']);
  array_splice($tags_input, 0, 1);

  $tags = array();
  $tag_names = array();

  for ($i=0; $i<(sizeof($tags_input)); $i++) {
    $tag = explode(' ', $tags_input[$i]);

    if (!in_array($tag[0], $tag_names)) {
      array_push($tag_names, $tag[0]);
      array_push($tags, $tag);
    }
  }

  $name = $_POST['add_form_pin_name'];
  $link = $_POST['add_form_pin_link'];
  $notes = $_POST['add_form_pin_notes'];
  $image = 'add_form_pin_img';

  $valid = TRUE;

  if (!preg_match("/^[0-9A-Za-z',. _-]*$/", $name)) {$valid = FALSE; $name_message = "Invalid pin name";}

  if (!preg_match("/%^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu/", $link)) {
    $valid = FALSE; $link_message = "Invalid url";
  }

  $image_message = uploadImage($image)[1];
  $image_path = uploadImage($image)[0];
  $valid = ($image_message === TRUE)?TRUE:FALSE;


  if ($valid) {
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $link = filter_var($link, FILTER_SANITIZE_URL);
    $notes = filter_var($notes, FILTER_SANITIZE_URL);
    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $date = date('F d, Y');
    $image_desc = "Image for pin:" . $name;

    $sql_image = "INSERT INTO images (src, description) VALUES (:img_src, :img_desc)";
    $sql_get_image_id = "SELECT id FROM images ORDER BY id DESC LIMIT 1";
    $board_id = $_POST["add_form_pin_submit"];
    $sql_pin = "INSERT INTO pins (board_id, image_id, name, link, description, date) VALUES (:board_id, :image_id, :pin_name, :pin_link, :pin_notes, :pin_date)";
    $sql_get_pin_id = "SELECT id FROM pins ORDER BY id DESC LIMIT 1";

    $sql_tag = "INSERT INTO tags (pin_id, name, color) VALUES (:pin_id, :tag_name, :tag_color)";


    exec_sql_query($db, $sql_image, array(":img_src"=>$image_path, ":img_desc"=>$image_desc));
    $image_id = exec_sql_query($db, $sql_get_image_id)->fetchAll();

    exec_sql_query($db, $sql_pin, array(":board_id"=>$board_id, ":image_id"=>$image_id[0]["id"], ":pin_name"=>$name, ":pin_link"=>$link, ":pin_notes"=>$notes, ":pin_date"=>$date));
    $pin_id = exec_sql_query($db, $sql_get_pin_id)->fetchAll();

    foreach($tags as $tag) {
      exec_sql_query($db, $sql_tag, array(":pin_id"=>$pin_id[0]["id"], ":tag_name"=>$tag[0], ":tag_color"=>$tag[1]));
    }
  }
}

?>