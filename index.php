<?php

require_once(dirname(__FILE__) . '/lib/include.php');

// get working dir
$base = getcwd();

if ($base === null) {
    error('Could not find working directory');
    die();
}

$command = new Console\ParseCommand($argv);

$command->execute();

try {
    $command->execute();
} catch (Exception $e) {
    error($e->getMessage());
}

// go back to working dir
chdir($base);
