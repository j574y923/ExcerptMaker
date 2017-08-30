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
		$SearchTermsArray = explode(' ', $SearchTermsString);
		$SearchTermsArrayFlag = true;

		MakeOneExcerpt();
		$Excerpt2 = $Excerpt1;
		MakeOneExcerpt();
	}

	/**
	 * Make one excerpt given $Text, and $SearchTermsString. Store it in $Excerpt1
	 *
	 */
	public function MakeOneExcerpt() 
	{
		if($SearchTermsArrayFlag === false) {
			$SearchTermsArray = explode(' ', $SearchTermsString);
		}

		//1. regex match to get $IndexMatch.
		preg_match_all('/\b('.implode('|', $SearchTermsArray).')\b/i', $Text, $matches, PREG_OFFSET_CAPTURE);

		$IndexMatch = $matches[0][1];

		//2. split string at $IndexMatch
		$ExcerptBeforeString = substr($Text, 0, $IndexMatch);
		$ExcerptAfterString = substr($Text, $IndexMatch, strlen($Text));

		//3. get the last 8 words of before string, get the first 9 words of the after string
		$ExcerptBeforeStringArray = explode(' ', $ExcerptBeforeString);
		if(count($ExcerptBeforeStringArray) <= $ExcerptSize) {
			$ellipses_beginning = '';
		} else {
			$ellipses_beginning = '...';
		}
		$Excerpt1 = $ellipses_beginning .  
			implode(' ', array_slice($ExcerptBeforeStringArray, max(0, count($ExcerptBeforeStringArray) - $ExcerptSize), count($ExcerptBeforeStringArray)));

		$ExcerptAfterStringArray = explode(' ', $ExcerptAfterString);
		if(count($ExcerptAfterStringArray) <= $ExcerptSize + 1) {
			$ellipses_ending = '';
		} else {
			$ellipses_ending = '...';
		}
		$excerpt_temp = 
			implode(' ', array_slice($ExcerptAfterStringArray, 0, min($ExcerptSize + 1, count($ExcerptAfterStringArray)))) . $ellipses_ending;

		//4. Form excerpt
		$Excerpt1 .= $excerpt_temp;

	}
}

?>
