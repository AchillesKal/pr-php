<?php declare(strict_types=1);

namespace PrPHP\User\Domain;

interface UserRepository
{
    public function add(User $user): void;

    public function save(User $user): void;

    public function findByNickname(string $nickname): ?User;
}