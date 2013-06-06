<?php

include 'pdo_db_include.php';

//TODO: handle to make sure there are black cards left
$game_id = $_REQUEST['game_id'];

//get count of players in game
$STH = $DBH->prepare("select count(*) from player_list where game_id = :game_id");
$STH->bindParam(':game_id', $game_id);
$STH->execute();

$countHolder = $STH->fetch();
$numPlayers = $countHolder[0];

$STH2 = $DBH->prepare("select count(*) from card_submit_pile where game_uid = :game_id");
$STH2->bindParam(':game_id', $game_id);
$STH2->execute();

$submittedCountHolder = $STH2->fetch();
$numPlayersSubmitted = $submittedCountHolder[0];

if( $numPlayers != 1 && $numPlayers == ($numPlayersSubmitted + 1) )
{

	//build out player, card list
	$jsonBuild = "{\"allsubmitted\" : \"true\", \"submissions\" : [{";
	
	$STH3 =  $DBH->prepare("select user_uid, cards_id_combined from card_submit_pile where game_uid = :game_id");
	$STH3->bindParam(':game_id', $game_id);
	$STH3->execute();

	$i = 0;
        while( $rowHolder = $STH3->fetch())
	{
		//0 contains uid and 1 contains cards_id_combined
		
	       $card_text_builder = '';
	       $cards_split = explode(';', $rowHolder[1]);
	       
	       
	       $STH4 = $DBH->prepare("select text from white_card_deck where id = :value");
	       foreach($cards_split as $value)
	       {
 		  $STH4->bindParam(':value', $value);
		  $STH4->execute();

		  $cardTextHolder = $STH4->fetch();
		  $card_text_builder .=  "$cardTextHolder[0];";
	       }
	       if($i == 0)
	       {
	         $jsonBuild .= "\"$rowHolder[0]\": \"$card_text_builder\"";
	       }
	       else
		{
	         $jsonBuild .= ", \"$rowHolder[0]\": \"$card_text_builder\"";
		}
		$i++;
		

	}	
	$jsonBuild .= "}]}";
	echo $jsonBuild;
}
else //not everyone has submitted yet
{

	//just return number submitted so far
	$lefttosubmit = $numPlayers - $numPlayersSubmitted - 1 ;
	$jsonBuild = "{ \"allsubmitted\": \"false\",
			\"numneedingtosubmit\" : \"$lefttosubmit\"
		      }";
	echo $jsonBuild;
}


?>
