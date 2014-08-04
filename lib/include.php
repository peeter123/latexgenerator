<?php
class Logger
{
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const CRITICAL = 'CRITICAL';
}

/**
 * Compile the given file
 *
 * @param string $file
 */
function compile($file) 
{
    $bash = 'latexmk -pdf -silent \'%s\' -gg 2>&1';
    $output = null;
    $response = exec(sprintf($bash, $file));
    exec(__DIR__.'/ppdflatex -q --input tmp.log', $output);
    array_pop($output);
    foreach ($output as $line) {
        println($line, \Logger::INFO);
    }
    return $response;
}

/**
 * Other stuff needs to be defined
 */
define('ROOT', dirname(dirname(__FILE__)));

spl_autoload_register(function($class) 
{
    $dir = ROOT . '/lib/';
    $file = str_replace('\\', '/', $class) . '.php';
    
    if ( ! file_exists($dir . $file)) {
        throw new Exception('Could not load class ' . $class . ', the file was not found');
    }
    
    require_once($dir . $file);
    
    if ( ! class_exists($class, false) && ! interface_exists($class, false)) {
        throw new Exception('Could not load class ' . $class . ', the file was found, but the class was not in there');
    }
});


function println($line, $level = Logger::INFO)
{
    $logLine = '[' . strftime('%d-%m-%Y %H:%M:%S', time()) . '] ' . $line . PHP_EOL;
    switch($level) {
        case Logger::CRITICAL:
            $logLine = Colors::getColoredString($logLine, 'red');
            break;
        case Logger::WARNING:
            $logLine = Colors::getColoredString($logLine, 'yellow');
            break;
        case Logger::INFO:
            $logLine = Colors::getColoredString($logLine, 'green');
            break;
        case Logger::DEBUG:
            $logLine = Colors::getColoredString($logLine, 'light_cyan');
            break;
        default:
            break;
    }
    print($logLine);
}

function errorln($line)
{
    println($line, Logger::CRITICAL);
}

function error($line)
{
    errorln($line);
}

