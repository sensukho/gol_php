<?php

class Game_Of_Life {

	public $grid_size;
	public $grid;
	public $new_grid;
	public $limit1;
	public $limit2;
	public $rule1;
	public $rule2;
	public $content;
	public $a;

	public function __construct( $grid_size ) {
		$this->grid_size = $grid_size;
		$this->grid = ( isset( $_SESSION['grid'] ) )? $_SESSION['grid'] : array_map(function($n) { return array_map(function($m) { return 0; }, range(0, $this->grid_size) ); }, range(0, $this->grid_size) );
		$this->new_grid = array();
		$this->limit1 = $grid_size * $grid_size;
		$this->limit2 = $this->limit1 - 500;
		$this->rule1 = 2;
		$this->rule2 = 3;
		$this->content = '';
		$this->a = array();
	}

	private function initialize() {
		$this->grid = array_map(function($n) { return is_array( $n )? array_map(function($m) { return (rand(0,$this->limit1) > $this->limit2)? 1 : 0; }, $n) : 0; }, $this->grid );
	}

	private function display() {
		$this->content = '';
		array_map(function($n) { is_array( $n )? array_map(function($m) { $this->content .= ($m)? '<td class="living_cell">&nbsp;</td>' : '<td class="dead_cell">&nbsp;</td>'; }, $n) : 0; $this->content .= "</tr>\n"; }, $this->grid );
	}

	private function calcNeighbors() {
		$this->a = array();
		array_walk(	$this->grid, function(&$n, $key){ is_array( $n )? array_walk( $n, function(&$m, $y, $x){ $this->valNeighbors( $x, $y , $m ); }, $key ) : 0; } );
		$this->grid = $this->a;
	}

	public function valNeighbors($x, $y , $m){
		$neighbors = $this->getNeighbours($x,$y);
		($this->grid[$x][$y])? ($neighbors == $this->rule1 ||  $neighbors == $this->rule2 )? $this->a[$x][$y] = 1 : $this->a[$x][$y] = 0 : ($neighbors == $this->rule2)? $this->a[$x][$y] = 1 : $this->a[$x][$y] = 0;
	}

	public function getNeighbours($row, $col){
		return (integer)$this->grid[$row - 1][$col] + $this->grid[$row - 1][$col + 1] + $this->grid[$row][$col + 1] + $this->grid[$row + 1][$col + 1] + $this->grid[$row + 1][$col] + $this->grid[$row + 1][$col - 1] + $this->grid[$row][$col - 1] + $this->grid[$row - 1][$col -1];
	}

	public function update() {
			$this->calcNeighbors();
			$this->display();
			$_SESSION['grid'] = $this->grid;
			return $this->content;
	}

	public function start() {
		$this->initialize();
		$this->display();
		$_SESSION['grid'] = $this->grid;
		return $this->content;
	}
}

?>