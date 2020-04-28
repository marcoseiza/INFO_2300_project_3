<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["trash-confirmation"])){

  $id = $_POST["trash-confirmation"];

  $sql_add = "DELETE FROM boards WHERE id = :id";
  exec_sql_query($db, $sql_add, array(":id"=>$id));

}


?>
