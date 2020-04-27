<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["trash-confirmation"])) {
  $ids = explode(',' ,$_POST['trash-confirmation']);
  $pin_id = $ids[0]; $board_id = $ids[1];

  $sql_get_img_id = "SELECT image_id FROM pins WHERE id = :id";
  $sql_get_img_src = "SELECT src FROM images WHERE id = :img_id";
  $sql_pin_delete = "DELETE FROM pins WHERE id = :id";
  $sql_tag_delete = "DELETE FROM tags WHERE pin_id = :id";

  $img_id = (exec_sql_query($db, $sql_get_img_id, array(':id'=>$pin_id))->fetchAll())[0]["image_id"];
  $img_src = (exec_sql_query($db, $sql_get_img_src, array(':img_id'=>$img_id))->fetchAll())[0]["src"];
  unlink($img_src);

  exec_sql_query($db, $sql_pin_delete, array(':id'=>$pin_id));
  exec_sql_query($db, $sql_tag_delete, array(':id'=>$pin_id));

  $header_location = "Location: pins.php?board_id=" . $board_id;
  header($header_location);
}

?>
