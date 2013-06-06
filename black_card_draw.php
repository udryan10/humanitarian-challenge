<?php

include 'pdo_db_include.php';


$uid = $_REQUEST['uid'];
$game_id = $_REQUEST['game_id'];

$STH = $DBH->prepare("update black_card_discard set active = 0 where active = 1 and game_id = :game_id");
$STH->bindParam(':game_id', $game_id);
$STH->execute();


$STH2 = $DBH->prepare("select id from black_card_deck where id not in (select black_card_id from black_card_discard where game_id = :game_id ) ORDER BY RAND() LIMIT 0,1");
$STH2->bindParam(':game_id', $game_id);
$STH2->execute();


$numRows = $STH2->rowCount();

//went through all of the black cards - reshuffle
if($numRows == 0)
{
	$STH3 = $DBH->prepare("delete from black_card_discard where game_id = :game_id");
	$STH3->bindParam(':game_id', $game_id);
	$STH3->execute();

	$STH2->execute();
}

$rowHolder = $STH2->fetch();

$fetchedCard = $rowHolder[0];


$STH4 = $DBH->prepare("insert into black_card_discard values (:fetched_card, :game_id, :uid, 1)");
$STH4->bindParam(':fetched_card',$fetchedCard);
$STH4->bindParam(':game_id',$game_id);
$STH4->bindParam(':uid',$uid);
$STH4->execute();


?>
