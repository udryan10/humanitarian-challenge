<?php

include 'pdo_db_include.php';


$game_id = $_REQUEST['game_id'];
$uid = $_REQUEST['uid'];


$STH = $DBH->prepare("SELECT number_redraws from player_list where uid = :uid");
$STH->bindParam(':uid', $uid);
$STH->execute();

$STH2 = $DBH->prepare("SELECT num_redraw_allowed from game_details where game_code = :game_id");
$STH2->bindParam(':game_id', $game_id);
$STH2->execute();

$jsonBuild = "{";

$num_redraw = $STH->fetch();
$num_redraw_allowed = $STH2-> fetch();
$num_redraw_left = $num_redraw_allowed[0] - $num_redraw[0];

$jsonBuild .= "\"redraws_remaining\" : \"$num_redraw_left\"";
$jsonBuild .="}";

echo $jsonBuild;




?>
