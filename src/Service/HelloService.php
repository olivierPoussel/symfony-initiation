<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class HelloService
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger) 
    {
        $this->logger = $logger;
    }

    public function hello()
    {
        $this->logger->debug("je suis dans le service Hello");

        return "hello";
    }
}
