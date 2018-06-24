<?php declare(strict_types=1);

namespace PrPHP\User\Application;

use PrPHP\User\Domain\UserRepository;
use PrPHP\User\Domain\User;

final class RegisterUserHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterUser $command): void
    {
        $user = User::register(
            $command->getNickname(),
            $command->getPassword()
        );
        $this->userRepository->add($user);
    }
}