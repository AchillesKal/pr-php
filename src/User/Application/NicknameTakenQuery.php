<?php declare(strict_types=1);

namespace PrPHP\User\Application;

interface NicknameTakenQuery
{
    public function execute(string $nickname): bool;
}