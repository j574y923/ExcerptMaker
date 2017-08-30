<?php

/**
 * 
 * Use regex and various string functions to create two excerpts from a text based on search terms. 
 * Note: regex only accounts for whole-word matches and ignores case, it does not account for plural or other stuff...
 * PHP Version 5.4
 *
 * @author j574y923
 * 
 */
class ExcerptMaker
{
	/**
	 * Text to create two excerpts from. Set this!
	 *
	 * @var string
	 */
	public $Text = '';	

	/**
	 * Search terms that will be delineated with ' '. Set this!
	 *
	 * @var string
	 */
	public $SearchTermsString = '';

	/**
	 * Search terms that will be delineated by array structure. Set this maybe?? (idk yet)...
	 *
	 * @var array
	 */
	public $SearchTermsArray = [];

	/** 
	 * Flag to check if $SearchTermsArray is set...  
	 *
	 * @var boolean
	 */
	private $SearchTermsArrayFlag = false;

	/**
	 * Index of the last-made matching term.
	 *
	 * @var integer
	 */
	public $IndexMatch = 0;

	/**
	 * Split $Text at the $IndexMatch to form the before string and after string. 
	 *
	 * @var string
	 */
	private $ExcerptBeforeString = '';

	/**
	 * Split $Text at the $IndexMatch to form the before string and after string. 
	 *
	 * @var string
	 */
	private $ExcerptAfterString = '';

	/**
	 * before string to array
	 *
	 * @var array
	 */
	private $ExcerptBeforeStringArray = [];

	/**
	 * after string to array
	 *
	 * @var array
	 */
	private $ExcerptAfterStringArray = [];

	/**
	 * The stored excerpt one. Get this!
	 *
	 * @var string
	 */
	public $Excerpt1 = '';

	/**
	 * The stored excerpt two. Get this!
	 *
	 * @var string
	 */
	public $Excerpt2 = '';

	/**
	 * The number of words to extend out before and after matched term.
	 *
	 * @var int
	 */
	public $ExcerptSize = '8';

	/**
	 * Make two excerpts given $Text, and $SearchTermsString.
	 *
	 */
	public function MakeTwoExcerpts() 
	{
		$this->SearchTermsArray = explode(' ', $this->SearchTermsString);
		$this->SearchTermsArrayFlag = true;

		MakeOneExcerpt();
		$this->Excerpt2 = $this->Excerpt1;
		MakeOneExcerpt();
	}

	/**
	 * Make one excerpt given $Text, and $SearchTermsString. Store it in $Excerpt1
	 *
	 */
	public function MakeOneExcerpt() 
	{
		if($this->SearchTermsArrayFlag === false) {
			$this->SearchTermsArray = explode(' ', $this->SearchTermsString);
		}

		//1. regex match to get $IndexMatch.
		preg_match_all('/\b('.implode('|', $this->SearchTermsArray).')\b/i', $this->Text, $matches, PREG_OFFSET_CAPTURE);

		$this->IndexMatch = $matches[0][1];

		//2. split string at $IndexMatch
		$this->ExcerptBeforeString = substr($this->Text, 0, $this->IndexMatch);
		$this->ExcerptAfterString = substr($this->Text, $this->IndexMatch, strlen($this->Text));

		//3. get the last 8 words of before string, get the first 9 words of the after string
		$this->ExcerptBeforeStringArray = explode(' ', $this->ExcerptBeforeString);
		if(count($this->ExcerptBeforeStringArray) <= $this->ExcerptSize) {
			$ellipses_beginning = '';
		} else {
			$ellipses_beginning = '...';
		}
		$this->Excerpt1 = $ellipses_beginning .  
			implode(' ', array_slice($this->ExcerptBeforeStringArray, max(0, count($this->ExcerptBeforeStringArray) - $this->ExcerptSize), count($this->ExcerptBeforeStringArray)));

		$this->ExcerptAfterStringArray = explode(' ', $this->ExcerptAfterString);
		if(count($this->ExcerptAfterStringArray) <= $this->ExcerptSize + 1) {
			$ellipses_ending = '';
		} else {
			$ellipses_ending = '...';
		}
		$excerpt_temp = 
			implode(' ', array_slice($this->ExcerptAfterStringArray, 0, min($this->ExcerptSize + 1, count($this->ExcerptAfterStringArray)))) . $ellipses_ending;

		//4. Form excerpt
		$this->Excerpt1 .= $excerpt_temp;

	}
}

?>
