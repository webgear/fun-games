<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Games: Guess</title>
		
		<link rel="stylesheet" type="text/css" href="res/game.css" />
	</head>
	
	<body>
		<?php

		require_once 'lib/GuessGame.php';
		require_once 'lib/ImageGuessGame.php';
		
		$_bwidth = 5;
		$_bheight = 4;
		$_regularGame = 'numbers';
		$game_class = 'GuessGame';
		
		if(isset($_GET['bw']) === true && $_GET['bw'] > 0) $_bwidth = intval($_GET['bw']);
		if(isset($_GET['bh']) === true && $_GET['bh'] > 0) $_bheight = intval($_GET['bh']);
		if(isset($_GET['type']) === true && $_GET['type'] != '') $_regularGame = $_GET['type'] == 'images' ? 'images' : 'numbers';

		if(isset($_GET['type']) === true && $_GET['type'] == 'images')
		{
			$game_class = 'ImageGuessGame';
		}

		try
		{
			$game = new $game_class($_bwidth, $_bheight);
			
			if(isset($_GET['type']) === true && $_GET['type'] == 'images')
			{
				$_imgs = array();
				$_max = ($_bwidth * $_bheight) / 2;
				
				foreach(glob('res/img/imagegame/*.*') as $_idx => $_filename)
				{
					if($_idx+1 > $_max) break;
					
					$_imgs[] = $_filename;
				}
				
				$game->setImages($_imgs);
			}
			
			$game->drawBoard();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			exit;
		}
?>
		<?php if(isset($_GET['type']) === false || $_GET['type'] != 'images'): ?><p style="text-align:center;"><a href="?bw=<?php echo $_bwidth; ?>&amp;bh=<?php echo $_bheight; ?>&amp;type=images">Play with images instead of numbers!</a></p><?php endif; ?>
		<form method="get" action="" class="changeSize">
			<fieldset>
				<p>
					<label for="size-bw">Width:</label>
					<input type="text" name="bw" id="size-bw" value="<?php echo $_bwidth; ?>" />
					<label for="size-bh">Height:</label>
					<input type="text" name="bh" id="size-bh" value="<?php echo $_bheight; ?>" />
					<select name="type">
						<option value="default">Game type</option>
						<option value="numbers">numbers</option>
						<option value="images">images</option>
					</select>
					<input type="submit" value="Update board" />
				</p>
			</fieldset>
		</form>
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="res/game.js"></script>
	</body>
</html>