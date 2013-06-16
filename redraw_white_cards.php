<?php

include 'pdo_db_include.php';

$uid = $_REQUEST['uid'];
$game_id = $_REQUEST['game_id'];
$cards = $_REQUEST['cards'];

  $cards_split = explode(';', $cards);
  
  $STH1 =  $DBH->prepare("update user_hand set active = 0 where user_uid = :uid and game_id = :game_id and  white_card_id = :value");
  $i = 0;
  foreach($cards_split as $value)
  { 
     $STH1->bindParam(':game_id', $game_id);
     $STH1->bindParam(':uid',$uid);
     $STH1->bindParam(':value',$value);
     $STH1->execute();
     $i++;
  }
 
  $STH2 = $DBH->prepare("SELECT number_redraws from player_list where uid = :uid");
  $STH2->bindParam(':uid', $uid);
  $STH2->execute();
  $num_redraw = $STH2->fetch();

  $new_redraw_number = $num_redraw[0] + $i; 
  //need to modify the total number redrawn
  $STH3 =  $DBH->prepare("update player_list set number_redraws = $new_redraw_number where uid = :uid");
  $STH3->bindParam(':uid',$uid);
  $STH3->execute(); 
  

?>
