<?php

session_start();
include_once("gol.php");

$gol = new Game_Of_Life( (isset($_GET['grid_size']) )? $_GET['grid_size'] : null );

?>

<table cellpadding='0' cellspacing='0' border='0'>
	<?php
		echo (isset($_GET['action']) && $_GET['action'] == "update")? $gol->update() : null;
	?>
</table>