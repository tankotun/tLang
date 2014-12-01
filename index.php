<?php

/**
 * A simple tLang config file.
*/

# Require class file
require "tLang/tLang.class.php";

# Path
new tLang('langFiles');

# Active lang
tLang::set('lang', 'tr');

# Default lang
tLang::set('defaultLang', 'en');
