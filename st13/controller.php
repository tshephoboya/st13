<?php
if (isset($_POST['name']))
{
	include('Model\Predictor.php');	

	#Grab all the data.
	$name = htmlentities($_POST['name']);
	$teamForm = floatval($_POST['teamForm']);
	$isHome = htmlentities($_POST['isHome']);
	$teamStrength = intval($_POST['teamStrength']);
	$haRecord = $_POST['haRecord'];
	$ins = $_POST['ins'];
	$odds = floatval($_POST['odds']);
	$discipline = intval($_POST['discipline']);
	$gamesPlayed = intval($_POST['gamesPlayed']);

	
	$teamPrediction = new Predictor($name, $isHome, $teamStrength, $haRecord, $teamForm, $ins, $odds, $discipline, $gamesPlayed);

	$teamPrediction->doCalc();

	echo json_encode($teamPrediction->totalScore);
}

?>