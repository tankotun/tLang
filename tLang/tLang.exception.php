<?php

class tLangException extends Exception {

	/**
	 * Constructor
	 * @param string $code
	 * @param string $other
	 */
	public function __construct ($code, $other) {

		switch ($code) {

			# Not directory (fatal error)
			case "nd":
				echo "<b>[[tLang Fatal Error: </b>'" . $other . "' must be a directory.<b>]]</b>";
			break;

			# Invalid directory (fatal error)
			case "id":
				echo "<b>[[tLang Fatal Error: </b>'" . $other . "' directory not found.<b>]]</b>";
			break;

			# Not supported function
			case "nsf":
				echo "<b>[[tLang Error: </b>Not supported '" . $other . "()' function in filter.<b>]]</b>";
			break;

			# Posted empty value
			case "pev":
				echo "<b>[[tLang Error: </b>Enter a value in 'get()' method.<b>]]</b>";
			break;

			# Empty path (fatal error)
			case "ep":
				echo "<b>[[tLang Fatal Error: </b>Enter language files' directory path.<b>]]</b>";
			break;

			# Value data empty (in language files).
			case 'uv':
				echo '<b>[[tLang Error: </b>Undefined value. Please check language files.<b>]]</b>';
			break;

		}

		

	}

}
