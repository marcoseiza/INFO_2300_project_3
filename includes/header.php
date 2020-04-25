<?php

function header_constructor($main = FALSE) {
  if ($main) {?>
    <header class="header--main">

    </header>
  <?php } else {?>
    <header class="header--user">

    </header>
  <?php }
}?>
