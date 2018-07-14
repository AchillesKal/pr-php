<?php declare(strict_types=1);

namespace PrPHP\Framework\Rbac;

interface CurrentUserFactory
{
    public function create(): User;
}