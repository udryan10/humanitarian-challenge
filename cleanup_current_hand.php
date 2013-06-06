<?php

include 'pdo_db_include.php';

$game_id = $_REQUEST['game_id'];

$STH = $DBH->prepare("select uid,czar from player_list where game_id = :game_id order by uid");
$STH->bindParam(':game_id', $game_id);
$STH->execute();


$numPlayers = $STH->rowCount(); 

$i = 1;

while($currentRowHolder = $STH->fetch())
{
	if($i == 1 ) //first row, save the uid
	{
		$firstuid = $currentRowHolder[0];
	}

	if($currentRowHolder[1] == 1 && $i == $numPlayers) //czar is the last one in the table - update first user
	{
	   $uidtosetczar = $firstuid; 
	   break;
	}
        else if($currentRowHolder[1] == 1 && $i < $numPlayers) //czar will be the guy in the next row
	{
	   $getczarHolder = $STH->fetch();
	   $uidtosetczar = $getczarHolder[0];
	   break;    
	}
	
	$i++;

}

//remote from submitted card pile to stage for next hand
$STH2 = $DBH->prepare("delete from card_submit_pile where game_uid = :game_id");
$STH2->bindParam(':game_id', $game_id);
$result1 = $STH2->execute();
//discard our current black card
$STH3 = $DBH->prepare("update black_card_discard set active = 0 where game_id = :game_id");
$STH3->bindParam(':game_id', $game_id);
$result2 = $STH3->execute();

$STH4 = $DBH->prepare("update player_list set czar = 0 where czar = 1 and game_id = :game_id");
$STH4->bindParam(':game_id', $game_id);
$result3 = $STH4->execute();

$STH5 =  $DBH->prepare("update player_list set czar = 1 where uid = :uidtosetczar");
$STH5->bindParam(':uidtosetczar',$uidtosetczar);
$result4 = $STH5->execute();

if($result1 && $result2 && $result3 && $result4)
{
	$jsonBuild = '{ "return_status": "success" }';
}
else
{
	$jsonBuild = '{ "return_status": "error" }';
}

?>
