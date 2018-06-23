<?php declare(strict_types=1);

use Auryn\Injector;
use PrPHP\Framework\Rendering\TemplateRenderer;
use PrPHP\Framework\Rendering\TwigTemplateRendererFactory;
use PrPHP\Framework\Rendering\TemplateDirectory;

use PrPHP\FrontPage\Application\SubmissionsQuery;
use PrPHP\FrontPage\Infrastructure\MockSubmissionsQuery;

$injector = new Injector();

$injector->alias(SubmissionsQuery::class, MockSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);

$injector->delegate(
    TemplateRenderer::class,
    function () use ($injector): TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);

return $injector;