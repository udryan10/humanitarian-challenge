<?php

include 'pdo_db_include.php';

$uid = $_REQUEST['uid'];
$game_id = $_REQUEST['game_id'];
$user_full_cards = 10;

$STH = $DBH->prepare("select count(*) from user_hand where user_uid = :uid and active = 1");
$STH->bindParam(':uid',$uid);
$STH->execute();


$countHolder = $STH->fetch();
$countHolder = $countHolder[0];

$cardsNeeded = $user_full_cards - $countHolder;
//delete 
//draw more cards
if($cardsNeeded > 0 )
{
	//TODO: check to make sure cards needed is < cards available
	$STH2 = $DBH->prepare("SELECT * from white_card_deck where id NOT IN (select white_card_id from user_hand where game_id = :game_id) ORDER BY RAND( ) LIMIT 0,$cardsNeeded");
	$STH2->bindParam(':game_id',$game_id);
 	$STH2->execute();	


	$newCardsAvailable = $STH2->rowCount();
	if($newCardsAvailable < $cardsNeeded)
	{
		$STH3 = $DBH->prepare("delete from user_hand where active = 0 and game_id = :game_id");
		$STH3->bindParam(':game_id',$game_id);
		$STH3->execute();

		$STH2->execute();
	}
	$time = time();
	$STH4 = $DBH->prepare("INSERT INTO user_hand values (:uid,:newcard,:game_id,1,$time)");
	while($queryNewCardsHolder = $STH2->fetch())
	{

	
		$STH4->bindParam(':uid',$uid);
		$STH4->bindParam(':newcard',$queryNewCardsHolder[0]);
		$STH4->bindParam(':game_id',$game_id);

		$STH4->execute();	
	}	
}


	$STH5 = $DBH->prepare("select user_hand.white_card_id, white_card_deck.text from user_hand, white_card_deck where user_hand.white_card_id = white_card_deck.id and user_hand.user_uid = :uid and active = 1 order by time");
	$STH5->bindParam(':uid',$uid);
	$STH5->execute();


        $jsonBuild = "{";
        $i = 1;
        while($queryCurrentHandHolder = $STH5->fetch())
        {
                if($i == 1)
                {
                        $jsonBuild .= '"' . $i . '_white_card_contents": [{"card_text":"' . $queryCurrentHandHolder[1] . '","card_id": "' . $queryCurrentHandHolder[0] . '"}]';
                }
                else
                {
                        $jsonBuild .= ',"' . $i . '_white_card_contents": [{"card_text":"' . $queryCurrentHandHolder[1] . '","card_id": "' . $queryCurrentHandHolder[0] . '"}]';
                }

                $i++;
        }
        while($i <= $user_full_cards)
        {
                if($i == 1)
                {
                    $jsonBuild .= '"' . $i . '_white_card_contents": [{"card_text":"","card_id": "-1"}]';
                }
                else
                {
                    $jsonBuild .= ',"' . $i . '_white_card_contents": [{"card_text":"","card_id": "-1"}]';
                }
                $i++;
        }
        $jsonBuild .= "}";

        echo $jsonBuild;
?>
