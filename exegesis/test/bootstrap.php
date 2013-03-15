<?php

/*
 * Bootstrap to setup autoloading for the tests run by
 * phpunit
 */

set_include_path(get_include_path() . PATH_SEPARATOR . "../../" . PATH_SEPARATOR . "../");
spl_autoload_extensions('.php');
spl_autoload_register('spl_autoload');
