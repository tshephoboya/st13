<?php
include('ratio.trait.php');


class Predictor extends Ratios
{
	private $name;
	private $teamForm;
	private $teamStrength;
	private $isHome;
	private $homeAwayRecord;
	private $ins; #Injuries and suspensions
	private $odds;
	private $discipline;
	private $gamesPlayed;
	private $ppg; #Points per game
	public $totalScore;


	public function __construct($name, $isHome, $teamStrength, $homeAwayRecord, $teamForm,  $ins, $odds, $discipline, $gamesPlayed)
	{
		$this->name = $name;
		$this->teamForm = $teamForm;
		$this->isHome = $isHome;
		$this->teamStrength = $teamStrength;
		$this->homeAwayRecord = $homeAwayRecord;
		$this->ins = $ins;
		$this->odds = $odds;
		$this->discipline = $discipline;
		$this->gamesPlayed = $gamesPlayed;
		
		$this->totalScore = 0;
	}

	public function doCalc() 
	{
		
		$this->calcAvsd();
		$this->calcForm();
		$this->calcTeamStrength();
		$this->calcHomeAway();
		$this->calcIns();
		$this->calcDiscipline();
		$this->calcIsHome();
	}

	private function calcAvsd() 
	{
		$fScore = (1/$this->odds) * Ratios::AVD;
		$this->updateScore($fScore);
	}



	#Should change to an exponential calculation method
	private function calcForm() 
	{
		$score = ($this->teamForm / 3 ) * Ratios::TEAM_FORM;
		$this->updateScore($score);
	}


	private function calcTeamStrength() 
	{
		$score = ($this->teamStrength / 100) * Ratios::TEAM_STRENGTH;
		$this->updateScore($score);
	}

	private function calcHomeAway() 
	{
		$score = ($this->homeAwayRecord / 3) * Ratios::HOME_AWAY_REC;
		$this->updateScore($score);
	}


	private function calcIns() 
	{
		$score =  (intval($this->ins[0]) / intval($this->ins[1])) * Ratios::INS;
		$this->updateScore($score);
	}


	private function calcDiscipline() 
	{
		$average = $this->discipline / $this->gamesPlayed;

		if ($average <= 1)
		{
			$score = 10;
		}
		else if ($average > 1 && $average <= 1.5)
		{
			$score = 7;
		}
		else if ($average > 1.5 && $average <= 2) 
		{
			$score = 4;
		}
		else
		{
			$score = 1;
		}

		$fScore = ($score / 10) * Ratios::DISCIPLINE;
		$this->updateScore($fScore);
	}


	private function calcIsHome() 
	{
		if ($this->isHome == 'Yes') 
		{
			$this->updateScore(Ratios::HOME_ADVANTAGE);
		}
	}


	private function updateScore($score) 
	{
		$this->totalScore += $score;
	}

	
}

?>