<?php
include('ratio.trait.php');


class Predictor extends Ratios
{
	private $name;
	private $teamForm;
	private $teamStrength;
	private $isHome;
	private $attackDefence;
	private $homeAwayRecord;
	private $turnAround;
	private $ins; #Injuries and suspensions
	private $odds;
	private $discipline;
	private $gamesPlayed;
	private $ppg; #Points per game
	public $totalScore;


	public function __construct($name, $isHome, $teamStrength, $homeAwayRecord, $teamForm, $attackDefence, $turnAround, $ins, $odds, $discipline, $gamesPlayed, $ppg)
	{
		$this->name = $name;
		$this->teamForm = $teamForm;
		$this->isHome = $isHome;
		$this->teamStrength = $teamStrength;
		$this->attackDefence = $attackDefence;
		$this->homeAwayRecord = $homeAwayRecord;
		$this->turnAround = $turnAround;
		$this->ins = $ins;
		$this->odds = $odds;
		$this->discipline = $discipline;
		$this->gamesPlayed = $gamesPlayed;
		$this->ppg = $ppg;
		$this->totalScore = 0;
	}

	public function doCalc() 
	{
		$this->calcOdds();
		$this->calcAvsd();
		$this->calcForm();
		$this->calcTeamStrength();
		$this->calcPPG();
		$this->calcHomeAway();
		$this->calcIns();
		$this->calcDiscipline();
		$this->calcIsHome();
	}


	private function calcOdds() 
	{
		$score = (1 / $this->odds) * Ratios::ODDS;
		$this->updateScore($score);
	}


	private function calcAvsd() 
	{
		$teamOneAttack = intval($this->attackDefence[0][0]);
		$teamOneDefence = intval($this->attackDefence[0][1]);
		$teamTwoAttack = intval($this->attackDefence[1][0]);
		$teamTwoDefence = intval($this->attackDefence[1][1]);

		$ad = $teamOneAttack - $teamTwoDefence;
		$da = $teamTwoAttack - $teamOneDefence;

		#How likely they are to score
		if ($ad <= 0.1)
		{
			$score = 0;
		}
		else if ($ad > 0.1 && $ad <= 0.2)
		{
			$score = 2;
		}
		else if ($ad > 0.2 && $ad <= 0.3)
		{
			$score = 3;
		}
		else if ($ad > 0.3 && $ad <= 0.4)
		{
			$score = 4;
		}
		else
		{
			$score = 5;
		}


		#How likely they are to conced
		if ($da <= 0.1)
		{
			$score += 5;
		}
		else if ($da > 0.1 && $da <= 0.2)
		{
			$score += 4;
		}
		else if ($da > 0.2 && $da <= 0.3)
		{
			$score += 3;
		}
		else if ($da > 0.3 && $da <= 0.4)
		{
			$score += 2;
		}
		else
		{
			$score += 1;
		}

		$fScore = ($score / 10) * Ratios::AVD;
		$this->updateScore($fScore);
	}



	#Should change to an exponential calculation method
	private function calcForm() 
	{
		$numWins = 0;
		$numDraws = 0;
		$gamesCount = array_count_values(str_split($this->teamForm));
		if (array_key_exists('w', $gamesCount))
		{
			$numWins = $gamesCount['w'] * 5;
		}

		if (array_key_exists('d', $gamesCount))
		{
			$numDraws = $gamesCount['d'] * 2;
		}
		
		
		$score = (($numWins + $numDraws) / 25 ) * Ratios::TEAM_FORM;
		$this->updateScore($score);
	}


	private function calcTeamStrength() 
	{
		$score = ($this->teamStrength / 100) * Ratios::TEAM_STRENGTH;
		$this->updateScore($score);
	}


	private function calcPPG() 
	{
		$score = ($this->ppg / 3) * Ratios::PPG;
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