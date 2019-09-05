<?php

namespace App\Lib;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class Log
{

    private $logger;
    public function __construct()
    {
        $this->logger = new Logger(env('APP_ENV', 'locale'));
        $this->setHandler();
    }

    public function setHandler($path = null)
    {
        $log = Config::get('app.log');
        if ($path === null) {
            $path = $log['path'];
        }
        if ($this->logger->getHandlers()) {
            $this->logger->popHandler();
        }
        $handler =  new RotatingFileHandler($path, $log['max_files'], $log['level']);
        $handler->setFormatter(new LineFormatter("%message%\n"));
        $this->logger->pushHandler($handler);
        return $this;
    }

    private function writeLog($level, $message, array $context = [])
    {
        $message = ['server_ts' => Carbon::now()->timestamp, 'message' => $message, 'context' => $context];
        $message = json_encode($message);
        return $this->logger->log($level, $message);
    }

    public function emergency($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->writeLog($level, $message, $context);
    }

}
