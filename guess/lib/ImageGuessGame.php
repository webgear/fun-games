<?php

class ImageGuessGame extends GuessGame
{
	protected $_images = null;
	
	public function setImages($images)
	{
		$expectedElemsNo = ($this->getBoardWidth() * $this->getBoardHeight()) / 2;
		
		if(count($images) != $expectedElemsNo) throw new Exception('Expected ' . $expectedElemsNo . ' images, got ' . count($images) . '(ImageGuessGame::setImages).');
		
		$images = array_merge($images, $images);
		shuffle($images);
		
		$this->_images = array_chunk($images, $this->getBoardHeight());
		
		return $this;
	}
	
	/**
	 * Builds the board HTML
	 *
	 * @param string $mode Defaults to 'echo', can also be 'return'
	 *
	 * @return mixed Nothing if $mode is echo, the HTML otherwise
	 */
	public function drawBoard($mode = 'echo')
	{
		$html = '<table class="guess image game"><tbody>' . "\n";
		
		for($i = 0; $i < $this->getBoardHeight(); $i++)
		{
			$html .= '<tr>' . "\n";
			
			for($j = 0; $j < $this->getBoardWidth(); $j++)
			{
				$html .= '<td><p><img src="' . $this->_images[$j][$i] . '" alt="" /></p></td>' . "\n";
			}
			
			$html .= '</tr>' . "\n\n";
		}
		
		$html .= '</tbody></table>' . "\n";
		
		switch($mode)
		{
			case 'return':
				return $html;
			break;
			
			case 'echo':
			default:
				echo $html;
			break;
		}
	}
}