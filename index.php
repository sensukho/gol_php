<?php

session_start();
include_once("gol.php");

$gol = new Game_Of_Life( 50 );

?>

<html>
	<head>
		<title>Game of Life | PHP</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<style>
			*{
				font-size: 10px;
			}
			table tr td {
				width: 9px;
				height: 9px;
				font-size: 1px;
				border: 1px solid #CCC;
			}
			.living_cell{
				background-color: black;
			}
			.dead_cell{
				background-color: white;
			}
		</style>
		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js'></script>
		<script>
			function refresh() {
				var page = $.ajax({
					url: 'grid.php?action=update&grid_size=<?php echo $gol->grid_size; ?>',
					type: 'html',
					async: false
				}).responseText;
				$('#content').html(page);
			}
			setInterval('refresh()', 500);
		</script>
	</head>
	<body>
		<div id='content'>
			<table cellpadding='0' cellspacing='0' border='0'>
				<?php echo $gol->start(); ?>
			</table>
		</div>
	</body>
</html>