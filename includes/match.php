<?php
class Match {
	public $_id;
	private $id;
	private Match $nextMatch, $previousMatchA, $previousMatchB;
	private Tournament $tournament;
	private Competitor $competitor_1,$competitor_2, $winner;
	private $score_1;
	private $score_2;

	function __construct() {
		$params= func_get_args();
		$num_params=func_num_args();
		$func_constr ='__construct'.$num_params;

		if(method_exists($this, $func_constr))
			call_user_func_array(array($this,$func_constr), $params);
	}

	function __construct0(){
	}

	function __construct1($id){
		if($id instanceof Match){
			$this->id=$id->id;
			$this->score_1=$id->score_1;
			$this->score_2=$id->score_2;

			if(isset($id->previousMatchA))
				$this->previousMatchA=$id->previousMatchA;

			if(isset($id->previousMatchB))
				$this->previousMatchB=$id->previousMatchB;

			if(isset($id->nextMatch))
				$this->nextMatch=$id->nextMatch;

			if(isset($id->competitor_1))
				$this->competitor_1=$id->competitor_1;

			if(isset($id->competitor_2))
				$this->competitor_2=$id->competitor_2;

			if(isset($id->tournament))
				$this->tournament=$id->tournament;
			if(isset($id->winner))
				$this->winner=$id->winner;
		} else
			$this->id=$id;
	}

	function __construct3($id,Tournament $t, Competitor $c1){
		$this->id=$id;
		$this->tournament=$t;
		$this->competitor_1=$c1;
	}

	function __construct4($id,Tournament $t, Competitor $c1,Competitor $c2){
		$this->id=$id;
		$this->tournament=$t;
		$this->competitor_1=$c1;
		$this->competitor_2=$c2;
	}

	public function getInfo(){
		$ret=$this->id.': ';

		$retA="";
		$retB="";

		if(isset($this->competitor_1))
			$retA=$this->competitor_1->getNickname();
		else if(isset($this->previousMatchA))
			$retA='Ganador de '.$this->previousMatchA->getId();

		if(isset($this->competitor_2))
			$retB=$this->competitor_2->getNickname();
		else if(isset($this->previousMatchB))
			$retB='Ganador de '.$this->previousMatchB->getId();

		return $ret.$retA.' vs '.$retB;
	}

	public function getTournament(){
		return $this->tournament;
	}

	public function getId(){
		return $this->id;
	}

	public function setNextMatch(Match $match){
		$this->nextMatch=$match;
	}

	public function setPreviousMatches(Match $matchA,Match $matchB){
		$this->previousMatchA=$matchA;
		$this->previousMatchB=$matchB;
	}

	public function getWinner(){
		return $this->winner;
	}

	public function setScore($s1,$s2, $def=false){
		$this->score_1=$s1;
		$this->score_2=$s2;

		if($def){
			if($this->score_1>$this->score_2)
				$this->winner=$this->competitor_1;
			else
				$this->winner=$this->competitor_2;

			if(isset($this->nextMatch))
				$this->nextMatch->setWinner($this);
		}
	}

	public function setWinner(Match $pMatch){
		if($this->previousMatchA==$pMatch)
			$this->competitor_1=$this->previousMatchA->getWinner();
		else
			$this->competitor_2=$this->previousMatchB->getWinner();
	}

	public function getData(){
		$ret=$this->id;

		$retA="";
		$retB="";

		if(isset($this->competitor_1))
			$retA=$this->competitor_1->getNickname();
		else if(isset($this->previousMatchA))
			$retA='Ganador de '.$this->previousMatchA->getId();

		if(isset($this->competitor_2))
			$retB=$this->competitor_2->getNickname();
		else if(isset($this->previousMatchB))
			$retB='Ganador de '.$this->previousMatchB->getId();

		return [$ret,$retA,$retB];
	}

	public function getCompetitor1(){
		return $this->competitor_1;
	}

	public function getCompetitor2(){
		return $this->competitor_2;
	}
}