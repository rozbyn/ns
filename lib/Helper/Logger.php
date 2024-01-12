<?php

namespace RozbynDev\Helper;

class Logger
{


    protected static Logger $lastLogger;

    /**
     * @return Logger
     */
    public static function getLastLogger(): Logger
    {
        return self::$lastLogger;
    }
    protected static int $calledTimes = 0;

    public function __construct(
        protected string $filePath,
        protected string $logType = 'text'
    ) {
        self::$lastLogger = $this;
    }


    public function log(...$vars): void
    {
        self::$calledTimes++;
        ob_start();
        echo $this->makeLogTitle();
        foreach ($vars as $var) {
            var_dump($var);
            if ((is_string($var) && class_exists($var)) || is_object($var)) {
                $methods = get_class_methods($var);
                if (!empty($methods)) {
                    var_dump($methods);
                }
            }
        }
        $dumps = ob_get_clean();
        $flags = (
            file_exists($this->filePath)
            && (
                (time() - @filemtime($this->filePath) < 5)
                || self::$calledTimes > 1
            )
        ) ? FILE_APPEND : 0;
        file_put_contents($this->filePath, $dumps, $flags);
    }


    protected function makeLogTitle(): string
    {
        $dbug_bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $debug_bt_file = $dbug_bt[1]['file'];
        $debug_bt_line = $dbug_bt[1]['line'];
        return PHP_EOL . PHP_EOL . date('H:i:s d.m.Y') . ' Called from: ' .
            $debug_bt_file . ' line: ' . $debug_bt_line . PHP_EOL . PHP_EOL;
    }

}
