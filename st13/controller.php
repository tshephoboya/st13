<?php
if (isset($_POST['name']))
{
	include('Predictor.php');	

	#Grab all the data.
	$name = htmlentities($_POST['name']);
	$teamForm = htmlentities($_POST['teamForm']);
	$isHome = htmlentities($_POST['isHome']);
	$teamStrength = intval($_POST['teamStrength']);
	$avd = $_POST['avd'];
	$haRecord = $_POST['haRecord'];
	$turnAround = intval($_POST['turnAround']);
	$ins = $_POST['ins'];
	$odds = floatval($_POST['odds']);
	$discipline = intval($_POST['discipline']);
	$gamesPlayed = intval($_POST['gamesPlayed']);
	$ppg = intval($_POST['ppg']);

	
	$teamPrediction = new Predictor($name, $isHome, $teamStrength, $haRecord, $teamForm, $avd, $turnAround, $ins, $odds, $discipline, $gamesPlayed, $ppg);

	$teamPrediction->doCalc();

	echo json_encode($teamPrediction->totalScore);
}

?>