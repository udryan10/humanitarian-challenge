<?php

include 'pdo_db_include.php';

$card = $_REQUEST['card'];
$color = $_REQUEST['color']; 

$STH = $DBH->prepare("insert into stage_new_card values (:color, :card)");
$STH->bindParam(':card',$card);
$STH->bindParam(':color',$color);
$STH->execute();


?>
