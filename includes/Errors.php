<?php namespace Joonika;
if(!defined('jk')) die('Access Not Allowed !');

class Errors
{

    public static function errorHandler($level, $message, $file, $line)
    {
        if (JK_APP_DEBUG==true) {
            $log = JK_SITE_PATH . 'storage/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);
            error_log($message);
        }
            if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }

    }




    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }

        http_response_code($code);
        if (JK_APP_DEBUG==false) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message : '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace: <pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {
            $log = JK_SITE_PATH . 'storage/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = "\n<h1>Fatal error</h1>\n";
            $message .= "<p>Uncaught exception: '" . get_class($exception) . "'</p>\n";
            $message .= "<p>Message : '" . $exception->getMessage() . "'</p>\n";
            $message .= "<p>Stack trace: <pre>" . $exception->getTraceAsString() . "</pre></p>\n";
            $message .= "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>\n";
            $message .= "----------------------------------------------------------\n";
            error_log($message);
            echo $message;
        }

    }

}