<?php declare(strict_types=1);

namespace PrPHP\User\Application;

use PrPHP\User\Domain\UserRepository;

final class LogInHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(LogIn $command): void
    {

    }
}