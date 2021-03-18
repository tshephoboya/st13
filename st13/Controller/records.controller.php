<?php

if (isset($_POST['drawNumber']))
{

	include('../Model/records.php');	
	include('../Model/database.php');

	#try to get PDO connection
	$pdo = Database::getConnection();
	if ($pdo)
	{
		$drawNumber = htmlentities($_POST['drawNumber']);
		$correctPlay = intval($_POST['correctPlay']);
		$payOut = htmlentities($_POST['payOut']);
		$betAmt = intval($_POST['betAmt']);

		$resFileName = Records::uploadFile('resultsFile', 'res');
		$userPlay = Records::uploadFile('userPlay', 'usr');

		$record = new Records($drawNumber, $correctPlay, $payOut, $betAmt, $resFileName, $userPlay);
		$record->add($pdo);

		$pdo = null;

		echo json_encode(['results'=>true]);
	}
	else
	{
		#failed to create a database connection exit script
		echo json_encode(['results'=>false]);
	}

}

?>