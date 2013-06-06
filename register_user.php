<?php
        include 'pdo_db_include.php';

	//passed in variables
	$player_name = $_REQUEST['player_name'];
	$code = $_REQUEST['code_box'];

	
	$STH = $DBH->prepare("select count(*) from game_details where game_code = :code");
        $STH->bindParam(':code',$code);
        $STH->execute();


	$gamecodeCheck = $STH->fetch();
	$gamecodeCheck = $gamecodeCheck[0];
        
        //not a valid game code, someone first needs to generate a game code
	if($gamecodeCheck == 0)
	{
		$jsonBuild = '{ 
				"returnstatus": "error", 
				"returnmessage": "Not a valid game code. please enter again" 
			      }';
	 	echo $jsonBuild;	
		
	}
	else
	{
	$STH2 = $DBH->prepare("select count(*) from player_list where game_id = :code");
	$STH2->bindParam(':code',$code);
        $STH2->execute();

	$rowHolder = $STH2->fetch();
	if($rowHolder[0] == 0)
	{
		$STH3 = $DBH->prepare("insert into player_list (name,game_id,points,czar) value (:player_name, :code, 0 ,1)");
		$STH3->bindParam(':player_name',$player_name);
	        $STH3->bindParam(':code',$code);
		$STH3->execute();

	}
	else
	{

		$STH4 = $DBH->prepare("insert into player_list (name,game_id,points,czar) value (:player_name, :code, 0 ,0)")
;
                $STH4->bindParam(':player_name',$player_name);
                $STH4->bindParam(':code',$code);
                $STH4->execute();
	}
	
		$STH5 =  $DBH->prepare("select uid from player_list where name = :player_name and game_id = :code");
		$STH5->bindParam(':player_name',$player_name);
                $STH5->bindParam(':code',$code);
                $STH5->execute();

		$rowHolder2 = $STH5->fetch();

		$rowHolder2 = $rowHolder2[0];
		$jsonBuild = "{
				\"returnstatus\": \"success\",
				\"player_uid\": \"$rowHolder2\",
				\"game_uid\" : \"$code\"
			      }";

		echo $jsonBuild;

	}




?>
