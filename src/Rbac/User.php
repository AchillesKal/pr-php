<?php declare(strict_types=1);

namespace PrPHP\Framework\Rbac;

interface User
{
    public function hasPermission(Permission $permission): bool;
}