<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["board_edit_submit"])){
  $update_id = $_POST["board_edit_submit"];
  $color = $_POST["board_color"];
  $name = $_POST["board_name"];

  $valid = TRUE;
  if (!preg_match("/^[0-9A-Za-z&',. _-]*$/", $name)) {$valid = FALSE; $name_update_message = "Invalid board name";}


  if ($valid) {
    $sql_update = "UPDATE boards SET name = :name, color = :color WHERE id = :id";
    exec_sql_query($db, $sql_update, array(":name"=>$name, ":color"=>$color, ":id"=>$update_id));
  }

}

?>
