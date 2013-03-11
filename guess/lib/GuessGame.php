<?php
/**
 * A game of guessing. Turn numbers until you guess them all.
 *
 * @package Games
 * @subpackage Guess
 *
 * @author Vali Dumitru <vali.dumitru@webgearsoftware.com>
 * @version 1.0
 */
class GuessGame
{
	/**
	 * A representation of the empty board
	 *
	 * @var array
	 */
	protected $_board = null;
	
	/**
	 * The board width
	 *
	 * @var int
	 */
	protected $_boardWidth = null;
	
	/**
	 * The board height
	 *
	 * @var int
	 */
	protected $_boardHeight = null;
	
	/**
	 * A representation of the filled board
	 *
	 * @var array
	 */
	protected $_boardValues = null;
	
	/**
	 * Returns the board width
	 *
	 * @return int
	 */
	public function getBoardWidth()
	{
		return $this->_boardWidth;
	}
	
	/**
	 * Returns the board height
	 *
	 * @return int
	 */
	public function getBoardHeight()
	{
		return $this->_boardHeight;
	}
	
	/**
	 * Init object. Requires 2 parameters, width and height of the board
	 *
	 * @param int $width Defaults to 4
	 * @param int $height Defaults to 3
	 */
	public function __construct($width = 4, $height = 3)
	{
		$this->_initBoard($width, $height);
	}
	
	/**
	 * Resets the board, clearing all guesses
	 */
	public function resetBoard()
	{
		$this->_initBoard($this->getBoardWidth(), $this->getBoardHeight());
	}
	
	/**
	 * Inits the board with the given width and height
	 *
	 * @param int $width
	 * @param int $height
	 */
	private function _initBoard($width, $height)
	{
		if(($width * $height) % 2 != 0) throw new Exception('Board size must be an even number, you passed in ' . $width . 'x' . $height . '(' . ($width * $height) . ').');
		
		// Set internal width/height
		$this->_boardWidth = $width;
		$this->_boardHeight = $height;
		
		// Generate board values
		$this->_boardValues = array();
		
		$_initVals = range(1, ($this->getBoardWidth() * $this->getBoardHeight()) / 2);
		$_initVals = array_merge($_initVals, $_initVals);
		shuffle($_initVals);
		
		// Split values into groups
		$this->_boardValues = array_chunk($_initVals, $this->getBoardHeight());
		
		// Fill in board with values
		$this->_board = array();
		
		for($i = 0; $i < $width; $i++)
		{
			for($j = 0; $j < $height; $j++)
			{
				$this->_board[$i][$j] = $this->_boardValues[$i][$j];
			}
		}
		
		// Draw the board automatically
		$this->_drawBoard();
	}
	
	/**
	 * Builds the board HTML
	 *
	 * @param string $mode Defaults to 'echo', can also be 'return'
	 *
	 * @return mixed Nothing if $mode is echo, the HTML otherwise
	 */
	private function _drawBoard($mode = 'echo')
	{
		$html = '<table class="guess game"><tbody>' . "\n";
		
		for($i = 0; $i < $this->getBoardHeight(); $i++)
		{
			$html .= '<tr>' . "\n";
			
			for($j = 0; $j < $this->getBoardWidth(); $j++)
			{
				$html .= '<td><span class="number">' . $this->_board[$j][$i] . '</span>'/* . '<div class="mask"><a href="#">&nbsp;</a></div>'*/ . '</td>' . "\n";
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