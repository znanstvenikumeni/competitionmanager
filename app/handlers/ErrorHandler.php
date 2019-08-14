<?php
function handleError($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        return false;
    }

    switch ($errno) {
    case E_USER_ERROR:
        include '../../views/errors/500.php';
        die();
        break;
    
    case E_USER_WARNING:
        break;

    case E_USER_NOTICE:
        break;

    default:
        break;
    }

    return true;
}
set_error_handler("handleError");