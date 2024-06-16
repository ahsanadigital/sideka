<?php

namespace App\Helpers;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Helper class to write different types of messages to the console.
 */
class ConsoleHelper
{
    /**
     * @var OutputInterface The console output interface.
     */
    private static OutputInterface $output;

    /**
     * Initialize the console output interface.
     */
    public static function init(): void
    {
        if (!isset(self::$output)) {
            self::$output = new ConsoleOutput();
        }
    }

    public static function createProgressbar(?int $total = 100)
    {
        return new \Symfony\Component\Console\Helper\ProgressBar(self::$output, $total);
    }

    /**
     * Write an info message to the console.
     *
     * @param string $message The info message to write.
     */
    public static function info(string $message): void
    {
        self::init();
        self::$output->writeln("  \033[44m INFO \033[0m $message\n");
    }

    /**
     * Write a success message to the console.
     *
     * @param string $message The success message to write.
     */
    public static function success(string $message): void
    {
        self::init();
        self::$output->writeln("  \033[30;42m SUCCESS \033[0m $message\n"); // Using <comment> for success
    }

    /**
     * Write an error message to the console.
     *
     * @param string $message The error message to write.
     */
    public static function error(string $message): void
    {
        self::init();
        self::$output->writeln("  \033[41m ERROR \033[0m $message\n");
    }

    /**
     * Write a warning message to the console.
     *
     * @param string $message The warning message to write.
     */
    public static function warning(string $message): void
    {
        self::init();
        self::$output->writeln("  \033[43m SUCCESS \033[0m $message\n");
    }
}
