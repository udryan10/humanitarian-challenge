<?php

//include 'db_include.php';
include 'pdo_db_include.php';


$game_id = $_REQUEST['game_id'];


$STH = $DBH->prepare("select black_card_deck.text,black_card_deck.Pick2,black_card_deck.id from black_card_deck, black_card_discard where black_card_discard.black_card_id = black_card_deck.id and game_id = :game_id and active = 1");
$STH->bindParam(':game_id', $game_id);
$STH->execute();

if($STH->rowCount() > 0)
{
        $rowHolder = $STH->fetch();
        $newCard = $rowHolder[0];
        $pick2 = $rowHolder[1];
        $cardid = $rowHolder[2];

        $jsonBuild = "{
                \"cardtext\": \"$newCard\",
                \"pick2\" : \"$pick2\",
                \"cardid\" : \"$cardid\"
              }";
         echo $jsonBuild;
}
else
{
        $jsonBuild =  "{
                \"cardtext\": \"\",
                \"pick2\" : \"0\",
                \"cardid\" : \"-1\"
              }";
        echo $jsonBuild;
}

?>
