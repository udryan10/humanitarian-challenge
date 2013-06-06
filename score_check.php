<?php

include 'pdo_db_include.php';


$game_id = $_REQUEST['game_id'];



$STH = $DBH->prepare("SELECT name, points, czar, wonlast from player_list where game_id = :game_id");
$STH->bindParam(':game_id', $game_id);
$STH->execute();
$jsonBuild = "{";
$i=0;

while($rowHolder = $STH->fetch()) {

	if($i == 0)
        {
          $jsonBuild .= "\"$rowHolder[0]\":  {\"score\" : \"$rowHolder[1]\", \"wonlast\" : \"$rowHolder[3]\", \"czar\" : \"$rowHolder[2]\"}";  
        }
        else
        {
          $jsonBuild .= ",\"$rowHolder[0]\": {\"score\" : \"$rowHolder[1]\", \"wonlast\" : \"$rowHolder[3]\", \"czar\" : \"$rowHolder[2]\"}";
        }
        $i++;

}
/*
while($rowHolder = mysql_fetch_array($queryResource))
{
	if($i == 0)
	{
		if($rowHolder[2] == 1) //this person is the czar, put a * by his name
		{
			$jsonBuild .= "\"$rowHolder[0]*\":  {\"score\" : \"$rowHolder[1]\", \"wonlast\" : \"$rowHolder[3]\"}";	
		}
		else
		{
			$jsonBuild .= "\"$rowHolder[0]\": {\"score\" : \"$rowHolder[1]\", \"wonlast\" : \"$rowHolder[3]\"}";
		}
	}
	else
	{
		if($rowHolder[2] == 1) //this person is the czar, put a * by his name
        	{
                 $jsonBuild .= ",\"$rowHolder[0]*\": {\"score\" : \"$rowHolder[1]\", \"wonlast\" : \"$rowHolder[3]\"}";
        	}
        	else
        	{
                 $jsonBuild .= ",\"$rowHolder[0]\": {\"score\" : \"$rowHolder[1]\", \"wonlast\" : \"$rowHolder[3]\"}";
        	}
        }
	$i++;	

}
*/
$jsonBuild .="}";

echo $jsonBuild;




?>
