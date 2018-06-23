<?php declare(strict_types=1);

use Auryn\Injector;
use PrPHP\Framework\Rendering\TemplateRenderer;
use PrPHP\Framework\Rendering\TwigTemplateRendererFactory;
use PrPHP\Framework\Rendering\TemplateDirectory;

$injector = new Injector();

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);

$injector->delegate(
    TemplateRenderer::class,
    function () use ($injector): TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);

return $injector;