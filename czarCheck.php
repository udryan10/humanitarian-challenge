<?php

include 'pdo_db_include.php';

$uid = $_REQUEST['uid'];

$STH = $DBH->prepare("select czar from player_list where uid = :uid");
$STH->bindParam(':uid',$uid);
$STH->execute();


$czarCheck = $STH->fetch();

$czarCheck1 = $czarCheck[0];

$jsonBuild = "{
		\"isczar\":\"$czarCheck1\"
	      }";
echo $jsonBuild;


?>
