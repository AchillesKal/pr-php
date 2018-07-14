<?php declare(strict_types=1);

namespace PrPHP\Framework\Rbac\Role;

use PrPHP\Framework\Rbac\Permission\SubmitLink;
use PrPHP\Framework\Rbac\Role;

final class Author extends Role
{
    protected function getPermissions(): array
    {
        return [new SubmitLink()];
    }
}