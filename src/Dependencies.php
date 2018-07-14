<?php declare(strict_types=1);
use Auryn\Injector;
use PrPHP\Framework\Rendering\TemplateRenderer;
use PrPHP\Framework\Rendering\TwigTemplateRendererFactory;
use PrPHP\Framework\Rendering\TemplateDirectory;
use Doctrine\DBAL\Connection;
use PrPHP\Framework\Dbal\ConnectionFactory;
use PrPHP\Framework\Dbal\DatabaseUrl;
use PrPHP\FrontPage\Infrastructure\DbalSubmissionsQuery;
use PrPHP\FrontPage\Application\SubmissionsQuery;
use PrPHP\Framework\Csrf\TokenStorage;
use PrPHP\Framework\Csrf\SymfonySessionTokenStorage;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use PrPHP\Submission\Domain\SubmissionRepository;
use PrPHP\Submission\Infrastructure\DbalSubmissionRepository;
use PrPHP\User\Domain\UserRepository;
use PrPHP\User\Infrastructure\DbalUserRepository;
use PrPHP\User\Application\NicknameTakenQuery;
use PrPHP\User\Infrastructure\DbalNicknameTakenQuery;
use PrPHP\Framework\Rbac\User;
use PrPHP\Framework\Rbac\SymfonySessionCurrentUserFactory;
$injector = new Injector();
$injector->delegate(
    TemplateRenderer::class,
    function () use ($injector): TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);
$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);
$injector->define(
    DatabaseUrl::class,
    [':url' => 'sqlite:///' . ROOT_DIR . '/storage/db.sqlite3']
);
$injector->delegate(Connection::class, function () use ($injector): Connection {
    $factory = $injector->make(ConnectionFactory::class);
    return $factory->create();
});
$injector->share(Connection::class);
$injector->alias(SubmissionsQuery::class, DbalSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);
$injector->alias(TokenStorage::class, SymfonySessionTokenStorage::class);
$injector->alias(SessionInterface::class, Session::class);
$injector->alias(SubmissionRepository::class, DbalSubmissionRepository::class);
$injector->alias(UserRepository::class, DbalUserRepository::class);
$injector->alias(NicknameTakenQuery::class, DbalNicknameTakenQuery::class);
$injector->delegate(User::class, function () use ($injector): User {
    $factory = $injector->make(SymfonySessionCurrentUserFactory::class);
    return $factory->create();
});
return $injector;