<?php

declare(strict_types=1);

namespace App\Tests\DependencyInjection;

use PaginatorBundle\DependencyInjection\PaginatorExtension;
use PaginatorBundle\Request\ValueResolver\OffsetPaginatorValueResolver;
use PaginatorBundle\Request\ValueResolver\PagePaginatorValueResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigurationTest extends TestCase
{
    public function testConfiguration(): void
    {
        $extension = new PaginatorExtension();

        $containerBuilder = new ContainerBuilder();

        $this->assertFalse($containerBuilder->hasDefinition(OffsetPaginatorValueResolver::class));

        $extension->load([], $containerBuilder);
        $this->assertTrue($containerBuilder->hasDefinition(OffsetPaginatorValueResolver::class));
        $this->assertTrue($containerBuilder->hasDefinition(PagePaginatorValueResolver::class));
        $this->assertTrue($containerBuilder->hasParameter('paginator_defaults_limit'));
    }
}
