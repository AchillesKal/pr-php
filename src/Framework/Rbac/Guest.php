<?php declare(strict_types=1);

namespace PrPHP\Framework\Rbac;

final class Guest implements User
{
    public function hasPermission(Permission $permission): bool
    {
        return false;
    }
}