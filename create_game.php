<?php

include 'pdo_db_include.php';

$STH = $DBH->query('select max(game_code) from game_details');

$nextCode = $STH->fetch();
$nextCode = $nextCode[0] + 1;
$time = time();
$DBH->exec("insert into game_details values ('$nextCode', '$time')");
?>
<div data-role="page">
  <div data-role="header">
    <h1>Game Code</h1>
  </div><!-- /header -->

  <div data-role="content">
    <center><h1><?php echo $nextCode ?></h1></center>
  </div>
</div>
