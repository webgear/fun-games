<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Games: Guess</title>
		
		<link rel="stylesheet" type="text/css" href="game.css" />
	</head>
	
	<body>
		<?php

		require_once 'lib/GuessGame.php';
		
		$_bwidth = 5;
		$_bheight = 4;
		
		if(isset($_GET['bw']) && $_GET['bw'] > 0) $_bwidth = intval($_GET['bw']);
		if(isset($_GET['bh']) && $_GET['bh'] > 0) $_bheight = intval($_GET['bh']);

		try
		{
			$game = new GuessGame($_bwidth, $_bheight);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}

		/*
		echo '<pre>';
		print_r($game);
		*/
?>
		<form method="get" action="" class="changeSize">
			<fieldset>
				<p>
					<label for="size-bw">Width:</label>
					<input type="text" name="bw" id="size-bw" value="<?php echo $_bwidth; ?>" />
					<label for="size-bh">Height:</label>
					<input type="text" name="bh" id="size-bh" value="<?php echo $_bheight; ?>" />
					<input type="submit" value="Change board size" />
				</p>
			</fieldset>
		</form>
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="game.js"></script>
	</body>
</html>