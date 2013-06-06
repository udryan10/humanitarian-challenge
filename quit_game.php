<?php

include 'pdo_db_include.php';

  $uid = $_REQUEST['uid'];
  $game_id = $_REQUEST['game_id'];

 $STH = $DBH->prepare("select czar from player_list where uid = :uid");
 $STH->bindParam(':uid', $uid);
 $STH->execute();


  $rowHolder = $STH->fetch(); 
  if($rowHolder[0] == 1)
  //user is the czar, need to make someone else the czar
  {
     $STH2 = $DBH->prepare("select uid from player_list where game_id = :game_id and uid != :uid order by uid limit 0,1");
     $STH2->bindParam(':uid', $uid);
     $STH2->bindParam(':game_id', $game_id);
     $STH2->execute();
   
     $rowHolder2 = $STH2->fetch();
     
     $DBH->exec("update player_list set czar = 1 where uid = $rowHolder2[0]");

     $STH6 = $DBH->prepare("update black_card_discard set active = 0 where game_id = :game_id and user_uid = :uid");
     $STH6->bindParam(':uid', $uid);
     $STH6->bindParam(':game_id', $game_id);
     $STH6->execute();
   
  
  }
 
  $STH3 = $DBH->prepare("update user_hand set active = 0 where user_uid = :uid and game_id = :game_id");
  $STH3->bindParam(':uid', $uid);
  $STH3->bindParam(':game_id', $game_id);
  $STH3->execute();

  $STH4 = $DBH->prepare("delete from player_list where uid = :uid");
  $STH4->bindParam(':uid', $uid);
  $STH4->execute();
  
  $STH5 =  $DBH->prepare("delete from card_submit_pile where game_uid = :game_id");
  $STH5->bindParam(':game_id', $game_id);
  $STH5->execute();


?>
