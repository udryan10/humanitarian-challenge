<?php

include 'pdo_db_include.php';

//TODO: handle to make sure there are black cards left
$game_id = $_REQUEST['game_id'];
$winner_id = $_REQUEST['winner_id'];


$STH = $DBH->prepare("select points from player_list where uid = :winner_id");
$STH->bindParam(':winner_id',$winner_id);
$STH->execute();

$currentScoreholder = $STH->fetch();
$curscore = $currentScoreholder[0];
$curscore++;

$STH2 = $DBH->prepare("update player_list set wonlast = 0 where game_id = :game_id");
$STH2->bindParam(':game_id',$game_id);
$STH2->execute();

$STH3 = $DBH->prepare("update player_list set points = $curscore , wonlast = 1 where uid = :uid");
$STH3->bindParam(':uid',$winner_id);
$result = $STH3->execute();


if($result)
{
	
	$jsonBuild = '{ "return_status" : "success"}';
	echo $jsonBuild;
}
else
{
	$jsonBuild = '{ "return_status" : "fail"}';	
	echo $jsonBuild;
}

?>
