<?php

/**
 * tLangHandlers Class
 */
class tLangHandlers extends tLangException {

	/**
	 * @var string $default_language
	 */
	protected static $default_language;


	/**
	 * @var string $selectedLang
	 */
	protected static $selectedLang;


	/**
	 * @var array $filesContent
 	 */
	protected static $filesContent;


	/**
	 * Chain methods content
	 * @var string $chainMethodsContent
	 */
	protected $chainMethodsContent = null;


	/**
	 * Chain Method: getResult()
	 * @return string $chainMethodsContent
	 */
	public function getResult () {

		# Print string $chainMethodsContent
		echo $this->chainMethodsContent;

		return $this;

	}


	/**
	 * Chain Method: filter()
	 * @param string $filter
	 */
	public function filter ($filters = null) {
		
		# If filters are empty
		if(empty($filters))
			return $this;

		# Explode wanted functions
		$explode = explode(',', $filters);

		# Supported functions
		$supported = array('stripslashes', 'htmlspecialchars');

		# Will come filtered new content
		$filtered = null;

		# Counter for foreach
		$i = 0;

		foreach ($explode as $key => $value) {
			
			if(in_array(trim($value), $supported)) {
			
				# Plus $i for counter
				$i++;

				# Filtered by trim function names
				$trim_func = trim($explode[$key]);

				# Query: filters with wanted functions
				$query = $i === 1 ? $trim_func($this->chainMethodsContent) : $trim_func($filtered);

				# Add to $filtered
				$filtered = $query;

			} else {

				throw new tLangException('nsf', trim($explode[$key]));

			}

		}

		$this->chainMethodsContent = $filtered;

		return $this;

	}


	/**
	 * Chain Method: editVars()
	 * @param array args
	 */
	public function editVars (array $args = null) {
		
			# array $newKeys
			$newKeys = array();

			if(empty($args))
				return $this;

			# Read @param array $args
			foreach ($args as $key => $value) {

				# Check regex code
				if(!preg_match('/([^_a-zA-Z])/', $key)) {

					# Add prefix '--' and '--'
					$addPrefix = '--' . $key . '--';

					# Add added prefix keys to array
					$newKeys[$addPrefix] = $value;
					
				}

			}
		

		# Update string $chainMethodsContent to replaced vars
		$this->chainMethodsContent = strtr($this->chainMethodsContent, $newKeys);
		
		return $this;

	}


	/**
	 * Chain Method: getLangContent()
	 */
	public function getLangContent () {

		switch($this->chainMethodsContent["type"]){


			# Block
			case "block":

				$getBlock	= array_column(self::$filesContent, $this->chainMethodsContent["object1"]);
			
				if($this->chainMethodsContent["colonQuery"] === 1) {

					$colon		= is_numeric($this->chainMethodsContent["colon"]) ? $this->chainMethodsContent["colon"] - 1 : $this->chainMethodsContent["colon"];
					@$result	= empty($getBlock[0][self::$selectedLang][$colon]) ? $getBlock[0][self::$default_language][$colon] : $getBlock[0][self::$selectedLang][$colon];
				
				} else {

					@$result	= empty($getBlock[0][self::$selectedLang]) ? $getBlock[0][self::$default_language] : $getBlock[0][self::$selectedLang];
				
				}

				if(empty($result))
					throw new tLangException('uv');
					

				# Print result
				$this->chainMethodsContent = $result;

			break;


			# Zone
			case "zone":

				$getZone	= array_column(self::$filesContent, $this->chainMethodsContent["object1"]);
				$getBlock	= array_column($getZone, $this->chainMethodsContent["object2"]);
				
				# Colon control
				if($this->chainMethodsContent["colonQuery"] === 1) {

					$colon		= is_numeric($this->chainMethodsContent["colon"]) ? $this->chainMethodsContent["colon"] - 1 : $this->chainMethodsContent["colon"];
					@$result	= empty($getBlock[0][self::$selectedLang][$colon]) ? $getBlock[0][self::$default_language][$colon] : $getBlock[0][self::$selectedLang][$colon];
				
				} else {

					@$result	= empty($getBlock[0][self::$selectedLang]) ? $getBlock[0][self::$default_language] : $getBlock[0][self::$selectedLang];
				
				}

				if(empty($result))
					throw new tLangException('uv');

				# Print result
				$this->chainMethodsContent = $result;

			break;


		}

		return $this;

	}


	/**
	 * Chain Method: decompose()
	 * Decompose param
	 * @param string $value
	 */
	public function decompose ($value) {

		# If value is empty:
		if (empty($value))
			throw new tLangException('pev');

		# Dot explode
		$dotExplode = explode('.', $value);

		# How many blocks in $value
		$dotCount = count($dotExplode);

		# Colon Explode
		$colonExplode = explode(':', end($dotExplode));

		if(empty($colonExplode[1])) {

			$colonQuery		= 0;
			$lastObject		= end($dotExplode);
			$colonObject	= 0;
		
		} else {

			$colonNumber	= strlen($colonExplode[1]) + 1;

			$colonQuery		= 1;
			$lastObject		= substr(end($dotExplode), 0, -$colonNumber);
			$colonObject	= $colonExplode[1];

		}

		# Switch by count
		switch ($dotCount) {

			case 1:
				# Return
				$this->chainMethodsContent = array(
					'type'		=> 'block',
					'object1'	=> $lastObject,
					'colonQuery'=> $colonQuery,
					'colon'		=> $colonObject
				);
			break;

			case 2:
				# Return
				$this->chainMethodsContent = array(
					'type'		=> 'zone',
					'object1'	=> $dotExplode[0],
					'object2'	=> $lastObject,
					'colonQuery'=> $colonQuery,
					'colon'		=> $colonObject
				);
			break;

			default:
				echo 'tLang Class: Undefinded value!';
			break;

		}
		
	return $this;

	}


	# Ignore constructor...
	public function __construct () {}
	
}
