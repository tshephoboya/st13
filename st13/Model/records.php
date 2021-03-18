<?php

class Records 
{
	private $drawNumber;
	private $correctGuesses;
	private $payOut;
	private $betAmt;
	private $resultsFile;
	private $userPlay;

	public function __construct($num, $guess, $pay, $bet, $res, $play)
	{
		$this->drawNumber = $num;
		$this->correctGuesses = $guess;
		$this->payOut = $pay;
		$this->betAmt = $bet;
		$this->resultsFile = $res;
		$this->userPlay = $play;
	}

	public function add(PDO $pdo) 
	{
		$sql = "INSERT INTO records (draw, guess, payout, bet, results, userplay) VALUES (?,?,?,?,?, ?)";
		$stmt= $pdo->prepare($sql);
		$stmt->execute([$this->drawNumber, $this->correctGuesses, $this->payOut, $this->betAmt, $this->resultsFile, $this->userPlay]);
	}

	public function viewall(PDO $pdo)
	{

	}


	public static function uploadFile($name, $type)
	{
		$file_name = $_FILES[$name]['name'];
		$file_temp = $_FILES[$name]['tmp_name'];
		 
		$exp = explode(".", $file_name);
		$ext = strtolower(end($exp));
		$file = time().'-'.$type.'.'.$ext;
		$location = "../journalfiles/".$file;
		move_uploaded_file($file_temp, $location);

		return $file;
	}
}

?>