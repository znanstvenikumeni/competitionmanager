<?php
function handleError($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        return false;
    }

    switch ($errno) {
    case E_USER_ERROR:
        if($config->environment == 'development'){
            echo $errstr;
            echo $errfile;
            echo $errline;
        }
        include '../../views/errors/500.php';
        die();
        break;
    
    case E_USER_WARNING:
        if($config->environment == 'development'){
            echo $errstr;
            echo $errfile;
            echo $errline;
        }
        break;

    case E_USER_NOTICE:
        if($config->environment == 'development'){
            echo $errstr;
            echo $errfile;
            echo $errline;
        }
        break;

    default:
        if($config->environment == 'development'){
            echo $errstr;
            echo $errfile;
            echo $errline;
        }
        break;
    }

    return true;
}
//set_error_handler("handleError");