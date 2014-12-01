<?php

/**
 * A simple tLang config file.
*/

# Require class file
require "tLang/tLang.class.php";

# Path
new tLang('LANG_FILES_DIR_PATH');

# Active lang
tLang::set('lang', 'SELECTED_LANG');

# Default lang
tLang::set('defaultLang', 'DEFAULT_LANG');
