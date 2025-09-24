<?php

declare(strict_types=1);

namespace App\Tests;

use PaginatorBundle\PaginatorBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class BundleKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [
            new PaginatorBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../src/Resources/config/services.yml');
    }
}
