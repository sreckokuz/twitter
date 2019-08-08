<?php
/**
 * Created by PhpStorm.
 * User: sreckokuzmanovic
 * Date: 02/08/2019
 * Time: 08:46
 */

namespace App\Services;


use Psr\Log\LoggerInterface;

class Greeting
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function greet(string $name): string {
        $this->logger->info($name);
        return "Hello ". $name;
    }

}