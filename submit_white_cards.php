<?php

include 'pdo_db_include.php';

$uid = $_REQUEST['uid'];
$game_id = $_REQUEST['game_id'];
$cards = $_REQUEST['cards'];

$STH = $DBH->prepare("insert into card_submit_pile values (:uid,:game_id,:cards)");
$STH->bindParam(':game_id', $game_id);
$STH->bindParam(':uid',$uid);
$STH->bindParam(':cards',$cards);
$status = $STH->execute();

if($status)
{
  $cards_split = explode(';', $cards);
  
  $STH2 =  $DBH->prepare("update user_hand set active = 0 where user_uid = :uid and game_id = :game_id and  white_card_id = :value");
  foreach($cards_split as $value)
  { 
     $STH2->bindParam(':game_id', $game_id);
     $STH2->bindParam(':uid',$uid);
     $STH2->bindParam(':value',$value);
     $STH2->execute();
  }
}


?>
