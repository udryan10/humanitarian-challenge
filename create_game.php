<?php

include 'pdo_db_include.php';

$STH = $DBH->query('select max(game_code) from game_details');

$redraw_allow = $_POST["redraw_input"];
$nextCode = $STH->fetch();
$nextCode = $nextCode[0] + 1;
$time = time();
$DBH->exec("insert into game_details values ('$nextCode', '$time', '$redraw_allow')");
?>
<div data-role="dialog">
  <div data-role="header">
    <h1>Game Code</h1>
  </div><!-- /header -->

  <div data-role="content">
    <center><h1><?php echo $nextCode ?></h1></center>
    <form>
      <a href="index.html" id='game_codeclose' data-role='button'> Close </a>
    </form>
  </div>
</div>
