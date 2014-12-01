<?php

function __autoload ($class) {

	$paths = array(
		'tLangException'	=> 'tLang.exception.php',
		'tLangFilesControl'	=> 'tLang.filesControl.php',
		'tLangHandlers'		=> 'tLang.handlers.php'
	);

	require $paths[$class];

}
