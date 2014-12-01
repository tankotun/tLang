<?php 


/*************************************************************
*	
*	Simple PHP language management class.
*
*	Author			: Taner Tuncer
*	License			: GPL v2.0
*	Github Page		: https://github.com/tanertuncer/tLang
*	Github			: @tanertuncer
*	Twitter			: @tankotun
*
*************************************************************/


# Require autoload.php
require "autoload.php";

# Charset
header('Content-Type: text/html; charset=utf-8');

# Error 0
error_reporting(0);

class tLang extends tLangHandlers {


	/**
	 * setLang()
	 * Sets the language.
	 * @param string $type
	 * @param string $val
	 */
	public static function set ($type, $val) {

		switch ($type) {

			case "lang":
				parent::$selectedLang = $val;
			break;

			case "defaultLang":
				parent::$default_language = $val;
			break;

		}
		
	}


	/**
	 * get()
	 * Gets from $filesContent to selected param.
	 * @param string $value
	 * @param array $args
	 * @param string $filters
	 * @return $result
	 */
	public static function get ($value, array $args = null, $filters = null) {
		
		# Start Handler class
		$Handlers = new tLangHandlers;
		
		# Print result by Handlers Class
		return $Handlers->decompose($value)->getLangContent()->editVars($args)->filter($filters)->getResult();

	}

	
	/**
	 * updateVarFilesContent method
	 * Updates the parent $filesContent.
	 * @param string $path
	 */
	private function updateVarFilesContent ($path) {

		# Start FilesControl class
		$FilesControl = new tLangFilesControl;

		# Load files content
		$output = $FilesControl->loadFilesContent($path);

		# Set $output to $filesContent
		parent::$filesContent = $output;

	}


	/**
	 * __construct()
	 * Constructor calls to required methods.
	 * @param string $path
	 */
	public function __construct ($path) {

		if(empty($path))
			throw new tLangException('ep');

		# Update $filesContent
		$this->updateVarFilesContent($path);

	}	



}
