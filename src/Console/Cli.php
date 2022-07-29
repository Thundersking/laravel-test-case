<?php

namespace Vion\TestCase\Console;

use Codedungeon\PHPCliColors\Color;

trait Cli
{
    /**
     * Console info message
     * @param string $message
     * @param string $color
     */
    public function info($message)
    {
        echo Color::CYAN, $message;
        echo  PHP_EOL;
    }

    /**
     * Console info message
     * @param string $message
     * @param string $color
     */
    public function error($message)
    {
        echo Color::RED, $message;
        echo  PHP_EOL;
    }

    /**
     * Console info message
     * @param string $message
     * @param string $color
     */
    public function success($message)
    {
        echo Color::GREEN, $message;
        echo  PHP_EOL;
    }

    /**
     * Console info message
     * @param string $message
     * @param string $color
     */
    public function warning($message)
    {
        echo Color::YELLOW, $message;
        echo  PHP_EOL;
    }
}
