<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["board_add_submit"])){
  $color = $_POST["board_color"];
  $name = $_POST["board_name"];
  date_default_timezone_set('America/New_York');
  $date = date('F d, Y');

  $valid = TRUE;
  if (!preg_match("/^[0-9A-Za-z&',. _-]*$/", $name)) {$valid = FALSE; $name_add_message = "Invalid board name";}


  if ($valid) {
    $sql_add = "INSERT INTO boards (name, color, date) VALUES (:name, :color, :date)";
    exec_sql_query($db, $sql_add, array(":name"=>$name, ":color"=>$color, ":date"=>$date));
  } else {
    $checked = "checked=''";
  }

}

?>
