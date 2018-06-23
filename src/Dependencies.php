<?php declare(strict_types=1);

use Auryn\Injector;
use PrPHP\Framework\Rendering\TemplateRenderer;
use PrPHP\Framework\Rendering\TwigTemplateRendererFactory;
use PrPHP\Framework\Rendering\TemplateDirectory;

use PrPHP\FrontPage\Application\SubmissionsQuery;
use PrPHP\FrontPage\Infrastructure\DbalSubmissionsQuery;
use Doctrine\DBAL\Connection;
use PrPHP\Framework\Dbal\ConnectionFactory;
use PrPHP\Framework\Dbal\DatabaseUrl;

$injector = new Injector();

$injector->alias(SubmissionsQuery::class, DbalSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);

$injector->delegate(
    TemplateRenderer::class,
    function () use ($injector): TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);

$injector->define(
    DatabaseUrl::class,
    [':url' => 'sqlite:///' . ROOT_DIR . '/storage/db.sqlite3']
);

$injector->share(Connection::class);

$injector->delegate(Connection::class, function () use ($injector): Connection {
    $factory = $injector->make(ConnectionFactory::class);
    return $factory->create();
});

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);

return $injector;